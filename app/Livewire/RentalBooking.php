<?php

namespace App\Livewire;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class RentalBooking extends Component
{
    public Vehicle $vehicle;
    public int $step = 1;

    public function mount(Vehicle $vehicle)
    {
        if ($vehicle->status !== 'available') {
            return redirect()->back()->with('error', 'Vehicle is not available for booking.');
        }

        $this->vehicle = $vehicle;
        Log::info($vehicle);
    }

    public function nextStep()
    {
        if ($this->step < 2) {
            $this->step++;
        }
    }

    public function previousStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function render()
    {
        return view('livewire.rental-booking');
    }
}
