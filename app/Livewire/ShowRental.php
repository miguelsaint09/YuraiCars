<?php

namespace App\Livewire;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\RentalStatus;
use App\Enums\VehicleStatus;
use App\Models\Payment;
use App\Models\Rental;
use App\Models\Vehicle;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ShowRental extends Component
{
    public Vehicle $vehicle;
    public ?Rental $onGoingRental = null;

    public ?string $pickupLocation = null;
    public ?string $dropoffLocation = null;
    public ?string $startTime = null;
    public ?string $endTime = null;
    public string $paymentMethod = '';

    public float $totalPrice = 0.0;
    public int $totalDays = 1;
    public int $step = 1;

    protected $listeners = ['paymentProcessed' => 'handlePaymentProcessed'];

    protected $rules = [
        'pickupLocation' => 'required|string|min:5',
        'dropoffLocation' => 'required|string',
        'startTime' => 'required',
        'endTime' => 'required',
    ];

    protected $messages = [
        'pickupLocation.required' => 'La dirección de recogida es obligatoria.',
        'pickupLocation.min' => 'La dirección de recogida debe tener al menos 5 caracteres.',
        'startTime.required' => 'La fecha de inicio es obligatoria.',
        'endTime.required' => 'La fecha de fin es obligatoria.',
    ];

    public function mount($vehicle)
    {
        if (!$vehicle instanceof Vehicle) {
            $vehicle = Vehicle::findOrFail($vehicle);
        }
        
        $this->vehicle = $vehicle;

        $existingRental = Rental::where('user_id', Auth::id())
            ->where('vehicle_id', $vehicle->id)
            ->whereIn('status', [RentalStatus::SELECTED->value, RentalStatus::PENDING->value])
            ->first();

        if (!$existingRental) {
            $existingRental = Rental::create([
                'user_id' => Auth::id(),
                'vehicle_id' => $vehicle->id,
                'status' => RentalStatus::SELECTED->value,
                'pickup_location' => '',
                'dropoff_location' => 'YuraiCars',
                'start_time' => null,
                'end_time' => null,
            ]);
        }

        $this->onGoingRental = $existingRental;
        $this->pickupLocation = $existingRental->pickup_location ?? '';
        $this->dropoffLocation = $existingRental->dropoff_location;
        $this->startTime = $existingRental->start_time;
        $this->endTime = $existingRental->end_time;

        $this->updateTotalPrice();
    }

    public function updated($property)
    {
        if (in_array($property, ['startTime', 'endTime'])) {
            $this->updateTotalPrice();
        }
    }

    public function nextStep()
    {
        $this->validate();

        try {
            $this->onGoingRental->update([
                'pickup_location' => $this->pickupLocation,
                'dropoff_location' => $this->dropoffLocation,
                'start_time' => $this->startTime,
                'end_time' => $this->endTime,
                'status' => RentalStatus::PENDING->value,
            ]);

            $this->step = 2;
        } catch (\Exception $e) {
            Log::error('Error al avanzar al paso de pago: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al procesar los datos. Por favor, intenta nuevamente.');
        }
    }

    public function previousStep()
    {
        $this->step = 1;
    }

    public function handlePaymentProcessed($paymentId)
    {
        try {
            DB::beginTransaction();
            
            // Verificar que el pago existe y está en estado exitoso
            $payment = Payment::findOrFail($paymentId);
            if ($payment->status !== PaymentStatus::SUCCESS->value) {
                throw new \Exception('El pago no fue exitoso.');
            }

            // Verificar que la renta existe y está en estado pendiente
            if (!$this->onGoingRental || $this->onGoingRental->status !== RentalStatus::PENDING->value) {
                throw new \Exception('La renta no está en estado pendiente.');
            }
            
            $this->onGoingRental->update([
                'status' => RentalStatus::CONFIRMED->value,
            ]);
            
            $this->vehicle->update([
                'status' => VehicleStatus::BOOKED->value,
            ]);
            
            DB::commit();
            
            return redirect()->route('profile.rents')->with('status', 'Reserva completada exitosamente!');
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Error al confirmar la reserva: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al guardar la reserva. Por favor intenta nuevamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al confirmar la reserva: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.show-rental');
    }

    private function updateTotalPrice()
    {
        if ($this->startTime && $this->endTime) {
            try {
                $start = Carbon::parse($this->startTime);
                $end = Carbon::parse($this->endTime);
                $this->totalDays = max($start->diffInDays($end), 1);
                $this->totalPrice = $this->vehicle->price_per_day * $this->totalDays;
            } catch (\Exception $e) {
                $this->totalPrice = $this->vehicle->price_per_day;
                $this->totalDays = 1;
            }
        } else {
            $this->totalPrice = $this->vehicle->price_per_day;
            $this->totalDays = 1;
        }
    }
}
