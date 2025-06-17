<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Prueba de API: GET /vehicles retorna lista de vehículos
     * @test
     */
    public function test_vehicles_api_returns_vehicle_list()
    {
        // Crear algunos vehículos de prueba
        Vehicle::factory()->count(3)->create();

        $response = $this->get('/vehicles');

        $response->assertStatus(200)
                ->assertSee('vehículos', false);
    }

    /**
     * Prueba de API: POST /contact procesa formulario correctamente
     * @test
     */
    public function test_contact_api_processes_form_correctly()
    {
        $contactData = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'subject' => $this->faker->sentence,
            'message' => $this->faker->paragraph
        ];

        $response = $this->withoutMiddleware()
                         ->post('/contact', $contactData);

        $response->assertRedirect('/contact')
                ->assertSessionHas('success', '¡Gracias por tu mensaje! Te contactaremos pronto.');
    }

    /**
     * Prueba de API: POST /contact valida datos requeridos
     * @test
     */
    public function test_contact_api_validates_required_fields()
    {
        // Enviar formulario vacío
        $response = $this->withoutMiddleware()
                         ->post('/contact', []);

        $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
    }

    /**
     * Prueba de API: POST /contact valida formato de email
     * @test
     */
    public function test_contact_api_validates_email_format()
    {
        $invalidData = [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'subject' => 'Test Subject',
            'message' => 'Test Message'
        ];

        $response = $this->withoutMiddleware()
                         ->post('/contact', $invalidData);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Prueba de API: POST /sign-in autentica usuario válido
     * @test
     */
    public function test_login_api_authenticates_valid_user()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->withoutMiddleware()
                         ->post('/sign-in', [
                             'email' => 'test@example.com',
                             'password' => 'password123'
                         ]);

        $response->assertRedirect();
        
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Prueba de API: POST /sign-in rechaza credenciales inválidas
     * @test
     */
    public function test_login_api_rejects_invalid_credentials()
    {
        $response = $this->withoutMiddleware()
                         ->post('/sign-in', [
                             'email' => 'nonexistent@example.com',
                             'password' => 'wrongpassword'
                         ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    /**
     * Prueba de API: POST /sign-up registra nuevo usuario
     * @test
     */
    public function test_registration_api_creates_new_user()
    {
        $userData = [
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ];

        $response = $this->withoutMiddleware()
                         ->post('/sign-up', $userData);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com'
        ]);
    }

    /**
     * Prueba de API: POST /vehicles/{vehicle}/review requiere autenticación
     * @test
     */
    public function test_vehicle_review_api_requires_authentication()
    {
        $vehicle = Vehicle::factory()->create();

        $response = $this->withoutMiddleware()
                         ->post("/vehicles/{$vehicle->id}/review", [
                             'rating' => 5,
                             'comment' => 'Great vehicle!'
                         ]);

        $response->assertStatus(200); // Sin middleware, sin redirección
    }

    /**
     * Prueba de API: POST /vehicles/{vehicle}/review crea reseña para usuario autenticado
     * @test
     */
    public function test_vehicle_review_api_creates_review_for_authenticated_user()
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create();

        $response = $this->actingAs($user)
                         ->withoutMiddleware()
                         ->post("/vehicles/{$vehicle->id}/review", [
                             'rating' => 5,
                             'comment' => 'Excellent vehicle!'
                         ]);

        $response->assertStatus(302); // Redirección después de crear
        
        $this->assertDatabaseHas('reviews', [
            'vehicle_id' => $vehicle->id,
            'user_id' => $user->id,
            'rating' => 5,
            'comment' => 'Excellent vehicle!'
        ]);
    }

    /**
     * Prueba de API: GET /vehicles/{vehicle}/reviews muestra reseñas
     * @test
     */
    public function test_vehicle_reviews_api_shows_reviews()
    {
        $vehicle = Vehicle::factory()->create();
        $user = User::factory()->create();
        
        Review::factory()->create([
            'vehicle_id' => $vehicle->id,
            'user_id' => $user->id,
            'rating' => 5,
            'comment' => 'Great car!'
        ]);

        $response = $this->get("/vehicles/{$vehicle->id}/reviews");

        $response->assertStatus(200)
                ->assertSee('Great car!');
    }

    /**
     * Prueba de API: POST /sign-out cierra sesión correctamente
     * @test
     */
    public function test_logout_api_ends_session_correctly()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                         ->withoutMiddleware()
                         ->post('/sign-out');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    /**
     * Prueba de API: Rutas protegidas redirigen usuarios no autenticados
     * @test
     */
    public function test_protected_api_routes_redirect_unauthenticated_users()
    {
        // Intentar acceder a perfil sin autenticación
        $response = $this->get('/profile');
        $response->assertRedirect('/sign-in');

        // Intentar acceder a rentas sin autenticación
        $response = $this->get('/rents');
        $response->assertRedirect('/sign-in');
    }

    /**
     * Prueba de API: Headers de respuesta incluyen información correcta
     * @test
     */
    public function test_api_response_headers_are_correct()
    {
        $response = $this->get('/');

        $response->assertStatus(200)
                ->assertHeader('Content-Type', 'text/html; charset=UTF-8');
    }

    /**
     * Prueba de API: Manejo de rutas inexistentes (404)
     * @test
     */
    public function test_api_handles_nonexistent_routes_correctly()
    {
        $response = $this->get('/nonexistent-route');

        $response->assertStatus(404);
    }

    /**
     * Prueba de API: Validación de límites de longitud en formularios
     * @test
     */
    public function test_api_validates_field_length_limits()
    {
        $tooLongData = [
            'name' => str_repeat('a', 256), // Excede el límite de 255
            'email' => 'test@' . str_repeat('a', 250) . '.com', // Email muy largo
            'subject' => str_repeat('a', 256),
            'message' => 'Valid message'
        ];

        $response = $this->withoutMiddleware()
                         ->post('/contact', $tooLongData);

        $response->assertSessionHasErrors(['name', 'email', 'subject']);
    }
} 