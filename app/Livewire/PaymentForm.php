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
        'expiryDate' => 'required|regex:/^(0[1-9]|1[0-2])\/([0-9]{2})$/',
        'cvv' => 'required|numeric|min:3|max:4',
        'cardHolderName' => 'required|regex:/^[A-ZÁÉÍÓÚÑ\s]+$/u|min:5',
        'cedula' => 'required|regex:/^\d{3}-\d{7}-\d{1}$/',
        'phone' => 'required|regex:/^\d{3}-\d{3}-\d{4}$/',
        'email' => 'required|email'
    ];

    protected $messages = [
        'cardNumber.required' => 'El número de tarjeta es obligatorio.',
        'cardNumber.min' => 'El número de tarjeta debe tener 16 dígitos.',
        'cardNumber.max' => 'El número de tarjeta debe tener 16 dígitos.',
        'expiryDate.required' => 'La fecha de vencimiento es obligatoria.',
        'expiryDate.regex' => 'La fecha de vencimiento debe tener el formato MM/YY.',
        'cvv.required' => 'El código de seguridad es obligatorio.',
        'cvv.numeric' => 'El código de seguridad debe ser numérico.',
        'cvv.min' => 'El código de seguridad debe tener entre 3 y 4 dígitos.',
        'cvv.max' => 'El código de seguridad debe tener entre 3 y 4 dígitos.',
        'cardHolderName.required' => 'El nombre del titular es obligatorio.',
        'cardHolderName.regex' => 'El nombre del titular solo debe contener letras y espacios.',
        'cardHolderName.min' => 'El nombre del titular debe tener al menos 5 caracteres.',
        'cedula.required' => 'La cédula es obligatoria.',
        'cedula.regex' => 'La cédula debe tener el formato 000-0000000-0.',
        'phone.required' => 'El teléfono es obligatorio.',
        'phone.regex' => 'El teléfono debe tener el formato 000-000-0000.',
        'email.required' => 'El correo electrónico es obligatorio.',
        'email.email' => 'El correo electrónico debe ser válido.'
    ];

    public function mount($rentalId, $amount)
    {
        $this->rentalId = $rentalId;
        $this->amount = $amount;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        $this->errorMessage = '';
    }

    public function updatedCardNumber()
    {
        // Eliminar cualquier caracter que no sea número
        $number = preg_replace('#\D#', '', $this->cardNumber);
        
        // Detectar tipo de tarjeta
        if (preg_match('#^4#', $number)) {
            $this->cardType = 'visa';
        } elseif (preg_match('#^5[1-5]#', $number)) {
            $this->cardType = 'mastercard';
        } elseif (preg_match('#^3[47]#', $number)) {
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
        $date = preg_replace('#\D#', '', $this->expiryDate);
        
        // Formatear como MM/YY
        if (strlen($date) >= 2) {
            $month = substr($date, 0, 2);
            $year = substr($date, 2);
            
            // Asegurar que el mes esté entre 01 y 12
            $month = min(max(intval($month), 1), 12);
            $month = str_pad($month, 2, '0', STR_PAD_LEFT);
            
            $this->expiryDate = $month . ($year ? '/' . $year : '');
        } else if (strlen($date) > 0) {
            $this->expiryDate = $date;
        }
    }

    public function updatedCedula()
    {
        // Eliminar cualquier caracter que no sea número
        $cedula = preg_replace('#\D#', '', $this->cedula);
        
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
        $phone = preg_replace('#\D#', '', $this->phone);
        
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
            $this->errorMessage = '';
            
            // Validar los campos básicos
            $this->validate();

            // Simular pago exitoso
            $payment = Payment::create([
                'rental_id' => $this->rentalId,
                'amount' => $this->amount,
                'payment_method' => PaymentMethod::CREDIT_CARD->value,
                'status' => PaymentStatus::SUCCESS->value,
            ]);

            $this->dispatch('paymentProcessed', paymentId: $payment->id);
            
        } catch (ValidationException $e) {
            $this->errorMessage = 'Por favor, completa todos los campos requeridos.';
            return;
        } catch (\Exception $e) {
            $this->errorMessage = 'Ocurrió un error al procesar el pago. Por favor, intenta nuevamente.';
            Log::error('Error al procesar el pago: ' . $e->getMessage());
            return;
        }
    }

    public function render()
    {
        return view('livewire.payment-form');
    }
} 