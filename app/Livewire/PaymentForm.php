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
    public $errorMessage = '';

    protected $rules = [
        'cardNumber' => 'required|string|min:16|max:19',
        'expiryDate' => ['required', 'string', 'regex:#^(0[1-9]|1[0-2])/([0-9]{2})$#'],
        'cvv' => ['required', 'string', 'regex:#^[0-9]{3,4}$#'],
        'cardHolderName' => ['required', 'string', 'regex:#^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$#'],
        'cedula' => ['required', 'string', 'regex:#^[0-9]{11}$#'],
        'phone' => ['required', 'string', 'regex:#^[0-9]{10}$#'],
        'email' => 'required|email',
    ];

    protected $messages = [
        'cardNumber.required' => 'El número de tarjeta es obligatorio.',
        'cardNumber.min' => 'El número de tarjeta debe tener al menos 16 dígitos.',
        'cardNumber.max' => 'El número de tarjeta no puede tener más de 19 dígitos.',
        'expiryDate.required' => 'La fecha de vencimiento es obligatoria.',
        'expiryDate.regex' => 'La fecha de vencimiento debe tener el formato MM/YY.',
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
            
            // Limpiar los campos antes de validar
            $cleanCardNumber = preg_replace('#\D#', '', $this->cardNumber);
            $cleanCedula = preg_replace('#\D#', '', $this->cedula);
            $cleanPhone = preg_replace('#\D#', '', $this->phone);
            
            // Validar con los datos limpios
            $validatedData = $this->validate([
                'cardHolderName' => $this->rules['cardHolderName'],
                'email' => $this->rules['email'],
                'cvv' => $this->rules['cvv'],
                'expiryDate' => $this->rules['expiryDate'],
            ]);
            
            // Validar los campos formateados
            if (strlen($cleanCardNumber) < 16 || strlen($cleanCardNumber) > 19) {
                throw ValidationException::withMessages([
                    'cardNumber' => ['El número de tarjeta debe tener entre 16 y 19 dígitos.']
                ]);
            }
            
            if (strlen($cleanCedula) !== 11) {
                throw ValidationException::withMessages([
                    'cedula' => ['La cédula debe tener 11 dígitos.']
                ]);
            }
            
            if (strlen($cleanPhone) !== 10) {
                throw ValidationException::withMessages([
                    'phone' => ['El teléfono debe tener 10 dígitos.']
                ]);
            }

            // Validar fecha de expiración
            [$month, $year] = explode('/', $this->expiryDate);
            $expiryDate = \Carbon\Carbon::createFromDate('20' . $year, $month, 1)->endOfMonth();
            
            if ($expiryDate->isPast()) {
                throw ValidationException::withMessages([
                    'expiryDate' => ['La tarjeta está vencida.']
                ]);
            }

            // Simular pago exitoso
            $payment = Payment::create([
                'rental_id' => $this->rentalId,
                'amount' => $this->amount,
                'payment_method' => PaymentMethod::CREDIT_CARD->value,
                'status' => PaymentStatus::SUCCESS->value,
            ]);

            $this->dispatch('paymentProcessed', paymentId: $payment->id);
            
        } catch (ValidationException $e) {
            $this->errorMessage = 'Por favor, verifica los datos ingresados.';
            throw $e;
        } catch (\Exception $e) {
            $this->errorMessage = 'Ocurrió un error al procesar el pago. Por favor, intenta nuevamente.';
            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.payment-form');
    }
} 