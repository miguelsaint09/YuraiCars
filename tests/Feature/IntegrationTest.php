<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IntegrationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Prueba de Integración: Flujo completo de registro y login de usuario
     * @test
     */
    public function test_complete_user_registration_and_login_flow()
    {
        // 1. Registrar un nuevo usuario
        $userData = [
            'name' => 'Integration Test User',
            'email' => 'integration@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ];

        $registerResponse = $this->post('/sign-up', $userData);
        $registerResponse->assertRedirect('/profile');

        // 2. Verificar que el usuario fue creado en la base de datos
        $this->assertDatabaseHas('users', [
            'name' => 'Integration Test User',
            'email' => 'integration@test.com'
        ]);

        // 3. Logout del usuario
        $logoutResponse = $this->post('/sign-out');
        $logoutResponse->assertRedirect('/');

        // 4. Login con las credenciales del usuario registrado
        $loginResponse = $this->post('/sign-in', [
            'email' => 'integration@test.com',
            'password' => 'password123'
        ]);

        $loginResponse->assertRedirect('/profile');
        $this->assertAuthenticated();
    }

    /**
     * Prueba de Integración: Flujo completo de navegación y exploración de vehículos
     * @test
     */
    public function test_complete_vehicle_browsing_flow()
    {
        // 1. Crear vehículos de prueba
        $vehicles = Vehicle::factory()->count(5)->create();

        // 2. Visitar página de inicio
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);

        // 3. Navegar a la página de vehículos
        $vehiclesResponse = $this->get('/vehicles');
        $vehiclesResponse->assertStatus(200);

        // 4. Verificar que muestra los vehículos
        foreach ($vehicles->take(3) as $vehicle) {
            $vehiclesResponse->assertSee($vehicle->name ?? 'Vehicle');
        }
    }

    /**
     * Prueba de Integración: Flujo completo de contacto
     * @test
     */
    public function test_complete_contact_flow()
    {
        // 1. Visitar página de contacto
        $contactPageResponse = $this->get('/contact');
        $contactPageResponse->assertStatus(200);

        // 2. Llenar y enviar formulario de contacto
        $contactData = [
            'name' => 'Test Contact User',
            'email' => 'contact@test.com',
            'subject' => 'Integration Test Subject',
            'message' => 'This is an integration test message'
        ];

        $submitResponse = $this->post('/contact', $contactData);

        // 3. Verificar redirección y mensaje de éxito
        $submitResponse->assertRedirect('/contact')
                      ->assertSessionHas('success', '¡Gracias por tu mensaje! Te contactaremos pronto.');

        // 4. Verificar que vuelve a la página de contacto con el mensaje
        $followUpResponse = $this->get('/contact');
        $followUpResponse->assertStatus(200)
                        ->assertSee('¡Gracias por tu mensaje!');
    }

    /**
     * Prueba de Integración: Flujo de autenticación y acceso a áreas protegidas
     * @test
     */
    public function test_authentication_and_protected_areas_flow()
    {
        $user = User::factory()->create();

        // 1. Intentar acceder a área protegida sin autenticación
        $protectedResponse = $this->get('/profile');
        $protectedResponse->assertRedirect('/sign-in');

        // 2. Autenticarse
        $this->actingAs($user);

        // 3. Acceder a áreas protegidas
        $profileResponse = $this->get('/profile');
        $profileResponse->assertStatus(200);

        $rentsResponse = $this->get('/rents');
        $rentsResponse->assertStatus(200);

        // 4. Logout y verificar pérdida de acceso
        $logoutResponse = $this->post('/sign-out');
        $logoutResponse->assertRedirect('/');

        $afterLogoutResponse = $this->get('/profile');
        $afterLogoutResponse->assertRedirect('/sign-in');
    }

    /**
     * Prueba de Integración: Flujo completo de reseñas de vehículos
     * @test
     */
    public function test_complete_vehicle_review_flow()
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create();

        // 1. Intentar dejar reseña sin estar autenticado
        $unauthenticatedReviewResponse = $this->post("/vehicles/{$vehicle->id}/review", [
            'rating' => 5,
            'comment' => 'Great vehicle!'
        ]);
        $unauthenticatedReviewResponse->assertRedirect('/sign-in');

        // 2. Autenticarse y dejar reseña
        $this->actingAs($user);

        $reviewResponse = $this->post("/vehicles/{$vehicle->id}/review", [
            'rating' => 5,
            'comment' => 'Excellent vehicle for road trips!'
        ]);

        // 3. Verificar que la reseña fue creada
        $this->assertDatabaseHas('reviews', [
            'vehicle_id' => $vehicle->id,
            'user_id' => $user->id,
            'rating' => 5,
            'comment' => 'Excellent vehicle for road trips!'
        ]);

        // 4. Ver las reseñas del vehículo
        $reviewsResponse = $this->get("/vehicles/{$vehicle->id}/reviews");
        $reviewsResponse->assertStatus(200)
                       ->assertSee('Excellent vehicle for road trips!');
    }

    /**
     * Prueba de Integración: Flujo de procesamiento de pagos
     * @test
     */
    public function test_complete_payment_processing_flow()
    {
        $paymentService = app(PaymentService::class);

        // 1. Crear un pago de prueba
        $payment = Payment::factory()->create([
            'amount' => 150.00,
            'status' => 'pending',
            'payment_method' => 'card'
        ]);

        // 2. Procesar pago con tarjeta válida
        $validCardData = [
            'card_number' => '4111111111111111',
            'card_expiry' => '12/25',
            'card_cvv' => '123',
            'card_name' => 'Test User'
        ];

        $result = $paymentService->processCardPayment($payment, $validCardData);

        // 3. Verificar resultado exitoso
        $this->assertTrue($result['success']);
        $this->assertEquals('Pago procesado exitosamente', $result['message']);

        // 4. Verificar actualización en base de datos
        $payment->refresh();
        $this->assertEquals('success', $payment->status);

        // 5. Probar pago fallido con tarjeta problemática
        $failingPayment = Payment::factory()->create([
            'amount' => 100.00,
            'status' => 'pending',
            'payment_method' => 'card'
        ]);

        $failingCardData = [
            'card_number' => '4000000000000002', // Tarjeta que falla
            'card_expiry' => '12/25',
            'card_cvv' => '123',
            'card_name' => 'Test User'
        ];

        $failResult = $paymentService->processCardPayment($failingPayment, $failingCardData);

        // 6. Verificar manejo de fallo
        $this->assertFalse($failResult['success']);
        $this->assertEquals('La tarjeta fue declinada por el banco', $failResult['message']);
    }

    /**
     * Prueba de Integración: Flujo de validación y manejo de errores
     * @test
     */
    public function test_complete_validation_and_error_handling_flow()
    {
        // 1. Probar validación en formulario de contacto
        $invalidContactResponse = $this->post('/contact', [
            'name' => '', // Faltante
            'email' => 'invalid-email', // Formato incorrecto
            'subject' => str_repeat('a', 300), // Muy largo
            'message' => '' // Faltante
        ]);

        $invalidContactResponse->assertSessionHasErrors(['name', 'email', 'subject', 'message']);

        // 2. Probar validación en login
        $invalidLoginResponse = $this->post('/sign-in', [
            'email' => 'nonexistent@test.com',
            'password' => 'wrongpassword'
        ]);

        $invalidLoginResponse->assertSessionHasErrors(['email']);

        // 3. Probar validación en registro
        $invalidRegisterResponse = $this->post('/sign-up', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => '123', // Muy corta
            'password_confirmation' => '456' // No coincide
        ]);

        $invalidRegisterResponse->assertSessionHasErrors(['name', 'email', 'password']);
    }

    /**
     * Prueba de Integración: Flujo de sesión y persistencia
     * @test
     */
    public function test_session_and_persistence_flow()
    {
        $user = User::factory()->create();

        // 1. Login y verificar sesión
        $loginResponse = $this->post('/sign-in', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $this->assertAuthenticated();

        // 2. Navegar por la aplicación manteniendo sesión
        $this->get('/profile')->assertStatus(200);
        $this->get('/vehicles')->assertStatus(200);
        $this->get('/rents')->assertStatus(200);

        // Sesión debe persistir
        $this->assertAuthenticated();

        // 3. Logout y verificar limpieza de sesión
        $this->post('/sign-out');
        $this->assertGuest();
    }

    /**
     * Prueba de Integración: Flujo de recuperación de contraseña
     * @test
     */
    public function test_password_recovery_flow()
    {
        $user = User::factory()->create();

        // 1. Solicitar recuperación de contraseña
        $forgotPasswordResponse = $this->post('/forgot-password', [
            'email' => $user->email
        ]);

        // Debería redirigir con mensaje de éxito (aunque no enviemos email real)
        $forgotPasswordResponse->assertRedirect();

        // 2. Verificar que se puede acceder a la página de reset
        $resetPageResponse = $this->get('/reset-password/fake-token');
        $resetPageResponse->assertStatus(200);
    }
} 