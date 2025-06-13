<?php

namespace App\Livewire;

use Livewire\Component;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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

    protected $rules = [
        'cardNumber' => ['required', 'string', 'regex:/^[0-9]{16}$/'],
        'expiryDate' => ['required', 'string', 'regex:/^(0[1-9]|1[0-2])\/([0-9]{2})$/', 'after:today'],
        'cvv' => ['required', 'string', 'regex:/^[0-9]{3,4}$/'],
        'cardHolderName' => ['required', 'string', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'],
        'cedula' => ['required', 'string', 'regex:/^[0-9]{11}$/'],
        'phone' => ['required', 'string', 'regex:/^[0-9]{10}$/'],
        'email' => ['required', 'email'],
    ];

    protected $messages = [
        'cardNumber.required' => 'El número de tarjeta es obligatorio.',
        'cardNumber.regex' => 'El número de tarjeta debe tener 16 dígitos.',
        'expiryDate.required' => 'La fecha de vencimiento es obligatoria.',
        'expiryDate.regex' => 'La fecha de vencimiento debe tener el formato MM/YY.',
        'expiryDate.after' => 'La tarjeta está vencida.',
        'cvv.required' => 'El código de seguridad es obligatorio.',
        'cvv.regex' => 'El código de seguridad debe tener 3 o 4 dígitos.',
        'cardHolderName.required' => 'El nombre del titular es obligatorio.',
        'cardHolderName.regex' => 'El nombre del titular solo debe contener letras y espacios.',
        'cedula.required' => 'La cédula es obligatoria.',
        'cedula.regex' => 'La cédula debe tener 11 dígitos.',
        'phone.required' => 'El teléfono es obligatorio.',
        'phone.regex' => 'El teléfono debe tener 10 dígitos.',
        'email.required' => 'El correo electrónico es obligatorio.',
        'email.email' => 'El correo electrónico debe ser válido.',
    ];

    public function mount($rentalId, $amount)
    {
        $this->rentalId = $rentalId;
        $this->amount = $amount;
    }

    public function updatedCardNumber()
    {
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

        // Formatear número de tarjeta
        $this->cardNumber = implode(' ', str_split($number, 4));
    }

    public function updatedExpiryDate()
    {
        $date = preg_replace('/\D/', '', $this->expiryDate);
        if (strlen($date) > 2) {
            $this->expiryDate = substr($date, 0, 2) . '/' . substr($date, 2);
        }
    }

    public function updatedCedula()
    {
        $this->cedula = preg_replace('/\D/', '', $this->cedula);
    }

    public function updatedPhone()
    {
        $this->phone = preg_replace('/\D/', '', $this->phone);
    }

    public function processPayment()
    {
        $this->validate();

        // Validar fecha de expiración
        [$month, $year] = explode('/', $this->expiryDate);
        $expiryDate = \Carbon\Carbon::createFromDate('20' . $year, $month, 1)->endOfMonth();
        
        if ($expiryDate->isPast()) {
            throw ValidationException::withMessages([
                'expiryDate' => ['La tarjeta está vencida.']
            ]);
        }

        // En un entorno real, aquí iría la integración con el procesador de pagos
        // Por ahora, simulamos un pago exitoso
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
        return view('livewire.payment-form');
    }
} 