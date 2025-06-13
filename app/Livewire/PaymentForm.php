<?php

namespace App\Livewire;

use Livewire\Component;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Payment;

class PaymentForm extends Component
{
    public $cardNumber = '';
    public $expiryDate = '';
    public $cvv = '';
    public $cardHolderName = '';
    public $amount = 0;
    public $rentalId = '';

    protected $rules = [
        'cardNumber' => ['required', 'string', 'regex:/^(?:\d{4} ){3}\d{4}$/'],
        'expiryDate' => ['required', 'string', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/'],
        'cvv' => ['required', 'string', 'regex:/^\d{3,4}$/'],
        'cardHolderName' => ['required', 'string', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u'],
    ];

    protected $messages = [
        'cardNumber.required' => 'El número de tarjeta es obligatorio.',
        'cardNumber.regex' => 'El número de tarjeta debe tener el formato XXXX XXXX XXXX XXXX.',
        'expiryDate.required' => 'La fecha de vencimiento es obligatoria.',
        'expiryDate.regex' => 'La fecha de vencimiento debe tener el formato MM/YY.',
        'cvv.required' => 'El código de seguridad es obligatorio.',
        'cvv.regex' => 'El CVV debe tener 3 o 4 dígitos.',
        'cardHolderName.required' => 'El nombre del titular es obligatorio.',
        'cardHolderName.regex' => 'El nombre solo debe contener letras y espacios.',
    ];

    public function mount($rentalId, $amount)
    {
        $this->rentalId = $rentalId;
        $this->amount = $amount;
    }

    public function updatedCardNumber()
    {
        // Solo números
        $number = preg_replace('/\D/', '', $this->cardNumber);
        // Máximo 16 dígitos
        $number = substr($number, 0, 16);
        // Formatear con espacios cada 4 dígitos
        $this->cardNumber = trim(implode(' ', str_split($number, 4)));
    }

    public function updatedExpiryDate()
    {
        // Solo números
        $date = preg_replace('/\D/', '', $this->expiryDate);
        // Máximo 4 dígitos
        $date = substr($date, 0, 4);
        // Formato MM/YY
        if(strlen($date) > 2) {
            $this->expiryDate = substr($date, 0, 2) . '/' . substr($date, 2);
        } else {
            $this->expiryDate = $date;
        }
    }

    public function updatedCvv()
    {
        // Solo números, máximo 4 dígitos
        $this->cvv = substr(preg_replace('/\D/', '', $this->cvv), 0, 4);
    }

    public function updatedCardHolderName()
    {
        // Solo letras y espacios
        $this->cardHolderName = preg_replace('/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/u', '', $this->cardHolderName);
    }

    public function processPayment()
    {
        $this->validate();
        // Simulamos un pago exitoso
        $payment = Payment::create([
            'rental_id' => $this->rentalId,
            'amount' => $this->amount,
            'payment_method' => PaymentMethod::CREDIT_CARD->value,
            'status' => PaymentStatus::SUCCESS->value,
        ]);
        $this->dispatch('paymentProcessed', paymentId: $payment->id);
    }

    public function render()
    {
        return view('livewire.payment-form')
            ->layout('components.layouts.app');
    }
} 