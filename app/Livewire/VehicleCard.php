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
    public string $dropoffLocation = "YuraiCars";

    #[Url(as: 'from')]
    public ?string $startTime = null;

    #[Url(as: 'to')]
    public ?string $endTime = null;

    #[Url(as: 'age')]
    public ?string $ageRange = "";

    public bool $showModal = false;

    public function showDetails()
    {
        $this->showModal = true;
    }

    public function hideDetails()
    {
        $this->showModal = false;
    }

    public function proceed()
    {
        if (!Auth::check()) {
            $this->dispatch('show-toast', 'You need to log in before continue', 'info');
            $this->redirect(route('login'));
            return;
        }

        // check profile complete
        if (!Auth::user()->profile || !Auth::user()->profile->is_completed) {
            $this->dispatch('show-toast', 'Please complete the profile', 'info');
            
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
                'dropoff_location' => 'YuraiCars', // Always set to YuraiCars
                'status' => RentalStatus::SELECTED->value,
            ]
        );

        // Ensure dropoff location is always YuraiCars even for existing rentals
        if ($rental->dropoff_location !== 'YuraiCars') {
            $rental->update(['dropoff_location' => 'YuraiCars']);
        }

        $this->redirect(route('rent-a-car.show', ['vehicle' => $this->vehicle]));
    }

    public function render()
    {
        return view('livewire.vehicle-card');
    }
}
