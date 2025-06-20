<?php

namespace App\Livewire;

use App\Enums\RentalStatus;
use App\Enums\VehicleStatus;
use App\Models\Rental;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Url;
use Livewire\Component;

class VehicleCard extends Component
{
    public Vehicle $vehicle;

    #[Url(as: 'pick-up')]
    public ?string $pickupLocation = null;

    #[Url(as: 'drop-off')]
    public ?string $dropoffLocation = null;

    #[Url(as: 'from')]
    public ?string $startTime = null;

    #[Url(as: 'to')]
    public ?string $endTime = null;

    #[Url(as: 'age')]
    public ?string $ageRange = "";

    public function proceed()
    {
        if (!Auth::check()) {
            $this->dispatch('show-toast', 'You need to log in before continue', 'info');
            $this->redirect(route('login'));
            return;
        }

        // check profile complete
        if (!Auth::user()->profile || !Auth::user()->profile->is_completed) {
            $this->dispatch('show-toast', 'Por favor, complete su información personal antes de continuar con la reserva. Esto es necesario para procesar su alquiler.', 'info');
            
            // Store the target URL for after profile completion
            $targetUrl = route('rent-a-car.show', ['vehicle' => $this->vehicle]);
            Log::info('Storing redirect URL:', ['url' => $targetUrl]);
            
            session(['redirect_to' => $targetUrl]);
            $this->redirect(route('profile'));
            return;
        }

        if ($this->vehicle->status !== VehicleStatus::AVAILABLE->value) {
            $this->redirect(route('vehicles.index'));
            return;
        }

        // If coming from vehicles index without booking parameters, redirect to rent-a-car
        if (empty($this->startTime) || empty($this->endTime)) {
            $this->redirect(route('rent-a-car.show', ['vehicle' => $this->vehicle]));
            return;
        }

        $rental = Rental::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'vehicle_id' => $this->vehicle->id,
            ],
            [
                'start_time' => $this->startTime,
                'end_time' => $this->endTime,
                'pickup_location' => $this->pickupLocation,
                'dropoff_location' => $this->dropoffLocation,
                'status' => RentalStatus::SELECTED->value,
            ]
        );

        $this->redirect(route('rent-a-car.show', ['vehicle' => $this->vehicle]));
    }

    public function render()
    {
        return view('livewire.vehicle-card');
    }
}
