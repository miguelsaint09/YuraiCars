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

    public function mount($vehicle)
    {
        // Ensure we have a Vehicle model instance
        if (!$vehicle instanceof Vehicle) {
            $vehicle = Vehicle::findOrFail($vehicle);
        }
        
        $this->vehicle = $vehicle;

        // Buscar una reserva existente en estado SELECTED o PENDING
        $existingRental = Rental::where('user_id', Auth::id())
            ->where('vehicle_id', $vehicle->id)
            ->whereIn('status', [RentalStatus::SELECTED->value, RentalStatus::PENDING->value])
            ->first();

        // Si no existe una reserva, crear una nueva
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
        } else {
            // Ensure dropoff location is always YuraiCars
            $existingRental->update(['dropoff_location' => 'YuraiCars']);
        }

        $this->onGoingRental = $existingRental;
        
        // Cargar los datos de la reserva
        $this->pickupLocation = $this->onGoingRental->pickup_location ?? '';
        $this->dropoffLocation = $this->onGoingRental->dropoff_location;
        $this->startTime = $this->onGoingRental->start_time;
        $this->endTime = $this->onGoingRental->end_time;

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
        $this->validate([
            'pickupLocation' => ['required', 'string'],
            'dropoffLocation' => ['required', 'string'],
            'startTime' => ['required', 'date', 'after:now'],
            'endTime' => ['required', 'date', 'after:startTime'],
        ]);

        $this->onGoingRental->update([
            'pickup_location' => $this->pickupLocation,
            'dropoff_location' => $this->dropoffLocation,
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
        ]);

        $this->step = 2;
    }

    public function previousStep()
    {
        $this->step = 1;
    }

    public function handlePaymentProcessed($paymentId)
    {
        try {
            DB::beginTransaction();
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
            return redirect()->back()->with('error', 'Ocurrió un error. Por favor intente nuevamente.');
        }
    }

    public function completeBooking()
    {
        $this->validate([
            'pickupLocation' => ['required', 'string'],
            'dropoffLocation' => ['required', 'string'],
            'startTime' => ['required', 'date', 'after:now'],
            'endTime' => ['required', 'date', 'after:startTime'],
        ]);

        $this->onGoingRental->update([
            'pickup_location' => $this->pickupLocation,
            'dropoff_location' => $this->dropoffLocation,
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
        ]);

        $this->step = 2;
    }

    public function render()
    {
        return view('livewire.show-rental')
            ->layout('components.layouts.app');
    }

    private function updateTotalPrice()
    {
        if ($this->startTime && $this->endTime) {
            $start = Carbon::parse($this->startTime);
            $end = Carbon::parse($this->endTime);
            $this->totalDays = max($start->diffInDays($end), 1);
            $this->totalPrice = $this->vehicle->price_per_day * $this->totalDays;
        } else {
            $this->totalPrice = $this->vehicle->price_per_day;
        }
    }
}
