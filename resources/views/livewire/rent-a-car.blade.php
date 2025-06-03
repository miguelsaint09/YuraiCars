<div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-y-8 md:gap-x-12">

    <!-- Booking Form -->
    <div class="rounded-lg col-span-1">
        <flux:heading size="lg" class="mb-8">YuraiCars - Alquiler de Vehículos</flux:heading>

        <form wire:submit.prevent="filterAvailableVehicles" class="space-y-6">
            <flux:input wire:model.debounce.500ms="pickupLocation" label="Lugar de Recogida" placeholder="Ingrese dirección en República Dominicana" required />
            <flux:input wire:model.debounce.500ms="dropoffLocation" label="YuraiCars" readonly disabled />

            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model.live="startTime" type="datetime-local" label="Fecha de Inicio" required />
                <flux:input wire:model.live="endTime" type="datetime-local" label="Fecha de Fin" required />
            </div>

            <flux:select wire:model.live="ageRange" label="Rango de Edad del Conductor" required>
                <option value="">Seleccione rango de edad</option>
                <option value="18-24">18-24</option>
                <option value="25-34">25-34</option>
                <option value="35-50">35-50</option>
                <option value="50+">50+</option>
            </flux:select>

            <flux:button type="submit" variant="primary" class="w-full">Buscar Autos Disponibles</flux:button>
        </form>
    </div>

    <!-- Vehicles List (Scrollable) -->
    <div class="rounded-lg md:ml-10 overflow-y-auto max-h-[600px] col-span-2">
        <flux:heading size="lg" class="mb-8">Vehículos Disponibles</flux:heading>

        @if(!empty($availableVehicles))
            <div class="space-y-4">
                @foreach ($availableVehicles as $vehicle)
                    <livewire:vehicle-card :vehicle="$vehicle" />
                @endforeach
            </div>
        @else
            <p class="text-gray-600 dark:text-gray-400">No hay vehículos disponibles para las fechas seleccionadas.</p>
        @endif
    </div>
</div>
