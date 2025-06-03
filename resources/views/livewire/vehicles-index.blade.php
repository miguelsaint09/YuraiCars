<div class="bg-zinc-50 dark:bg-zinc-900 py-8">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
             <!-- Filters -->
            <div class="lg:col-span-1 rounded-lg h-full">
                <flux:heading size="lg" class="mb-4 text-zinc-800 dark:text-white">Filtrar Vehículos</flux:heading>

                <div class="space-y-6">
                    <!-- Category -->
                    <flux:select wire:model.live="category" label="Categoría" placeholder="Seleccionar categoría">
                        <flux:select.option>Sedán</flux:select.option>
                        <flux:select.option>SUV</flux:select.option>
                        <flux:select.option>Hatchback</flux:select.option>
                        <flux:select.option>Convertible</flux:select.option>
                        <flux:select.option>Camioneta</flux:select.option>
                        <flux:select.option>Van</flux:select.option>
                    </flux:select>

                    <!-- Transmission -->
                    <flux:select wire:model.live="transmission" label="Transmisión" placeholder="Seleccionar transmisión">
                        <flux:select.option>Automático</flux:select.option>
                        <flux:select.option>Manual</flux:select.option>
                    </flux:select>

                    <!-- Fuel Type -->
                    <flux:select wire:model.live="fuelType" label="Tipo de Combustible" placeholder="Seleccionar tipo">
                        <flux:select.option>Gasolina</flux:select.option>
                        <flux:select.option>Diesel</flux:select.option>
                        <flux:select.option>Eléctrico</flux:select.option>
                        <flux:select.option>Híbrido</flux:select.option>
                    </flux:select>

                    <!-- Price Range -->
                    <flux:input wire:model.live="priceMin" type="number" label="Precio Mínimo ($)" placeholder="0" />
                    <flux:input wire:model.live="priceMax" type="number" label="Precio Máximo ($)" placeholder="300" />
                </div>
            </div>

            <!-- Vehicle List -->
            <div class="lg:col-span-3">
                <flux:heading size="lg" class="mb-8">Vehículos Disponibles</flux:heading>
                @if($vehicles->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400">No se encontraron vehículos con los filtros seleccionados.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($vehicles as $vehicle)
                            <livewire:vehicle-card :key="$vehicle->id" :vehicle="$vehicle" />
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
