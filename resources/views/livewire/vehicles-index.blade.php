<div class="bg-zinc-50 dark:bg-zinc-900 py-8">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
             <!-- Filters -->
            <div class="lg:col-span-1 rounded-lg h-full">
                <flux:heading size="lg" class="mb-4 text-zinc-800 dark:text-white">Filter Vehicles</flux:heading>

                <div class="space-y-6">
                    <!-- Category -->
                    <flux:select wire:model.live="category" label="Category" placeholder="Select category">
                        <flux:select.option>Sedan</flux:select.option>
                        <flux:select.option>SUV</flux:select.option>
                        <flux:select.option>Hatchback</flux:select.option>
                        <flux:select.option>Convertible</flux:select.option>
                        <flux:select.option>Truck</flux:select.option>
                        <flux:select.option>Van</flux:select.option>
                    </flux:select>

                    <!-- Transmission -->
                    <flux:select wire:model.live="transmission" label="Transmission" placeholder="Select transmission">
                        <flux:select.option>Automatic</flux:select.option>
                        <flux:select.option>Manual</flux:select.option>
                    </flux:select>

                    <!-- Fuel Type -->
                    <flux:select wire:model.live="fuelType" label="Fuel Type" placeholder="Select fuel type">
                        <flux:select.option>Petrol</flux:select.option>
                        <flux:select.option>Diesel</flux:select.option>
                        <flux:select.option>Electric</flux:select.option>
                        <flux:select.option>Hybrid</flux:select.option>
                    </flux:select>

                    <!-- Price Range -->
                    <flux:input wire:model.live="priceMin" type="number" label="Min Price ($)" placeholder="0" />
                    <flux:input wire:model.live="priceMax" type="number" label="Max Price ($)" placeholder="300" />
                </div>
            </div>

            <!-- Vehicle List (Right Side) -->
            <div class="lg:col-span-3 md:h-[calc(100vh-72px)] overflow-y-auto">
                <flux:heading size="lg" class="mb-4 text-zinc-800 dark:text-white text-center lg:text-left">
                    Available Vehicles
                </flux:heading>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @if(!empty($vehicles))
                        @foreach ($vehicles as $vehicle)
                            <livewire:vehicle-card 
                                wire:key="vehicles-{{ $vehicle->id }}"
                                :vehicle="$vehicle" 
                            />
                        @endforeach
                    @else
                        <p class="text-center text-zinc-500 dark:text-zinc-300 col-span-3">No vehicles match your filters.</p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
</div>
