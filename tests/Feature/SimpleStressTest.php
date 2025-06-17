<?php

namespace Tests\Feature;

use App\Models\Vehicle;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SimpleStressTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Prueba de Estrés: Carga masiva de páginas públicas
     * @test
     */
    public function test_massive_page_load_stress()
    {
        // Crear contenido para las pruebas
        Vehicle::factory()->count(10)->create();

        $pages = ['/', '/about', '/contact', '/vehicles'];
        $successCount = 0;
        $totalRequests = 50;

        $startTime = microtime(true);

        // Simular 50 requests a páginas públicas
        for ($i = 0; $i < $totalRequests; $i++) {
            $page = $pages[array_rand($pages)];
            $response = $this->get($page);
            
            if ($response->status() === 200) {
                $successCount++;
            }
        }

        $endTime = microtime(true);
        $totalTime = $endTime - $startTime;

        // Verificar que al menos 95% de las páginas carguen exitosamente
        $successRate = ($successCount / $totalRequests) * 100;
        $this->assertGreaterThan(95.0, $successRate, 
            '95% de las páginas deberían cargar exitosamente');

        // Verificar que el tiempo promedio por request sea razonable
        $avgTime = $totalTime / $totalRequests;
        $this->assertLessThan(2.0, $avgTime, 
            'El tiempo promedio por request debe ser menor a 2 segundos');

        echo "\n📊 Resultados de Carga:\n";
        echo "   • Requests exitosos: {$successCount}/{$totalRequests} ({$successRate}%)\n";
        echo "   • Tiempo total: " . round($totalTime, 2) . " segundos\n";
        echo "   • Tiempo promedio: " . round($avgTime, 3) . " segundos por request\n";
    }

    /**
     * Prueba de Estrés: Procesamiento masivo de validaciones
     * @test
     */
    public function test_massive_validation_processing()
    {
        $paymentService = app(PaymentService::class);
        
        $validCards = [
            '4111111111111111',
            '5555555555554444',
            '378282246310005',
            '6011111111111117'
        ];

        // Usar números que definitivamente fallen la validación básica
        $invalidCards = [
            '12345',           // Muy corto
            'abcd1234567890',  // Contiene letras
            '411111111111',    // 12 dígitos (muy corto)
            ''                 // Vacío
        ];

        $startTime = microtime(true);
        $totalValidations = 200;
        $successCount = 0;

        // Procesar 200 validaciones de tarjetas
        for ($i = 0; $i < $totalValidations; $i++) {
            if ($i % 2 === 0) {
                // Usar tarjeta válida
                $card = $validCards[array_rand($validCards)];
                $isValid = $paymentService->isValidCardNumber($card);
                if ($isValid) $successCount++;
            } else {
                // Usar tarjeta inválida (debería fallar)
                $card = $invalidCards[array_rand($invalidCards)];
                $isValid = $paymentService->isValidCardNumber($card);
                if (!$isValid) $successCount++; // Cuenta como éxito si detecta correctamente que es inválida
            }
        }

        $endTime = microtime(true);
        $totalTime = $endTime - $startTime;

        // Verificar que al menos 95% de las validaciones sean correctas
        $successRate = ($successCount / $totalValidations) * 100;
        $this->assertGreaterThan(95.0, $successRate, 
            '95% de las validaciones deberían ser correctas');

        echo "\n💳 Resultados de Validación:\n";
        echo "   • Validaciones correctas: {$successCount}/{$totalValidations} ({$successRate}%)\n";
        echo "   • Tiempo total: " . round($totalTime, 3) . " segundos\n";
        echo "   • Validaciones por segundo: " . round($totalValidations / $totalTime, 1) . "\n";
    }

    /**
     * Prueba de Estrés: Carga masiva de base de datos
     * @test
     */
    public function test_massive_database_load()
    {
        // Crear muchos vehículos para probar consultas
        Vehicle::factory()->count(100)->create();

        $startTime = microtime(true);
        $queryCount = 50;

        // Realizar 50 consultas a la base de datos
        for ($i = 0; $i < $queryCount; $i++) {
            $vehicles = Vehicle::limit(10)->get();
            $this->assertNotEmpty($vehicles);
        }

        $endTime = microtime(true);
        $totalTime = $endTime - $startTime;

        // Verificar que las consultas sean razonablemente rápidas
        $avgTime = $totalTime / $queryCount;
        $this->assertLessThan(0.5, $avgTime, 
            'Cada consulta debe tomar menos de 0.5 segundos');

        echo "\n🗄️ Resultados de Base de Datos:\n";
        echo "   • Consultas realizadas: {$queryCount}\n";
        echo "   • Tiempo total: " . round($totalTime, 3) . " segundos\n";
        echo "   • Tiempo promedio por consulta: " . round($avgTime, 4) . " segundos\n";
    }

    /**
     * Prueba de Estrés: Uso de memoria bajo carga
     * @test
     */
    public function test_memory_usage_under_load()
    {
        $startMemory = memory_get_usage(true);
        
        // Crear contenido y realizar operaciones que consuman memoria
        for ($i = 0; $i < 20; $i++) {
            Vehicle::factory()->count(5)->create();
            $vehicles = Vehicle::all();
            
            // Simular procesamiento de datos
            foreach ($vehicles as $vehicle) {
                $data = [
                    'id' => $vehicle->id,
                    'name' => $vehicle->name,
                    'year' => $vehicle->year,
                    'price' => $vehicle->price_per_day
                ];
            }
        }

        $endMemory = memory_get_usage(true);
        $memoryUsed = $endMemory - $startMemory;
        $memoryUsedMB = $memoryUsed / 1024 / 1024;

        // Verificar que el uso de memoria sea razonable (menos de 50MB)
        $this->assertLessThan(50, $memoryUsedMB, 
            'El uso de memoria debe ser menor a 50MB');

        echo "\n🧠 Resultados de Memoria:\n";
        echo "   • Memoria inicial: " . round($startMemory / 1024 / 1024, 2) . " MB\n";
        echo "   • Memoria final: " . round($endMemory / 1024 / 1024, 2) . " MB\n";
        echo "   • Memoria utilizada: " . round($memoryUsedMB, 2) . " MB\n";
    }

    /**
     * Prueba de Estrés: Procesamiento de formularios bajo carga
     * @test
     */
    public function test_form_processing_under_load()
    {
        $successCount = 0;
        $totalForms = 25;

        $startTime = microtime(true);

        // Enviar 25 formularios de contacto
        for ($i = 0; $i < $totalForms; $i++) {
            $contactData = [
                'name' => $this->faker->name,
                'email' => $this->faker->email,
                'subject' => $this->faker->sentence,
                'message' => $this->faker->paragraph
            ];

            $response = $this->withoutMiddleware()
                            ->post('/contact', $contactData);

            if ($response->status() === 302) { // Redirección exitosa
                $successCount++;
            }
        }

        $endTime = microtime(true);
        $totalTime = $endTime - $startTime;

        // Verificar que al menos 95% de los formularios se procesen exitosamente
        $successRate = ($successCount / $totalForms) * 100;
        $this->assertGreaterThan(95.0, $successRate, 
            '95% de los formularios deberían procesarse exitosamente');

        echo "\n📝 Resultados de Formularios:\n";
        echo "   • Formularios procesados: {$successCount}/{$totalForms} ({$successRate}%)\n";
        echo "   • Tiempo total: " . round($totalTime, 2) . " segundos\n";
        echo "   • Formularios por segundo: " . round($totalForms / $totalTime, 1) . "\n";
    }

    /**
     * Prueba de Estrés: Concurrencia de operaciones PaymentService
     * @test
     */
    public function test_payment_service_concurrency()
    {
        $paymentService = app(PaymentService::class);
        
        $startTime = microtime(true);
        $operations = 100;
        $successfulOperations = 0;

        // Realizar 100 operaciones de validación concurrentes
        for ($i = 0; $i < $operations; $i++) {
            $cardNumber = '4111111111111111';
            $cvv = '123';
            $expiry = '12/25';

            $validCard = $paymentService->isValidCardNumber($cardNumber);
            $validCvv = $paymentService->isValidCvv($cvv);
            $validExpiry = $paymentService->isValidExpiryDate($expiry);

            if ($validCard && $validCvv && $validExpiry) {
                $successfulOperations++;
            }
        }

        $endTime = microtime(true);
        $totalTime = $endTime - $startTime;

        // Verificar que todas las operaciones sean exitosas
        $this->assertEquals($operations, $successfulOperations, 
            'Todas las operaciones de validación deberían ser exitosas');

        echo "\n⚡ Resultados de Concurrencia PaymentService:\n";
        echo "   • Operaciones exitosas: {$successfulOperations}/{$operations}\n";
        echo "   • Tiempo total: " . round($totalTime, 3) . " segundos\n";
        echo "   • Operaciones por segundo: " . round($operations / $totalTime, 1) . "\n";
    }
} 