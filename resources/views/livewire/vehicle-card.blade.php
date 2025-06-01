<div class="bg-white dark:bg-black shadow-md rounded-lg overflow-hidden transition-transform duration-300 hover:scale-[1.02] border border-neutral-200 dark:border-neutral-700">

    <!-- Card Header -->
    <flux:modal.trigger :name="'vehicle-detail-'.$vehicle->id" class="relative p-4">
        <flux:button icon="information-circle" variant="subtle" size="sm" class="absolute top-3 left-3">
            Details
        </flux:button>
    </flux:modal.trigger>

    <!-- Vehicle Image -->
    <img src="{{ asset('images/sedan.png') }}" class="w-full h-48 object-contain rounded-t-lg" />

    <!-- Vehicle Info -->
    <div class="p-4 text-center">
        <h3 class="text-xl font-semibold text-zinc-800 dark:text-white">{{ $vehicle->name }} - {{ $vehicle->year }}</h3>

        <div class="flex justify-center items-center gap-4 mt-3 text-zinc-600 dark:text-zinc-300">
            <span class="flex items-center gap-1"><flux:icon.users class="size-5" /> {{ $vehicle->seats }}</span>
            <span class="flex items-center gap-1"><flux:icon.briefcase class="size-5" /> {{ $vehicle->luggage_capacity }}</span>
            <span class="flex items-center gap-1"><flux:icon.cog class="size-5" /> {{ strtoupper(substr($vehicle->transmission, 0, 1)) }}</span>
            <span class="flex items-center gap-1"><flux:icon.fuel class="size-5" /> {{ strtoupper(substr($vehicle->fuel_type, 0, 1)) }}</span>
        </div>

        <!-- Price & Select Button -->
        <div class="mt-4 border-t pt-4">
            <div class="text-2xl font-bold text-primary mb-4">${{ number_format($vehicle->price_per_day, 2) }} <span class="text-sm">NZD</span></div>
            <flux:modal.trigger :name="'vehicle-detail-'.$vehicle->id" class="relative p-4">
                <flux:button class="w-full mt-2" variant="primary">Select</flux:button>
            </flux:modal.trigger>
        </div>
    </div>

    <!-- Modal -->
    <flux:modal class="max-w-6xl" :name="'vehicle-detail-'.$vehicle->id">
        <div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $vehicle->name }} - {{ $vehicle->year }}</h3>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $vehicle->make }} {{ $vehicle->model }}</p>
        </div>

        <div class="flex gap-x-20 flex-col md:flex-row mt-6">
            <div class="flex-1">
                <img src="{{ asset('images/sedan.png') }}" class="w-full h-64 object-contain rounded-lg" />
                
                <!-- Vehicle Specifications -->
                <div class="mt-6">
                    <h4 class="text-lg font-semibold mb-4">Vehicle Specifications</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">License Plate</p>
                            <p class="font-medium">{{ $vehicle->license_plate }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Category</p>
                            <p class="font-medium">{{ $vehicle->category }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Color</p>
                            <p class="font-medium">{{ $vehicle->color }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Seats</p>
                            <p class="font-medium">{{ $vehicle->seats }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Luggage Capacity</p>
                            <p class="font-medium">{{ $vehicle->luggage_capacity }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Transmission</p>
                            <p class="font-medium">{{ ucfirst($vehicle->transmission) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Fuel Type</p>
                            <p class="font-medium">{{ ucfirst($vehicle->fuel_type) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Mileage</p>
                            <p class="font-medium">{{ $vehicle->mileage }} km</p>
                        </div>
                        @if($vehicle->fuel_efficiency)
                        <div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Fuel Efficiency</p>
                            <p class="font-medium">{{ $vehicle->fuel_efficiency }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex-1">
                <!-- Features -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold mb-4">Features</h4>
                    <div class="flex flex-wrap gap-2">
                        @if(is_array($vehicle->features))
                            @foreach ($vehicle->features as $feature)
                                <flux:badge>{{ $feature }}</flux:badge>
                            @endforeach
                        @else
                            <p class="text-zinc-500 dark:text-zinc-400">No features available</p>
                        @endif
                    </div>
                </div>

                <!-- Remarks if any -->
                @if($vehicle->remarks)
                <div class="mb-6">
                    <h4 class="text-lg font-semibold mb-2">Additional Information</h4>
                    <p class="text-zinc-600 dark:text-zinc-300">{{ $vehicle->remarks }}</p>
                </div>
                @endif

                <!-- Pricing Details -->
                <div class="mt-6">
                    <h4 class="text-lg font-semibold mb-4">Pricing Details</h4>
                    <div class="bg-zinc-50 dark:bg-zinc-800 p-4 rounded-lg">
                        <div class="flex justify-between mb-2">
                            <span class="text-zinc-600 dark:text-zinc-300">Base Rate</span>
                            <span class="font-medium">${{ number_format($vehicle->price_per_day - 20, 2) }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-zinc-600 dark:text-zinc-300">Tax</span>
                            <span class="font-medium">${{ number_format(5, 2) }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-zinc-600 dark:text-zinc-300">Insurance</span>
                            <span class="font-medium">${{ number_format(10, 2) }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-zinc-600 dark:text-zinc-300">Cleaning Fee</span>
                            <span class="font-medium">${{ number_format(5, 2) }}</span>
                        </div>
                        <div class="border-t border-zinc-200 dark:border-zinc-700 mt-3 pt-3">
                            <div class="flex justify-between">
                                <span class="font-semibold">Total Per Day</span>
                                <span class="font-bold text-lg text-primary">${{ number_format($vehicle->price_per_day, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <flux:button class="w-full mt-6" variant="primary" wire:click="proceed">
                    Proceed to Booking
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>

@script
document.addEventListener('livewire:initialized', () => {
    Livewire.on('navigate', ({ url }) => {
        if (url) {
            window.location.href = url;
        }
    });
});
@endscript
