<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;
use App\Http\Livewire\VehiclesIndex;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if(config('app.env') !== 'local') {
            URL::forceScheme('https');
        }
        
        Livewire::component('vehicles-index', VehiclesIndex::class);
    }
}
