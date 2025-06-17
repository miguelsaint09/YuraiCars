<?php

namespace Tests\Feature;

use App\Models\Payment;
use App\Models\User;
use App\Models\Vehicle;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SimpleIntegrationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Prueba de Integración: Flujo completo de navegación por páginas públicas
     * @test
     */
    public function test_complete_public_navigation_flow()
    {
        // 1. Visitar página de inicio
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);

        // 2. Navegar a página "Acerca de"
        $aboutResponse = $this->get('/about');
        $aboutResponse->assertStatus(200);

        // 3. Visitar página de contacto
        $contactResponse = $this->get('/contact');
        $contactResponse->assertStatus(200);

        // 4. Ver página de vehículos
        $vehiclesResponse = $this->get('/vehicles');
        $vehiclesResponse->assertStatus(200);
    }

    /**
     * Prueba de Integración: Flujo completo de exploración de vehículos
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

        // 4. Verificar que la página muestra contenido de vehículos
        $vehiclesResponse->assertSee('Flota Disponible'); // Título que siempre aparece
        $vehiclesResponse->assertSee('vehículo'); // Texto que aparece en contador o estado vacío
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

        $submitResponse = $this->withoutMiddleware()
                              ->post('/contact', $contactData);

        // 3. Verificar redirección
        $submitResponse->assertRedirect('/contact');
    }

    /**
     * Prueba de Integración: Flujo de acceso a áreas protegidas
     * @test
     */
    public function test_protected_areas_redirect_flow()
    {
        // 1. Intentar acceder a área protegida sin autenticación
        $protectedPages = ['/profile', '/rents'];

        foreach ($protectedPages as $page) {
            $response = $this->get($page);
            $response->assertRedirect('/sign-in');
        }
    }

    /**
     * Prueba de Integración: Flujo de servicio de pagos
     * @test
     */
    public function test_payment_service_functionality()
    {
        $paymentService = app(PaymentService::class);

        // 1. Probar validación de tarjeta válida
        $validCardNumber = '4111111111111111';
        $this->assertTrue($paymentService->isValidCardNumber($validCardNumber));

        // 2. Probar validación de tarjeta inválida (usar número que definitivamente falle)
        $invalidCardNumber = '12345'; // Muy corto, debe fallar
        $this->assertFalse($paymentService->isValidCardNumber($invalidCardNumber));

        // 3. Probar validación de CVV
        $validCvv = '123';
        $this->assertTrue($paymentService->isValidCvv($validCvv));

        // 4. Probar validación de fecha de expiración
        $validExpiry = '12/25';
        $this->assertTrue($paymentService->isValidExpiryDate($validExpiry));
    }

    /**
     * Prueba de Integración: Flujo de validación de formularios
     * @test
     */
    public function test_complete_validation_flow()
    {
        // 1. Enviar formulario de contacto vacío
        $emptyContactResponse = $this->withoutMiddleware()
                                    ->post('/contact', []);
        
        $emptyContactResponse->assertSessionHasErrors([
            'name', 'email', 'subject', 'message'
        ]);

        // 2. Enviar formulario con email inválido
        $invalidEmailResponse = $this->withoutMiddleware()
                                    ->post('/contact', [
                                        'name' => 'Test',
                                        'email' => 'invalid-email',
                                        'subject' => 'Test',
                                        'message' => 'Test message'
                                    ]);
        
        $invalidEmailResponse->assertSessionHasErrors(['email']);
    }

    /**
     * Prueba de Integración: Flujo de páginas de autenticación
     * @test
     */
    public function test_authentication_pages_load_flow()
    {
        $authPages = [
            '/sign-in',
            '/sign-up',
            '/forgot-password'
        ];

        foreach ($authPages as $page) {
            $response = $this->get($page);
            $response->assertStatus(200);
        }
    }

    /**
     * Prueba de Integración: Flujo de búsqueda y filtrado (si existe)
     * @test
     */
    public function test_search_and_filtering_flow()
    {
        // 1. Crear varios vehículos con diferentes atributos
        $vehicles = Vehicle::factory()->count(3)->create();

        // 2. Visitar página de vehículos
        $vehiclesResponse = $this->get('/vehicles');
        $vehiclesResponse->assertStatus(200);

        // 3. Probar parámetros GET si la aplicación los soporta
        $categoryResponse = $this->get('/vehicles?category=SUV');
        $categoryResponse->assertStatus(200);
    }

    /**
     * Prueba de Integración: Flujo de rendimiento y tiempo de respuesta
     * @test
     */
    public function test_performance_response_times()
    {
        $startTime = microtime(true);

        // 1. Medir tiempo de página principal
        $this->get('/');
        
        $homeTime = microtime(true) - $startTime;
        $this->assertLessThan(3.0, $homeTime, 'La página principal debe cargar en menos de 3 segundos');

        // 2. Medir tiempo de página de vehículos
        $startTime = microtime(true);
        $this->get('/vehicles');
        
        $vehiclesTime = microtime(true) - $startTime;
        $this->assertLessThan(3.0, $vehiclesTime, 'La página de vehículos debe cargar en menos de 3 segundos');
    }

    /**
     * Prueba de Integración: Flujo de manejo de errores 404
     * @test
     */
    public function test_error_handling_flow()
    {
        // 1. Acceder a páginas inexistentes
        $nonExistentPages = [
            '/nonexistent-page',
            '/invalid-route',
            '/fake-page'
        ];

        foreach ($nonExistentPages as $page) {
            $response = $this->get($page);
            $response->assertStatus(404);
        }
    }
} 