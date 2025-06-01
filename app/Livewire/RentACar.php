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
    public string $dropoffLocation = "";

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

    public function filterAvailableVehicles()
    {
        if (!$this->pickupLocation || !$this->dropoffLocation || !$this->startTime || !$this->endTime) {
            return;
        }

        $this->availableVehicles = Vehicle::where('status', 'available')
            ->orderBy('price_per_day')
            ->get();
    }

    public function render()
    {
        return view('livewire.rent-a-car');
}
}
