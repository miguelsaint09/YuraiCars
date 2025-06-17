<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /**
     * Procesar pago con tarjeta de crédito/débito (simulado)
     */
    public function processCardPayment(Payment $payment, array $cardData): array
    {
        try {
            // Validaciones básicas de formato
            $this->validateCardData($cardData);

            // Simulación de pago
            return $this->simulateCardPayment($payment, $cardData);

        } catch (\InvalidArgumentException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        } catch (\Exception $e) {
            Log::error('Error general en procesamiento de pago', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Error inesperado. Contacte al soporte técnico.',
            ];
        }
    }

    /**
     * Simulación de pago para desarrollo
     */
    private function simulateCardPayment(Payment $payment, array $cardData): array
    {
        // Simular diferentes escenarios basados en el número de tarjeta
        $cardNumber = str_replace(' ', '', $cardData['card_number']);
        
        // Tarjetas de prueba que fallan (simulación)
        $failingCards = [
            '4000000000000002', // Tarjeta declinada
            '4000000000000069', // Tarjeta expirada
            '4000000000000119', // Fondos insuficientes
            '4000000000000127', // CVV incorrecto
        ];
        
        if (in_array($cardNumber, $failingCards)) {
            $errorMessages = [
                '4000000000000002' => 'La tarjeta fue declinada por el banco',
                '4000000000000069' => 'La tarjeta ha expirado',
                '4000000000000119' => 'Fondos insuficientes en la cuenta',
                '4000000000000127' => 'Código CVV incorrecto',
            ];
            
            return [
                'success' => false,
                'message' => $errorMessages[$cardNumber] ?? 'La tarjeta fue declinada',
            ];
        }

        // Simular procesamiento exitoso
        $payment->update([
            'status' => 'success',
            'payment_method' => $payment->payment_method,
            'updated_at' => now(),
        ]);

        Log::info('Pago simulado procesado exitosamente', [
            'payment_id' => $payment->id,
            'amount' => $payment->amount,
            'card_last_four' => substr($cardNumber, -4),
            'method' => $payment->payment_method,
        ]);

        return [
            'success' => true,
            'payment_intent_id' => 'sim_' . uniqid(),
            'message' => 'Pago procesado exitosamente',
        ];
    }

    /**
     * Procesar pago en efectivo o transferencia
     */
    public function processCashOrTransferPayment(Payment $payment): array
    {
        try {
            // Actualizar el pago como exitoso
            $payment->update([
                'status' => 'success',
                'updated_at' => now(),
            ]);

            Log::info('Pago manual procesado', [
                'payment_id' => $payment->id,
                'method' => $payment->payment_method,
                'amount' => $payment->amount,
            ]);

            return [
                'success' => true,
                'message' => 'Pago registrado exitosamente',
            ];

        } catch (\Exception $e) {
            Log::error('Error procesando pago manual', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Error al procesar el pago. Intente nuevamente.',
            ];
        }
    }

    /**
     * Validar datos básicos de la tarjeta (modo simulación - validaciones relajadas)
     */
    private function validateCardData(array $cardData): void
    {
        // Validar número de tarjeta (solo formato básico para simulación)
        $cardNumber = str_replace(' ', '', $cardData['card_number'] ?? '');
        if (empty($cardNumber) || !is_numeric($cardNumber)) {
            throw new \InvalidArgumentException('Número de tarjeta inválido - debe contener solo números');
        }

        if (strlen($cardNumber) < 13 || strlen($cardNumber) > 19) {
            throw new \InvalidArgumentException('El número de tarjeta debe tener entre 13 y 19 dígitos');
        }

        // SIMULACIÓN: No validar algoritmo de Luhn para permitir cualquier número
        // En modo simulación, cualquier número de tarjeta con formato correcto es válido
        
        // Validar fecha de expiración (formato básico)
        if (empty($cardData['card_expiry']) || !$this->isValidExpiryFormat($cardData['card_expiry'])) {
            throw new \InvalidArgumentException('Fecha de expiración debe tener formato MM/YY');
        }

        // Validar CVV (solo formato)
        $cvv = $cardData['card_cvv'] ?? '';
        if (empty($cvv) || !is_numeric($cvv) || strlen($cvv) < 3 || strlen($cvv) > 4) {
            throw new \InvalidArgumentException('Código CVV debe tener 3 o 4 dígitos');
        }

        // Validar nombre del titular
        if (empty($cardData['card_name']) || strlen(trim($cardData['card_name'])) < 2) {
            throw new \InvalidArgumentException('Nombre del titular requerido');
        }
    }

    /**
     * Validar número de tarjeta usando algoritmo de Luhn (deshabilitado para simulación)
     * Este método no se usa en modo simulación para permitir cualquier número de tarjeta
     */
    private function isValidLuhn(string $number): bool
    {
        // En modo simulación, siempre retornamos true para permitir cualquier número
        return true;
        
        // Código original comentado para referencia:
        /*
        $number = strrev($number);
        $sum = 0;
        
        for ($i = 0; $i < strlen($number); $i++) {
            $digit = (int) $number[$i];
            
            if ($i % 2 === 1) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }
            
            $sum += $digit;
        }
        
        return $sum % 10 === 0;
        */
    }

    /**
     * Validar formato de fecha de expiración (solo formato, no fecha real - simulación)
     */
    private function isValidExpiryFormat(string $expiry): bool
    {
        // Solo validar formato MM/YY, no si la fecha es válida o futura
        return preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $expiry);
    }

    /**
     * Validar formato de fecha de expiración (método original - no usado en simulación)
     */
    private function isValidExpiry(string $expiry): bool
    {
        if (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $expiry)) {
            return false;
        }

        list($month, $year) = explode('/', $expiry);
        $year = '20' . $year;
        
        $expiryDate = \DateTime::createFromFormat('Y-m', $year . '-' . $month);
        $expiryDate->modify('last day of this month');
        
        return $expiryDate >= new \DateTime();
    }
} 