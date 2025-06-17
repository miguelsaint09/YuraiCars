<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class StressTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        // Incrementar límites de tiempo para pruebas de estrés
        ini_set('memory_limit', '512M');
        set_time_limit(300); // 5 minutos
    }

    /**
     * Prueba de Estrés: Carga masiva de usuarios concurrentes
     * @test
     * @group stress
     */
    public function test_massive_concurrent_user_load()
    {
        $startTime = microtime(true);
        $userCount = 100;
        $users = [];

        // Crear múltiples usuarios simultáneamente
        for ($i = 0; $i < $userCount; $i++) {
            $users[] = User::factory()->create([
                'email' => "stress_user_{$i}@test.com"
            ]);
        }

        $this->assertCount($userCount, $users);

        // Simular logins concurrentes
        $successfulLogins = 0;
        foreach ($users as $user) {
            $response = $this->post('/sign-in', [
                'email' => $user->email,
                'password' => 'password'
            ]);

            if ($response->getStatusCode() === 302) {
                $successfulLogins++;
            }
        }

        $endTime = microtime(true);
        $executionTime = ($endTime - $startTime) * 1000; // en milisegundos

        // Verificaciones de rendimiento
        $this->assertGreaterThan($userCount * 0.95, $successfulLogins, '95% de logins deberían ser exitosos');
        $this->assertLessThan(30000, $executionTime, 'El tiempo de ejecución no debería exceder 30 segundos');

        echo "\n[STRESS TEST] Usuarios procesados: {$userCount}, Logins exitosos: {$successfulLogins}, Tiempo: " . number_format($executionTime, 2) . "ms\n";
    }

    /**
     * Prueba de Estrés: Procesamiento masivo de pagos
     * @test
     * @group stress
     */
    public function test_massive_payment_processing()
    {
        $paymentService = app(PaymentService::class);
        $paymentCount = 50;
        $startTime = microtime(true);

        $successfulPayments = 0;
        $failedPayments = 0;

        for ($i = 0; $i < $paymentCount; $i++) {
            $payment = Payment::factory()->create([
                'amount' => rand(50, 500),
                'status' => 'pending',
                'payment_method' => 'card'
            ]);

            $cardData = [
                'card_number' => '4111111111111111',
                'card_expiry' => '12/25',
                'card_cvv' => '123',
                'card_name' => "Test User {$i}"
            ];

            $result = $paymentService->processCardPayment($payment, $cardData);

            if ($result['success']) {
                $successfulPayments++;
            } else {
                $failedPayments++;
            }
        }

        $endTime = microtime(true);
        $executionTime = ($endTime - $startTime) * 1000;

        // Verificaciones
        $this->assertGreaterThan($paymentCount * 0.9, $successfulPayments, '90% de pagos deberían ser exitosos');
        $this->assertLessThan(20000, $executionTime, 'El procesamiento no debería tomar más de 20 segundos');

        echo "\n[STRESS TEST] Pagos procesados: {$paymentCount}, Exitosos: {$successfulPayments}, Fallidos: {$failedPayments}, Tiempo: " . number_format($executionTime, 2) . "ms\n";
    }

    /**
     * Prueba de Estrés: Carga masiva de consultas a la base de datos
     * @test
     * @group stress
     */
    public function test_massive_database_queries()
    {
        // Crear datos de prueba
        Vehicle::factory()->count(200)->create();
        User::factory()->count(100)->create();

        $startTime = microtime(true);
        $queryCount = 500;

        for ($i = 0; $i < $queryCount; $i++) {
            // Alternar entre diferentes tipos de consultas
            switch ($i % 4) {
                case 0:
                    Vehicle::where('id', '>', rand(1, 100))->limit(10)->get();
                    break;
                case 1:
                    User::where('created_at', '>', now()->subDays(7))->count();
                    break;
                case 2:
                    DB::table('vehicles')->join('users', function($join) {
                        $join->on('vehicles.id', '>', 'users.id');
                    })->limit(5)->get();
                    break;
                case 3:
                    Vehicle::with('reviews')->limit(3)->get();
                    break;
            }
        }

        $endTime = microtime(true);
        $executionTime = ($endTime - $startTime) * 1000;

        // Verificar que las consultas no tomen demasiado tiempo
        $this->assertLessThan(15000, $executionTime, 'Las consultas masivas no deberían tomar más de 15 segundos');

        echo "\n[STRESS TEST] Consultas ejecutadas: {$queryCount}, Tiempo total: " . number_format($executionTime, 2) . "ms\n";
    }

    /**
     * Prueba de Estrés: Carga de múltiples requests HTTP simultáneos
     * @test
     * @group stress
     */
    public function test_multiple_http_requests_load()
    {
        Vehicle::factory()->count(20)->create();
        
        $requestCount = 100;
        $startTime = microtime(true);
        $successfulRequests = 0;
        $totalResponseTime = 0;

        for ($i = 0; $i < $requestCount; $i++) {
            $requestStartTime = microtime(true);
            
            // Alternar entre diferentes endpoints
            switch ($i % 5) {
                case 0:
                    $response = $this->get('/');
                    break;
                case 1:
                    $response = $this->get('/vehicles');
                    break;
                case 2:
                    $response = $this->get('/about');
                    break;
                case 3:
                    $response = $this->get('/contact');
                    break;
                case 4:
                    $response = $this->post('/contact', [
                        'name' => "User {$i}",
                        'email' => "user{$i}@test.com",
                        'subject' => "Subject {$i}",
                        'message' => "Message {$i}"
                    ]);
                    break;
            }

            $requestEndTime = microtime(true);
            $requestTime = ($requestEndTime - $requestStartTime) * 1000;
            $totalResponseTime += $requestTime;

            if ($response->getStatusCode() < 400) {
                $successfulRequests++;
            }
        }

        $endTime = microtime(true);
        $totalTime = ($endTime - $startTime) * 1000;
        $averageResponseTime = $totalResponseTime / $requestCount;

        // Verificaciones de rendimiento
        $this->assertGreaterThan($requestCount * 0.95, $successfulRequests, '95% de requests deberían ser exitosos');
        $this->assertLessThan(500, $averageResponseTime, 'El tiempo promedio de respuesta no debería exceder 500ms');
        $this->assertLessThan(30000, $totalTime, 'El tiempo total no debería exceder 30 segundos');

        echo "\n[STRESS TEST] Requests: {$requestCount}, Exitosos: {$successfulRequests}, Tiempo promedio: " . number_format($averageResponseTime, 2) . "ms\n";
    }

    /**
     * Prueba de Estrés: Memoria y recursos del sistema
     * @test
     * @group stress
     */
    public function test_memory_and_resource_usage()
    {
        $initialMemory = memory_get_usage(true);
        $startTime = microtime(true);

        // Crear una gran cantidad de objetos en memoria
        $objects = [];
        for ($i = 0; $i < 1000; $i++) {
            $objects[] = Vehicle::factory()->make([
                'name' => "Vehicle {$i}",
                'description' => str_repeat("Description for vehicle {$i}. ", 50),
                'additional_data' => array_fill(0, 100, "data_{$i}")
            ]);
        }

        $peakMemory = memory_get_peak_usage(true);
        $currentMemory = memory_get_usage(true);
        $memoryUsed = $currentMemory - $initialMemory;

        $endTime = microtime(true);
        $executionTime = ($endTime - $startTime) * 1000;

        // Verificaciones de memoria
        $this->assertLessThan(100 * 1024 * 1024, $memoryUsed, 'El uso de memoria no debería exceder 100MB'); // 100MB
        $this->assertLessThan(200 * 1024 * 1024, $peakMemory, 'El pico de memoria no debería exceder 200MB');
        $this->assertLessThan(10000, $executionTime, 'La creación de objetos no debería tomar más de 10 segundos');

        // Limpiar memoria
        unset($objects);
        $finalMemory = memory_get_usage(true);

        echo "\n[STRESS TEST] Memoria inicial: " . $this->formatBytes($initialMemory) . 
             ", Pico: " . $this->formatBytes($peakMemory) . 
             ", Final: " . $this->formatBytes($finalMemory) . 
             ", Tiempo: " . number_format($executionTime, 2) . "ms\n";
    }

    /**
     * Prueba de Estrés: Validación bajo carga
     * @test
     * @group stress
     */
    public function test_validation_under_load()
    {
        $startTime = microtime(true);
        $validationTests = 200;
        $validationsPassed = 0;
        $validationsFailed = 0;

        for ($i = 0; $i < $validationTests; $i++) {
            // Generar datos válidos e inválidos alternadamente
            if ($i % 2 === 0) {
                // Datos válidos
                $response = $this->post('/contact', [
                    'name' => $this->faker->name,
                    'email' => $this->faker->email,
                    'subject' => $this->faker->sentence,
                    'message' => $this->faker->paragraph
                ]);
                
                if ($response->isRedirect()) {
                    $validationsPassed++;
                }
            } else {
                // Datos inválidos
                $response = $this->post('/contact', [
                    'name' => '', // Inválido
                    'email' => 'invalid-email', // Inválido
                    'subject' => str_repeat('a', 300), // Demasiado largo
                    'message' => '' // Inválido
                ]);
                
                if ($response->getStatusCode() === 422 || $response->isRedirect()) {
                    $validationsFailed++;
                }
            }
        }

        $endTime = microtime(true);
        $executionTime = ($endTime - $startTime) * 1000;

        $this->assertGreaterThan($validationTests * 0.45, $validationsPassed, 'Al menos 45% de validaciones deberían pasar');
        $this->assertGreaterThan($validationTests * 0.45, $validationsFailed, 'Al menos 45% de validaciones deberían fallar');
        $this->assertLessThan(25000, $executionTime, 'Las validaciones no deberían tomar más de 25 segundos');

        echo "\n[STRESS TEST] Validaciones: {$validationTests}, Pasaron: {$validationsPassed}, Fallaron: {$validationsFailed}, Tiempo: " . number_format($executionTime, 2) . "ms\n";
    }

    /**
     * Prueba de Estrés: Resistencia del sistema (Endurance Test)
     * @test
     * @group stress
     */
    public function test_system_endurance()
    {
        $startTime = microtime(true);
        $operationCycles = 50;
        $totalOperations = 0;

        for ($cycle = 0; $cycle < $operationCycles; $cycle++) {
            // Ciclo de operaciones variadas
            
            // 1. Crear usuarios
            $users = User::factory()->count(5)->create();
            $totalOperations += 5;

            // 2. Crear vehículos
            $vehicles = Vehicle::factory()->count(3)->create();
            $totalOperations += 3;

            // 3. Hacer requests HTTP
            $this->get('/');
            $this->get('/vehicles');
            $totalOperations += 2;

            // 4. Procesar algunos pagos
            $payment = Payment::factory()->create();
            $paymentService = app(PaymentService::class);
            $result = $paymentService->processCardPayment($payment, [
                'card_number' => '4111111111111111',
                'card_expiry' => '12/25',
                'card_cvv' => '123',
                'card_name' => 'Test User'
            ]);
            $totalOperations += 1;

            // 5. Limpiar algunos datos para evitar acumulación excesiva
            if ($cycle % 10 === 0) {
                DB::table('users')->where('created_at', '<', now()->subMinutes(1))->limit(20)->delete();
                DB::table('vehicles')->where('created_at', '<', now()->subMinutes(1))->limit(10)->delete();
            }
        }

        $endTime = microtime(true);
        $executionTime = ($endTime - $startTime) * 1000;

        $this->assertLessThan(60000, $executionTime, 'El test de resistencia no debería tomar más de 1 minuto');
        $this->assertGreaterThan($operationCycles * 10, $totalOperations, 'Deberían realizarse al menos 10 operaciones por ciclo');

        echo "\n[STRESS TEST] Ciclos: {$operationCycles}, Operaciones totales: {$totalOperations}, Tiempo: " . number_format($executionTime, 2) . "ms\n";
    }

    /**
     * Helper para formatear bytes
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
} 