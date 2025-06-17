<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SimpleApiTest extends TestCase
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

        $response->assertStatus(200);
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

        $response->assertRedirect('/contact');
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

    /**
     * Prueba de API: Páginas básicas cargan correctamente
     * @test
     */
    public function test_basic_pages_load_correctly()
    {
        $pages = ['/', '/about', '/contact', '/vehicles'];
        
        foreach ($pages as $page) {
            $response = $this->get($page);
            $response->assertStatus(200);
        }
    }

    /**
     * Prueba de API: Autenticación básica funciona
     * @test
     */
    public function test_basic_auth_pages_work()
    {
        // Páginas de autenticación deben cargar
        $authPages = ['/sign-in', '/sign-up', '/forgot-password'];
        
        foreach ($authPages as $page) {
            $response = $this->get($page);
            $response->assertStatus(200);
        }
    }
} 