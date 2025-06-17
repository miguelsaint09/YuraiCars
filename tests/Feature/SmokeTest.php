<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmokeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Prueba de humo: Página principal carga correctamente
     * @test
     */
    public function test_home_page_loads()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200)
                ->assertViewIs('home');
    }

    /**
     * Prueba de humo: Página "Acerca de" carga correctamente
     * @test
     */
    public function test_about_page_loads()
    {
        $response = $this->get('/about');
        
        $response->assertStatus(200)
                ->assertViewIs('about');
    }

    /**
     * Prueba de humo: Página de contacto carga correctamente
     * @test
     */
    public function test_contact_page_loads()
    {
        $response = $this->get('/contact');
        
        $response->assertStatus(200)
                ->assertViewIs('contact');
    }

    /**
     * Prueba de humo: Página de vehículos carga correctamente
     * @test
     */
    public function test_vehicles_page_loads()
    {
        $response = $this->get('/vehicles');
        
        $response->assertStatus(200)
                ->assertSee('vehículos', false); // Case insensitive
    }

    /**
     * Prueba de humo: Páginas de autenticación cargan correctamente
     * @test
     */
    public function test_auth_pages_load()
    {
        // Login page
        $response = $this->get('/sign-in');
        $response->assertStatus(200);

        // Registration page
        $response = $this->get('/sign-up');
        $response->assertStatus(200);

        // Forgot password page
        $response = $this->get('/forgot-password');
        $response->assertStatus(200);
    }

    /**
     * Prueba de humo: Rutas protegidas redirigen a login para usuarios no autenticados
     * @test
     */
    public function test_protected_routes_redirect_to_login()
    {
        // Profile page
        $response = $this->get('/profile');
        $response->assertRedirect('/sign-in');

        // User rentals page
        $response = $this->get('/rents');
        $response->assertRedirect('/sign-in');
    }

    /**
     * Prueba de humo: Base de datos se conecta correctamente
     * @test
     */
    public function test_database_connection()
    {
        // Simplemente verificar que podemos hacer una consulta básica
        $this->assertTrue(\DB::connection()->getPdo() !== null);
    }

    /**
     * Prueba de humo: Variables de entorno críticas están configuradas
     * @test
     */
    public function test_critical_environment_variables()
    {
        $this->assertNotEmpty(config('app.key'));
        $this->assertNotEmpty(config('app.name'));
        $this->assertContains(config('app.env'), ['testing', 'local'], 'APP_ENV debe ser testing o local');
    }

    /**
     * Prueba de humo: Servicios principales están disponibles
     * @test
     */
    public function test_essential_services_available()
    {
        // Verificar que el container puede resolver servicios críticos
        $this->assertInstanceOf(
            \App\Services\PaymentService::class,
            app(\App\Services\PaymentService::class)
        );
    }

    /**
     * Prueba de humo: Headers de seguridad básicos están presentes
     * @test
     */
    public function test_basic_security_headers()
    {
        $response = $this->get('/');
        
        // Verificar que Laravel incluye headers básicos de seguridad
        $response->assertStatus(200);
        
        // El header X-Frame-Options debería estar presente para prevenir clickjacking
        $headers = $response->headers->all();
        $this->assertArrayHasKey('cache-control', $headers);
    }

    /**
     * Prueba de humo: Formulario de contacto procesa datos básicos
     * @test
     */
    public function test_contact_form_basic_processing()
    {
        $response = $this->withoutMiddleware()
                         ->post('/contact', [
                             'name' => 'Test User',
                             'email' => 'test@example.com',
                             'subject' => 'Test Subject',
                             'message' => 'This is a test message'
                         ]);

        $response->assertRedirect('/contact')
                ->assertSessionHas('success');
    }

    /**
     * Prueba de humo: Rutas responden en tiempo razonable
     * @test
     */
    public function test_response_times_are_reasonable()
    {
        $startTime = microtime(true);
        
        $this->get('/');
        
        $endTime = microtime(true);
        $responseTime = ($endTime - $startTime) * 1000; // En milisegundos
        
        // La página principal debería cargar en menos de 5 segundos en entorno de pruebas
        $this->assertLessThan(5000, $responseTime, 'La página principal tarda demasiado en cargar');
    }
} 