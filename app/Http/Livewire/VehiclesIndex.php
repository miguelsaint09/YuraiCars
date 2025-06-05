<?php

namespace App\Http\Livewire;

use App\Models\Vehicle;
use Livewire\Component;

class VehiclesIndex extends Component
{
    public $showModal = false;
    public $selectedVehicle = null;

    public function mount()
    {
        $this->vehicles = Vehicle::all();
    }

    public function openModal($vehicleId)
    {
        $this->selectedVehicle = Vehicle::find($vehicleId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedVehicle = null;
    }

    public function render()
    {
        return view('livewire.vehicles-index');
    }
} 