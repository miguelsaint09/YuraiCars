<?php

namespace App\Livewire;

use App\Enums\VehicleStatus;
use App\Models\Vehicle;
use Livewire\Attributes\Url;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class VehiclesIndex extends Component
{
    #[Url]
    public string $category = '';

    #[Url]
    public string $transmission = '';

    #[Url(as: 'fuel-type')]
    public string $fuelType = '';

    #[Url(as: 'price-min')]
    public ?float $priceMin = null;

    #[Url(as: 'price-max')]
    public ?float $priceMax = null;

    public Collection $vehicles;

    public function mount(): void
    {
        $this->filterVehicles();
    }

    public function updated($propertyName): void
    {
        $this->filterVehicles();
    }

    public function filterVehicles(): void
    {
        $query = Vehicle::query()->where('status', VehicleStatus::AVAILABLE->value);

        if ($this->category !== '') {
            $query->where('category', $this->category);
        }

        if ($this->transmission !== '') {
            $query->where('transmission', strtolower($this->transmission));
        }

        if ($this->fuelType !== '') {
            $query->where('fuel_type', strtolower($this->fuelType));
        }

        if (!empty($this->priceMin)) {
            $query->where('price_per_day', '>=', $this->priceMin);
        }

        if (!empty($this->priceMax)) {
            $query->where('price_per_day', '<=', $this->priceMax);
        }

        $this->vehicles = $query->orderBy('price_per_day')->get();
    }

    public function render()
    {
        return view('livewire.vehicles-index');
    }
}

