<?php

namespace App\Livewire;

use Livewire\Component;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class PaymentForm extends Component
{
    public $cardNumber = '';
    public $cardType = '';
    public $expiryDate = '';
    public $cvv = '';
    public $cardHolderName = '';
    public $cedula = '';
    public $phone = '';
    public $email = '';
    public $amount = 0;
    public $rentalId = '';
    public $errorMessage = '';

    protected $rules = [
        'cardNumber' => 'required|min:19|max:19',
        'expiryDate' => 'required|regex:/^(0[1-9]|1[0-2])\/\d{2}$/',
        'cvv' => 'required|numeric|digits_between:3,4',
        'cardHolderName' => 'required|regex:/^[A-ZÁÉÍÓÚÑ\s]+$/u|min:5',
        'cedula' => 'required|regex:/^\d{3}-\d{7}-\d{1}$/',
        'phone' => 'required|regex:/^\d{3}-\d{3}-\d{4}$/',
        'email' => 'required|email'
    ];

    protected $messages = [
        'cardNumber.required' => 'El número de tarjeta es obligatorio',
        'cardNumber.min' => 'El número de tarjeta debe tener 16 dígitos',
        'cardNumber.max' => 'El número de tarjeta debe tener 16 dígitos',
        'expiryDate.required' => 'La fecha de vencimiento es obligatoria',
        'expiryDate.regex' => 'Formato inválido. Use MM/YY (ejemplo: 12/25)',
        'cvv.required' => 'El código de seguridad es obligatorio',
        'cvv.numeric' => 'El código de seguridad debe ser numérico',
        'cvv.digits_between' => 'El código de seguridad debe tener entre 3 y 4 dígitos',
        'cardHolderName.required' => 'El nombre del titular es obligatorio',
        'cardHolderName.regex' => 'Solo se permiten letras y espacios',
        'cardHolderName.min' => 'El nombre debe tener al menos 5 caracteres',
        'cedula.required' => 'La cédula es obligatoria',
        'cedula.regex' => 'Formato inválido. Use 000-0000000-0',
        'phone.required' => 'El teléfono es obligatorio',
        'phone.regex' => 'Formato inválido. Use 000-000-0000',
        'email.required' => 'El correo electrónico es obligatorio',
        'email.email' => 'El correo electrónico no es válido'
    ];

    public function mount($rentalId, $amount)
    {
        $this->rentalId = $rentalId;
        $this->amount = $amount;
    }

    public function updated($propertyName)
    {
        // Limpiar datos antes de validar
        if ($propertyName === 'cardNumber') {
            $this->cardNumber = preg_replace('/[^0-9\s]/', '', $this->cardNumber);
        } elseif ($propertyName === 'cvv') {
            $this->cvv = preg_replace('/[^0-9]/', '', $this->cvv);
        } elseif ($propertyName === 'phone') {
            $this->phone = preg_replace('/[^0-9-]/', '', $this->phone);
        } elseif ($propertyName === 'cedula') {
            $this->cedula = preg_replace('/[^0-9-]/', '', $this->cedula);
        }

        // Solo validar campos que no sean la fecha de vencimiento
        if ($propertyName !== 'expiryDate') {
            $this->validateOnly($propertyName);
        }
    }

    public function updatedCardNumber()
    {
        // Eliminar cualquier caracter que no sea número
        $number = preg_replace('/\D/', '', $this->cardNumber);
        
        // Detectar tipo de tarjeta
        if (preg_match('/^4/', $number)) {
            $this->cardType = 'visa';
        } elseif (preg_match('/^5[1-5]/', $number)) {
            $this->cardType = 'mastercard';
        } elseif (preg_match('/^3[47]/', $number)) {
            $this->cardType = 'amex';
        } else {
            $this->cardType = '';
        }

        // Formatear número de tarjeta con espacios cada 4 dígitos
        if (strlen($number) > 0) {
            $formatted = implode(' ', str_split($number, 4));
            $this->cardNumber = $formatted;
        }
    }

    public function updatedExpiryDate()
    {
        // Eliminar cualquier caracter que no sea número
        $date = preg_replace('/[^0-9]/', '', $this->expiryDate);
        
        if (strlen($date) > 0) {
            // Si tenemos al menos 1 dígito
            if (strlen($date) >= 2) {
                // Obtener mes y año
                $month = substr($date, 0, 2);
                $year = substr($date, 2);
                
                // Validar y ajustar el mes
                $month = min(max(intval($month), 1), 12);
                $month = str_pad($month, 2, '0', STR_PAD_LEFT);
                
                // Formatear la fecha
                if (strlen($year) > 0) {
                    $this->expiryDate = $month . '/' . substr($year, 0, 2);
                    
                    // Solo validar cuando la fecha está completa (MM/YY)
                    if (strlen($this->expiryDate) === 5) {
                        try {
                            $this->validateOnly('expiryDate');
                        } catch (\Exception $e) {
                            // Ignorar errores de validación mientras se escribe
                        }
                    }
                } else {
                    $this->expiryDate = $month;
                }
            } else {
                $this->expiryDate = $date;
            }
        }
    }

    public function updatedCedula()
    {
        // Eliminar cualquier caracter que no sea número
        $cedula = preg_replace('/\D/', '', $this->cedula);
        
        // Formatear como XXX-XXXXXXX-X
        if (strlen($cedula) > 0) {
            $parts = [
                substr($cedula, 0, 3),
                substr($cedula, 3, 7),
                substr($cedula, 10, 1)
            ];
            $formatted = implode('-', array_filter($parts));
            $this->cedula = $formatted;
        }
    }

    public function updatedPhone()
    {
        // Eliminar cualquier caracter que no sea número
        $phone = preg_replace('/\D/', '', $this->phone);
        
        // Formatear como XXX-XXX-XXXX
        if (strlen($phone) > 0) {
            $parts = [
                substr($phone, 0, 3),
                substr($phone, 3, 3),
                substr($phone, 6, 4)
            ];
            $formatted = implode('-', array_filter($parts));
            $this->phone = $formatted;
        }
    }

    public function updatedCardHolderName()
    {
        // Convertir a mayúsculas y eliminar números
        $name = preg_replace('#[0-9]#', '', $this->cardHolderName);
        $this->cardHolderName = mb_strtoupper($name, 'UTF-8');
    }

    public function processPayment()
    {
        try {
            // Validar todos los campos
            $this->validate();

            // Si la validación pasa, procesar el pago
            $payment = Payment::create([
                'rental_id' => $this->rentalId,
                'amount' => $this->amount,
                'payment_method' => PaymentMethod::CREDIT_CARD->value,
                'status' => PaymentStatus::SUCCESS->value,
            ]);

            $this->dispatch('paymentProcessed', paymentId: $payment->id);
            
        } catch (\Exception $e) {
            Log::error('Error al procesar el pago: ' . $e->getMessage());
            $this->addError('payment', 'Ocurrió un error al procesar el pago. Por favor, intenta nuevamente.');
        }
    }

    public function render()
    {
        return view('livewire.payment-form');
    }
} 