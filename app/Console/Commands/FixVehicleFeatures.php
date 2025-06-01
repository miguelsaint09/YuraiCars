<?php

namespace App\Console\Commands;

use App\Models\Vehicle;
use Illuminate\Console\Command;

class FixVehicleFeatures extends Command
{
    protected $signature = 'app:fix-vehicle-features';
    protected $description = 'Fix vehicle features that are not in array format';

    public function handle()
    {
        $vehicles = Vehicle::all();
        $fixed = 0;

        foreach ($vehicles as $vehicle) {
            if (!is_array($vehicle->features)) {
                $vehicle->features = [
                    'GPS Navigation',
                    'Bluetooth',
                    'Air Conditioning'
                ];
                $vehicle->save();
                $fixed++;
            }
        }

        $this->info("Fixed features for {$fixed} vehicles.");
    }
} 