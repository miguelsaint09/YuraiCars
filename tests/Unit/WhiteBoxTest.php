<?php

namespace Tests\Unit;

use App\Services\PaymentService;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use ReflectionClass;
use ReflectionMethod;

class WhiteBoxTest extends TestCase
{
    use RefreshDatabase;
    
    private PaymentService $paymentService;
    private ReflectionClass $reflection;

    protected function setUp(): void
    {
        parent::setUp();
        $this->paymentService = app(PaymentService::class);
        $this->reflection = new ReflectionClass($this->paymentService);
    }

    /**
     * Prueba de Caja Blanca: Cobertura completa de validateCardData()
     * Examina todas las ramas del método de validación
     * @test
     */
    public function test_validate_card_data_complete_branch_coverage()
    {
        $method = $this->getPrivateMethod('validateCardData');

        // Rama 1: Número de tarjeta vacío
        try {
            $method->invoke($this->paymentService, ['card_number' => '']);
            $this->fail('Debería lanzar excepción para número vacío');
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('Número de tarjeta inválido - debe contener solo números', $e->getMessage());
        }

        // Rama 2: Número de tarjeta con caracteres no numéricos
        try {
            $method->invoke($this->paymentService, [
                'card_number' => '4111-1111-1111-1111',
                'card_expiry' => '12/25',
                'card_cvv' => '123',
                'card_name' => 'Test'
            ]);
            $this->fail('Debería lanzar excepción para caracteres no numéricos');
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('Número de tarjeta inválido - debe contener solo números', $e->getMessage());
        }

        // Rama 3: Número de tarjeta muy corto (12 dígitos)
        try {
            $method->invoke($this->paymentService, [
                'card_number' => '411111111111',
                'card_expiry' => '12/25',
                'card_cvv' => '123',
                'card_name' => 'Test'
            ]);
            $this->fail('Debería lanzar excepción para número muy corto');
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('El número de tarjeta debe tener entre 13 y 19 dígitos', $e->getMessage());
        }

        // Rama 4: Número de tarjeta muy largo (20 dígitos)
        try {
            $method->invoke($this->paymentService, [
                'card_number' => '41111111111111111111',
                'card_expiry' => '12/25',
                'card_cvv' => '123',
                'card_name' => 'Test'
            ]);
            $this->fail('Debería lanzar excepción para número muy largo');
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('El número de tarjeta debe tener entre 13 y 19 dígitos', $e->getMessage());
        }

        // Rama 5: Fecha de expiración inválida
        try {
            $method->invoke($this->paymentService, [
                'card_number' => '4111111111111111',
                'card_expiry' => '13/25',
                'card_cvv' => '123',
                'card_name' => 'Test'
            ]);
            $this->fail('Debería lanzar excepción para fecha inválida');
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('Fecha de expiración debe tener formato MM/YY', $e->getMessage());
        }

        // Rama 6: CVV muy corto
        try {
            $method->invoke($this->paymentService, [
                'card_number' => '4111111111111111',
                'card_expiry' => '12/25',
                'card_cvv' => '12',
                'card_name' => 'Test'
            ]);
            $this->fail('Debería lanzar excepción para CVV muy corto');
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('Código CVV debe tener 3 o 4 dígitos', $e->getMessage());
        }

        // Rama 7: CVV muy largo
        try {
            $method->invoke($this->paymentService, [
                'card_number' => '4111111111111111',
                'card_expiry' => '12/25',
                'card_cvv' => '12345',
                'card_name' => 'Test'
            ]);
            $this->fail('Debería lanzar excepción para CVV muy largo');
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('Código CVV debe tener 3 o 4 dígitos', $e->getMessage());
        }

        // Rama 8: Nombre muy corto
        try {
            $method->invoke($this->paymentService, [
                'card_number' => '4111111111111111',
                'card_expiry' => '12/25',
                'card_cvv' => '123',
                'card_name' => 'A'
            ]);
            $this->fail('Debería lanzar excepción para nombre muy corto');
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('Nombre del titular requerido', $e->getMessage());
        }

        // Rama 9: Datos válidos (no debe lanzar excepción)
        try {
            $method->invoke($this->paymentService, [
                'card_number' => '4111111111111111',
                'card_expiry' => '12/25',
                'card_cvv' => '123',
                'card_name' => 'Valid Name'
            ]);
            // Si llegamos aquí, la validación pasó correctamente
            $this->assertTrue(true, 'Datos válidos fueron aceptados correctamente');
        } catch (\Exception $e) {
            $this->fail('No debería lanzar excepción para datos válidos: ' . $e->getMessage());
        }
    }

    /**
     * Prueba de Caja Blanca: Análisis de condiciones límite en isValidExpiryFormat()
     * @test
     */
    public function test_expiry_format_boundary_conditions()
    {
        $method = $this->getPrivateMethod('isValidExpiryFormat');

        // Condiciones límite para meses
        $this->assertTrue($method->invoke($this->paymentService, '01/25')); // Mes mínimo válido
        $this->assertTrue($method->invoke($this->paymentService, '12/25')); // Mes máximo válido
        $this->assertFalse($method->invoke($this->paymentService, '00/25')); // Mes inválido bajo
        $this->assertFalse($method->invoke($this->paymentService, '13/25')); // Mes inválido alto

        // Condiciones límite para años
        $this->assertTrue($method->invoke($this->paymentService, '12/00')); // Año mínimo
        $this->assertTrue($method->invoke($this->paymentService, '12/99')); // Año máximo

        // Formatos límite
        $this->assertFalse($method->invoke($this->paymentService, '1/25')); // Mes de un dígito
        $this->assertFalse($method->invoke($this->paymentService, '12/2025')); // Año de 4 dígitos
        $this->assertFalse($method->invoke($this->paymentService, '12-25')); // Separador incorrecto
        $this->assertFalse($method->invoke($this->paymentService, '12/2')); // Año de un dígito
    }

    /**
     * Prueba de Caja Blanca: Cobertura de decisiones en simulateCardPayment()
     * @test
     */
    public function test_simulate_card_payment_decision_coverage()
    {
        $method = $this->getPrivateMethod('simulateCardPayment');
        $payment = $this->createMock(Payment::class);
        $payment->id = 1;
        $payment->amount = 100.00;
        $payment->payment_method = 'card';

        // Decisión 1: Tarjeta en lista de fallo - '4000000000000002'
        $payment->method('update')->willReturn(true);
        $result = $method->invoke($this->paymentService, $payment, ['card_number' => '4000000000000002']);
        $this->assertFalse($result['success']);
        $this->assertEquals('La tarjeta fue declinada por el banco', $result['message']);

        // Decisión 2: Tarjeta en lista de fallo - '4000000000000069'
        $result = $method->invoke($this->paymentService, $payment, ['card_number' => '4000000000000069']);
        $this->assertFalse($result['success']);
        $this->assertEquals('La tarjeta ha expirado', $result['message']);

        // Decisión 3: Tarjeta en lista de fallo - '4000000000000119'
        $result = $method->invoke($this->paymentService, $payment, ['card_number' => '4000000000000119']);
        $this->assertFalse($result['success']);
        $this->assertEquals('Fondos insuficientes en la cuenta', $result['message']);

        // Decisión 4: Tarjeta en lista de fallo - '4000000000000127'
        $result = $method->invoke($this->paymentService, $payment, ['card_number' => '4000000000000127']);
        $this->assertFalse($result['success']);
        $this->assertEquals('Código CVV incorrecto', $result['message']);

        // Decisión 5: Tarjeta NO en lista de fallo (éxito)
        $result = $method->invoke($this->paymentService, $payment, ['card_number' => '4111111111111111']);
        $this->assertTrue($result['success']);
        $this->assertEquals('Pago procesado exitosamente', $result['message']);
    }

    /**
     * Prueba de Caja Blanca: Verificación de flujo de control en processCardPayment()
     * @test
     */
    public function test_process_card_payment_control_flow()
    {
        $payment = $this->createMock(Payment::class);
        $payment->id = 1;

        // Flujo 1: Validación falla (InvalidArgumentException)
        $invalidCardData = [
            'card_number' => 'invalid',
            'card_expiry' => '12/25',
            'card_cvv' => '123',
            'card_name' => 'Test'
        ];

        $result = $this->paymentService->processCardPayment($payment, $invalidCardData);
        $this->assertFalse($result['success']);
        $this->assertEquals('Número de tarjeta inválido - debe contener solo números', $result['message']);

        // Flujo 2: Validación pasa, simulación ejecuta
        $validCardData = [
            'card_number' => '4111111111111111',
            'card_expiry' => '12/25',
            'card_cvv' => '123',
            'card_name' => 'Test User'
        ];

        $payment->method('update')->willReturn(true);
        $payment->payment_method = 'card';
        
        $result = $this->paymentService->processCardPayment($payment, $validCardData);
        $this->assertTrue($result['success']);
    }

    /**
     * Prueba de Caja Blanca: Análisis de paths independientes
     * @test
     */
    public function test_independent_paths_coverage()
    {
        // Path 1: Número inválido -> excepción -> catch InvalidArgumentException
        $payment = $this->createMock(Payment::class);
        $result = $this->paymentService->processCardPayment($payment, ['card_number' => '']);
        $this->assertFalse($result['success']);

        // Path 2: Datos válidos -> simulación exitosa
        $payment->method('update')->willReturn(true);
        $payment->payment_method = 'card';
        $validData = [
            'card_number' => '4111111111111111',
            'card_expiry' => '12/25',
            'card_cvv' => '123',
            'card_name' => 'Test User'
        ];
        $result = $this->paymentService->processCardPayment($payment, $validData);
        $this->assertTrue($result['success']);

        // Path 3: Datos válidos -> simulación fallida
        $failData = [
            'card_number' => '4000000000000002',
            'card_expiry' => '12/25',
            'card_cvv' => '123',
            'card_name' => 'Test User'
        ];
        $result = $this->paymentService->processCardPayment($payment, $failData);
        $this->assertFalse($result['success']);
    }

    /**
     * Prueba de Caja Blanca: Verificación de estado interno después de operaciones
     * @test
     */
    public function test_internal_state_verification()
    {
        // Crear un mock más simple y directo
        $payment = $this->createMock(Payment::class);
        
        // Configurar propiedades públicas directamente
        $payment->id = 1;
        $payment->amount = 100.00;
        $payment->payment_method = 'card';

        // Configurar el mock para manejar llamadas a propiedades y métodos
        $payment->method('__get')->willReturnMap([
            ['id', 1],
            ['amount', 100.00],
            ['payment_method', 'card']
        ]);

        $payment->method('__isset')->willReturn(true);

        // Configurar expectativas de update
        $payment->expects($this->once())
                ->method('update')
                ->willReturn(true);

        $validData = [
            'card_number' => '4111111111111111',
            'card_expiry' => '12/25',
            'card_cvv' => '123',
            'card_name' => 'Test User'
        ];

        $result = $this->paymentService->processCardPayment($payment, $validData);
        $this->assertTrue($result['success']);
    }

    /**
     * Prueba de Caja Blanca: Análisis de complejidad ciclomática
     * Verifica que todos los ciclos y decisiones están cubiertos
     * @test
     */
    public function test_cyclomatic_complexity_coverage()
    {
        // La función simulateCardPayment tiene complejidad ciclomática de 6
        // (1 entrada + 5 condiciones de decisión)
        
        $method = $this->getPrivateMethod('simulateCardPayment');
        $payment = $this->createMock(Payment::class);
        $payment->method('update')->willReturn(true);
        $payment->id = 1;

        // Testear todas las condiciones de decisión
        $testCases = [
            ['4000000000000002', false, 'La tarjeta fue declinada por el banco'],
            ['4000000000000069', false, 'La tarjeta ha expirado'],
            ['4000000000000119', false, 'Fondos insuficientes en la cuenta'],
            ['4000000000000127', false, 'Código CVV incorrecto'],
            ['4111111111111111', true, 'Pago procesado exitosamente'],
            ['5555555555554444', true, 'Pago procesado exitosamente'], // Otro número válido
        ];

        foreach ($testCases as [$cardNumber, $expectedSuccess, $expectedMessage]) {
            $result = $method->invoke($this->paymentService, $payment, ['card_number' => $cardNumber]);
            $this->assertEquals($expectedSuccess, $result['success']);
            $this->assertEquals($expectedMessage, $result['message']);
        }
    }

    /**
     * Helper method para acceder a métodos privados
     */
    private function getPrivateMethod(string $methodName): ReflectionMethod
    {
        $method = $this->reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method;
    }
} 