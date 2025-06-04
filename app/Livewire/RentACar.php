<?php

namespace App\Livewire;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RentACar extends Component
{
    #[Validate('required', 'string')]
    #[Url(as: 'pick-up', history: true)]
    public string $pickupLocation = "";

    #[Validate('required', 'string')]
    #[Url(as: 'drop-off', history: true)]
    public string $dropoffLocation = "YuraiCars";

    #[Validate('required', 'date', 'after:now')]
    #[Url(as: 'from', history: true)]
    public string $startTime = "";

    #[Validate('required', 'date', 'after:startTime')]
    #[Url(as: 'to', history: true)]
    public string $endTime = "";

    #[Validate('required', 'string')]
    #[Url(as: 'age', history: true)]
    public string $ageRange = "";

    public Collection $availableVehicles;

    public function mount(): void
    {
        $this->availableVehicles = new Collection();
        $this->loadAvailableVehicles();
    }

    public function loadAvailableVehicles(): void
    {
        $this->availableVehicles = Vehicle::where('status', 'available')
            ->orderBy('price_per_day')
            ->get();
    }

    public function filterAvailableVehicles()
    {
        $this->validate();
        
        if (!$this->pickupLocation || !$this->dropoffLocation || !$this->startTime || !$this->endTime) {
            session()->flash('error', 'Por favor complete todos los campos requeridos.');
            return;
        }

        $this->availableVehicles = Vehicle::where('status', 'available')
            ->orderBy('price_per_day')
            ->get();

        session()->flash('success', 'Búsqueda completada. Se encontraron ' . $this->availableVehicles->count() . ' vehículos disponibles.');
    }

    public function render()
    {
        return view('livewire.rent-a-car');
    }
}
