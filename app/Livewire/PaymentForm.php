<?php

namespace App\Livewire;

use Livewire\Component;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\RentalStatus;
use App\Models\Payment;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    protected function rules()
    {
        return [
            'cardNumber' => ['required', function($attribute, $value, $fail) {
                $cleaned = preg_replace('/\D/', '', $value);
                if (strlen($cleaned) !== 16) {
                    $fail('El número de tarjeta debe tener 16 dígitos.');
                }
            }],
            'expiryDate' => ['required', 'string', 'regex:/^(0[1-9]|1[0-2])\/([0-9]{2})$/', 'after:today'],
            'cvv' => ['required', function($attribute, $value, $fail) {
                $cleaned = preg_replace('/\D/', '', $value);
                if (!in_array(strlen($cleaned), [3, 4])) {
                    $fail('El código de seguridad debe tener 3 o 4 dígitos.');
                }
            }],
            'cardHolderName' => ['required', 'string', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', 'min:3', 'max:100'],
            'cedula' => ['required', function($attribute, $value, $fail) {
                $cleaned = preg_replace('/\D/', '', $value);
                if (strlen($cleaned) !== 11) {
                    $fail('La cédula debe tener 11 dígitos.');
                }
            }],
            'phone' => ['required', function($attribute, $value, $fail) {
                $cleaned = preg_replace('/\D/', '', $value);
                if (strlen($cleaned) !== 10) {
                    $fail('El teléfono debe tener 10 dígitos.');
                }
            }],
            'email' => ['required', 'email', 'max:255'],
        ];
    }

    protected $messages = [
        'cardNumber.required' => 'El número de tarjeta es obligatorio.',
        'expiryDate.required' => 'La fecha de vencimiento es obligatoria.',
        'expiryDate.regex' => 'La fecha de vencimiento debe tener el formato MM/YY.',
        'expiryDate.after' => 'La tarjeta está vencida.',
        'cvv.required' => 'El código de seguridad es obligatorio.',
        'cardHolderName.required' => 'El nombre del titular es obligatorio.',
        'cardHolderName.regex' => 'El nombre del titular solo debe contener letras y espacios.',
        'cardHolderName.min' => 'El nombre del titular debe tener al menos 3 caracteres.',
        'cardHolderName.max' => 'El nombre del titular no puede tener más de 100 caracteres.',
        'cedula.required' => 'La cédula es obligatoria.',
        'phone.required' => 'El teléfono es obligatorio.',
        'email.required' => 'El correo electrónico es obligatorio.',
        'email.email' => 'El correo electrónico debe ser válido.',
        'email.max' => 'El correo electrónico no puede tener más de 255 caracteres.',
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
    }

    public function updatedExpiryDate()
    {
        $date = preg_replace('/\D/', '', $this->expiryDate);
        if (strlen($date) > 2) {
            $this->expiryDate = substr($date, 0, 2) . '/' . substr($date, 2);
        }

        // Validar en tiempo real
        $this->validateOnly('expiryDate');
    }

    public function updatedCvv()
    {
        $this->cvv = preg_replace('/\D/', '', $this->cvv);
        $this->validateOnly('cvv');
    }

    public function updatedCardHolderName()
    {
        // Validar en tiempo real
        $this->validateOnly('cardHolderName');
    }

    public function updatedCedula()
    {
        $this->cedula = preg_replace('/\D/', '', $this->cedula);
        $this->validateOnly('cedula');
    }

    public function updatedPhone()
    {
        $this->phone = preg_replace('/\D/', '', $this->phone);
        $this->validateOnly('phone');
    }

    public function updatedEmail()
    {
        // Validar en tiempo real
        $this->validateOnly('email');
    }

    public function processPayment()
    {
        try {
            DB::beginTransaction();

            // Limpiar datos antes de validar
            $this->cardNumber = preg_replace('/\D/', '', $this->cardNumber);
            $this->cedula = preg_replace('/\D/', '', $this->cedula);
            $this->phone = preg_replace('/\D/', '', $this->phone);
            $this->cvv = preg_replace('/\D/', '', $this->cvv);

            $this->validate();

            // Validar fecha de expiración
            [$month, $year] = explode('/', $this->expiryDate);
            $expiryDate = \Carbon\Carbon::createFromDate('20' . $year, $month, 1)->endOfMonth();
            
            if ($expiryDate->isPast()) {
                throw ValidationException::withMessages([
                    'expiryDate' => ['La tarjeta está vencida.']
                ]);
            }

            // Verificar que el rental existe y pertenece al usuario actual
            $rental = Rental::where('id', $this->rentalId)
                ->where('user_id', Auth::id())
                ->whereIn('status', [RentalStatus::SELECTED->value, RentalStatus::PENDING->value])
                ->first();

            if (!$rental) {
                throw ValidationException::withMessages([
                    'general' => ['No se encontró la reserva o ya no está disponible.']
                ]);
            }

            // Verificar que el monto coincide
            $expectedAmount = $rental->vehicle->price_per_day * 
                \Carbon\Carbon::parse($rental->start_time)->diffInDays(\Carbon\Carbon::parse($rental->end_time));

            if (abs($expectedAmount - $this->amount) > 0.01) {
                throw ValidationException::withMessages([
                    'general' => ['El monto del pago no coincide con el monto esperado.']
                ]);
            }

            // Crear el pago
            $payment = Payment::create([
                'rental_id' => $this->rentalId,
                'amount' => $this->amount,
                'payment_method' => PaymentMethod::CREDIT_CARD->value,
                'status' => PaymentStatus::SUCCESS->value,
            ]);

            // Actualizar el estado de la reserva
            $rental->update([
                'status' => RentalStatus::CONFIRMED->value
            ]);

            // Actualizar el estado del vehículo
            $rental->vehicle->update([
                'status' => 'booked'
            ]);

            DB::commit();

            // Disparar evento de pago procesado
            $this->dispatch('paymentProcessed', paymentId: $payment->id);

            // Redirigir al usuario
            return redirect()->route('profile.rents')->with('status', '¡Pago procesado exitosamente!');

        } catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al procesar el pago:', [
                'error' => $e->getMessage(),
                'rental_id' => $this->rentalId,
                'user_id' => Auth::id()
            ]);
            throw ValidationException::withMessages([
                'general' => ['Hubo un error al procesar el pago. Por favor, intente nuevamente.']
            ]);
        }
    }

    public function render()
    {
        return view('livewire.payment-form');
    }
} 