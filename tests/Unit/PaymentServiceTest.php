<?php

namespace Tests\Unit;

use App\Models\Payment;
use App\Services\PaymentService;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class PaymentServiceTest extends TestCase
{
    private PaymentService $paymentService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->paymentService = new PaymentService();
    }

    /**
     * Prueba unitaria: Validación de datos de tarjeta válidos
     * @test
     */
    public function test_validates_valid_card_data()
    {
        $validCardData = [
            'card_number' => '4111111111111111',
            'card_expiry' => '12/25',
            'card_cvv' => '123',
            'card_name' => 'Juan Perez'
        ];

        // Usando reflexión para probar método privado
        $reflection = new ReflectionClass($this->paymentService);
        $method = $reflection->getMethod('validateCardData');
        $method->setAccessible(true);

        // No debe lanzar excepción
        $this->expectNotToPerformAssertions();
        $method->invoke($this->paymentService, $validCardData);
    }

    /**
     * Prueba unitaria: Validación rechaza número de tarjeta inválido
     * @test
     */
    public function test_rejects_invalid_card_number()
    {
        $invalidCardData = [
            'card_number' => 'abc123',
            'card_expiry' => '12/25',
            'card_cvv' => '123',
            'card_name' => 'Juan Perez'
        ];

        $reflection = new ReflectionClass($this->paymentService);
        $method = $reflection->getMethod('validateCardData');
        $method->setAccessible(true);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Número de tarjeta inválido - debe contener solo números');
        $method->invoke($this->paymentService, $invalidCardData);
    }

    /**
     * Prueba unitaria: Validación rechaza tarjeta muy corta
     * @test
     */
    public function test_rejects_card_number_too_short()
    {
        $shortCardData = [
            'card_number' => '123456789012',
            'card_expiry' => '12/25',
            'card_cvv' => '123',
            'card_name' => 'Juan Perez'
        ];

        $reflection = new ReflectionClass($this->paymentService);
        $method = $reflection->getMethod('validateCardData');
        $method->setAccessible(true);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('El número de tarjeta debe tener entre 13 y 19 dígitos');
        $method->invoke($this->paymentService, $shortCardData);
    }

    /**
     * Prueba unitaria: Validación de formato de fecha de expiración
     * @test
     */
    public function test_validates_expiry_date_format()
    {
        $reflection = new ReflectionClass($this->paymentService);
        $method = $reflection->getMethod('isValidExpiryFormat');
        $method->setAccessible(true);

        // Fechas válidas
        $this->assertTrue($method->invoke($this->paymentService, '12/25'));
        $this->assertTrue($method->invoke($this->paymentService, '01/30'));
        
        // Fechas inválidas
        $this->assertFalse($method->invoke($this->paymentService, '13/25'));
        $this->assertFalse($method->invoke($this->paymentService, '12/2025'));
        $this->assertFalse($method->invoke($this->paymentService, '1/25'));
        $this->assertFalse($method->invoke($this->paymentService, '12-25'));
    }

    /**
     * Prueba unitaria: CVV inválido
     * @test
     */
    public function test_rejects_invalid_cvv()
    {
        $invalidCvvData = [
            'card_number' => '4111111111111111',
            'card_expiry' => '12/25',
            'card_cvv' => '12',
            'card_name' => 'Juan Perez'
        ];

        $reflection = new ReflectionClass($this->paymentService);
        $method = $reflection->getMethod('validateCardData');
        $method->setAccessible(true);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Código CVV debe tener 3 o 4 dígitos');
        $method->invoke($this->paymentService, $invalidCvvData);
    }

    /**
     * Prueba unitaria: Nombre del titular vacío
     * @test
     */
    public function test_rejects_empty_card_name()
    {
        $emptyNameData = [
            'card_number' => '4111111111111111',
            'card_expiry' => '12/25',
            'card_cvv' => '123',
            'card_name' => ''
        ];

        $reflection = new ReflectionClass($this->paymentService);
        $method = $reflection->getMethod('validateCardData');
        $method->setAccessible(true);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Nombre del titular requerido');
        $method->invoke($this->paymentService, $emptyNameData);
    }

    /**
     * Prueba unitaria: Cálculo de diferentes escenarios de tarjetas fallidas
     * @test
     */
    public function test_calculates_card_failure_scenarios()
    {
        $reflection = new ReflectionClass($this->paymentService);
        $method = $reflection->getMethod('simulateCardPayment');
        $method->setAccessible(true);

        // Mock de Payment
        $payment = $this->createMock(Payment::class);
        $payment->method('update')->willReturn(true);
        $payment->id = 1;
        $payment->amount = 100.00;
        $payment->payment_method = 'card';

        // Tarjeta declinada
        $declinedCard = ['card_number' => '4000000000000002'];
        $result = $method->invoke($this->paymentService, $payment, $declinedCard);
        $this->assertFalse($result['success']);
        $this->assertEquals('La tarjeta fue declinada por el banco', $result['message']);

        // Tarjeta expirada
        $expiredCard = ['card_number' => '4000000000000069'];
        $result = $method->invoke($this->paymentService, $payment, $expiredCard);
        $this->assertFalse($result['success']);
        $this->assertEquals('La tarjeta ha expirado', $result['message']);

        // Fondos insuficientes
        $insufficientCard = ['card_number' => '4000000000000119'];
        $result = $method->invoke($this->paymentService, $payment, $insufficientCard);
        $this->assertFalse($result['success']);
        $this->assertEquals('Fondos insuficientes en la cuenta', $result['message']);

        // CVV incorrecto
        $wrongCvvCard = ['card_number' => '4000000000000127'];
        $result = $method->invoke($this->paymentService, $payment, $wrongCvvCard);
        $this->assertFalse($result['success']);
        $this->assertEquals('Código CVV incorrecto', $result['message']);
    }

    /**
     * Prueba unitaria: Algoritmo de Luhn (aunque esté deshabilitado en simulación)
     * @test
     */
    public function test_luhn_algorithm_logic()
    {
        $reflection = new ReflectionClass($this->paymentService);
        $method = $reflection->getMethod('isValidLuhn');
        $method->setAccessible(true);

        // En modo simulación siempre retorna true
        $this->assertTrue($method->invoke($this->paymentService, '4111111111111111'));
        $this->assertTrue($method->invoke($this->paymentService, '1234567890123456'));
    }
} 