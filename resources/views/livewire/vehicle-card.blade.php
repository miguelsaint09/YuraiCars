<div class="bg-white dark:bg-black shadow-md rounded-lg overflow-hidden transition-transform duration-300 hover:scale-[1.02] border border-neutral-200 dark:border-neutral-700">

    <!-- Card Header -->
    <flux:modal.trigger :name="'vehicle-detail-'.$vehicle->id" class="relative p-4">
        <flux:button icon="information-circle" variant="subtle" size="sm" class="absolute top-3 left-3">
            Detalles
        </flux:button>
    </flux:modal.trigger>

    <!-- Vehicle Image -->
    @if($vehicle->image_url && is_array($vehicle->image_url) && !empty($vehicle->image_url))
        <img src="{{ Storage::url($vehicle->image_url[0]) }}" class="w-full h-48 object-contain rounded-t-lg" alt="{{ $vehicle->name }}" />
    @endif

    <!-- Vehicle Info -->
    <div class="p-4 text-center">
        <h3 class="text-xl font-semibold text-zinc-800 dark:text-white">{{ $vehicle->name }} - {{ $vehicle->year }}</h3>

        <div class="flex justify-center items-center gap-4 mt-3 text-zinc-600 dark:text-zinc-300">
            <span class="flex items-center gap-1" title="Asientos"><flux:icon.users class="size-5" /> {{ $vehicle->seats }}</span>
            <span class="flex items-center gap-1" title="Capacidad de equipaje"><flux:icon.briefcase class="size-5" /> {{ $vehicle->luggage_capacity }}L</span>
            <span class="flex items-center gap-1" title="Transmisión">
                <flux:icon.cog class="size-5" /> 
                {{ match($vehicle->transmission) {
                    'automatic' => 'Automático',
                    'manual' => 'Manual',
                    default => ucfirst($vehicle->transmission)
                } }}
            </span>
            <span class="flex items-center gap-1" title="Tipo de combustible">
                <flux:icon.fuel class="size-5" /> 
                {{ match($vehicle->fuel_type) {
                    'petrol' => 'Gasolina',
                    'diesel' => 'Diesel',
                    'electric' => 'Eléctrico',
                    'hybrid' => 'Híbrido',
                    default => ucfirst($vehicle->fuel_type)
                } }}
            </span>
        </div>

        <!-- Price & Select Button -->
        <div class="mt-4 border-t pt-4">
            <div class="text-2xl font-bold text-primary mb-4">${{ number_format($vehicle->price_per_day, 2) }} <span class="text-sm">DOP</span></div>
            <flux:modal.trigger :name="'vehicle-detail-'.$vehicle->id" class="relative p-4">
                <flux:button class="w-full mt-2" variant="primary">Seleccionar</flux:button>
            </flux:modal.trigger>
        </div>
    </div>

    <!-- Modal -->
    <flux:modal class="max-w-6xl px-6 md:px-12 mx-4 md:mx-8" :name="'vehicle-detail-'.$vehicle->id">
        <div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $vehicle->name }} - {{ $vehicle->year }}</h3>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $vehicle->make }} {{ $vehicle->model }}</p>
        </div>

        <div class="flex gap-x-20 flex-col md:flex-row mt-6">
            <div class="flex-1">
                @if($vehicle->image_url && is_array($vehicle->image_url) && !empty($vehicle->image_url))
                    <img src="{{ Storage::url($vehicle->image_url[0]) }}" class="w-full h-64 object-contain rounded-lg" alt="{{ $vehicle->name }}" />
                @else
                    <img src="{{ asset('images/sedan.png') }}" class="w-full h-64 object-contain rounded-lg" alt="{{ $vehicle->name }}" />
                @endif
                
                <!-- Vehicle Specifications -->
                <div class="mt-6">
                    <h4 class="text-lg font-semibold mb-4">Especificaciones del Vehículo</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Placa</p>
                            <p class="font-medium">{{ $vehicle->license_plate }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Categoría</p>
                            <p class="font-medium">{{ $vehicle->category }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Color</p>
                            <p class="font-medium">{{ $vehicle->color_formatted }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Asientos</p>
                            <p class="font-medium">{{ $vehicle->seats }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Capacidad de equipaje</p>
                            <p class="font-medium">{{ $vehicle->luggage_capacity }}L</p>
                        </div>
                        <div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Transmisión</p>
                            <p class="font-medium">{{ ucfirst($vehicle->transmission) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Tipo de combustible</p>
                            <p class="font-medium">{{ ucfirst($vehicle->fuel_type) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Kilometraje</p>
                            <p class="font-medium">{{ $vehicle->mileage_formatted }} km</p>
                        </div>
                        @if($vehicle->fuel_efficiency)
                        <div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Eficiencia de combustible</p>
                            <p class="font-medium">{{ $vehicle->fuel_efficiency }} km/L</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex-1">
                <!-- Features -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold mb-4">Características</h4>
                    <div class="flex flex-wrap gap-2">
                        @if(is_array($vehicle->features))
                            @foreach ($vehicle->features as $feature)
                                @php
                                    $featureEnum = \App\Enums\VehicleFeatures::tryFrom($feature);
                                    $featureText = $featureEnum ? $featureEnum->value : $feature;
                                @endphp
                                <flux:badge>{{ $featureText }}</flux:badge>
                            @endforeach
                        @else
                            <p class="text-zinc-500 dark:text-zinc-400">No hay características disponibles</p>
                        @endif
                    </div>
                </div>

                <!-- Remarks if any -->
                @if($vehicle->remarks)
                <div class="mb-6">
                    <h4 class="text-lg font-semibold mb-2">Información Adicional</h4>
                    <p class="text-zinc-600 dark:text-zinc-300">{{ $vehicle->remarks }}</p>
                </div>
                @endif

                <!-- Pricing Details -->
                <div class="mt-6">
                    <h4 class="text-lg font-semibold mb-4">Detalles de Precio</h4>
                    <div class="bg-zinc-50 dark:bg-zinc-800 p-4 rounded-lg">
                        <div class="flex justify-between mb-2">
                            <span class="text-zinc-600 dark:text-zinc-300">Tarifa base</span>
                            <span class="font-medium">${{ number_format($vehicle->price_per_day - 20, 2) }} DOP</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-zinc-600 dark:text-zinc-300">Impuestos</span>
                            <span class="font-medium">${{ number_format(5, 2) }} DOP</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-zinc-600 dark:text-zinc-300">Seguro</span>
                            <span class="font-medium">${{ number_format(10, 2) }} DOP</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-zinc-600 dark:text-zinc-300">Limpieza</span>
                            <span class="font-medium">${{ number_format(5, 2) }} DOP</span>
                        </div>
                        <div class="border-t border-zinc-200 dark:border-zinc-700 mt-3 pt-3">
                            <div class="flex justify-between">
                                <span class="font-semibold">Total por día</span>
                                <span class="font-bold text-lg text-primary">${{ number_format($vehicle->price_per_day, 2) }} DOP</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <flux:button class="w-full mt-6" variant="primary" wire:click="proceed">
                    Proceder a la Reserva
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
