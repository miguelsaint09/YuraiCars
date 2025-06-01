<div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-y-8 md:gap-x-12">

    <!-- Booking Form -->
    <div class="rounded-lg col-span-1">
        <flux:heading size="lg" class="mb-8">Rent a car</flux:heading>

        <form wire:submit.prevent="filterAvailableVehicles" class="space-y-6">
            <flux:input wire:model.debounce.500ms="pickupLocation" label="Pickup Location" placeholder="Enter pickup location" required />
            <flux:input wire:model.debounce.500ms="dropoffLocation" label="Drop-off Location" placeholder="Enter drop-off location" required />

            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model.live="startTime" type="datetime-local" label="Start Time" required />
                <flux:input wire:model.live="endTime" type="datetime-local" label="End Time" required />
            </div>

            <flux:select wire:model.live="ageRange" label="Driver's Age Range" required>
                <option value="">Select age range</option>
                <option value="18-24">18-24</option>
                <option value="25-34">25-34</option>
                <option value="35-50">35-50</option>
                <option value="50+">50+</option>
            </flux:select>

            <flux:button type="submit" variant="primary" class="w-full">Find Available Cars</flux:button>
        </form>
    </div>

    <!-- Vehicles List (Scrollable) -->
    <div class="rounded-lg md:ml-10 overflow-y-auto max-h-[600px] col-span-2">
        <flux:heading size="lg" class="mb-8">Available Vehicles</flux:heading>

        @if(!empty($availableVehicles))
            <div class="space-y-4">
                @foreach ($availableVehicles as $vehicle)
                    <livewire:vehicle-card :vehicle="$vehicle" />
                @endforeach
            </div>
        @endif
    </div>
</div>
