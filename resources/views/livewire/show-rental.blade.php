<div class="flex min-h-screen bg-zinc-100 dark:bg-zinc-900 gap-x-12">
    <!-- Left Sidebar -->
    <div class="w-1/4 p-6 bg-white dark:bg-zinc-800 shadow-md rounded-l-lg">
        <flux:heading size="lg" class="text-gray-800 dark:text-white mb-10">Booking Steps</flux:heading>
        <ul class="space-y-4">
            <li class="flex items-center gap-2" :class="{ 'text-primary font-semibold': {{ $step }} === 1 }">
                <flux:icon.check-circle class="size-5 text-primary" /> Booking Details
            </li>
            <li class="flex items-center gap-2" :class="{ 'text-primary font-semibold': {{ $step }} === 2 }">
                <flux:icon.credit-card class="size-5 text-primary" /> Payment
            </li>
        </ul>
    </div>

    <!-- Right Content -->
    <div class="flex-1 py-6 px-12 bg-white dark:bg-zinc-900 shadow-lg rounded-r-lg">
        <form wire:submit.prevent="completeBooking" method="POST">
            @csrf
            @if ($step === 1)
                <!-- Step 1: Booking Details -->
                <div>
                    <flux:heading size="lg">Confirm Your Booking</flux:heading>

                    <div class="max-w-6xl">
                        <div class="flex flex-col md:flex-row gap-x-12 mt-6">
                            <!-- Vehicle Image -->
                            <img src="{{ asset('images/sedan.png') }}" class="flex-1 w-full h-64 object-cover rounded-lg" />

                            <!-- Vehicle Details -->
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $vehicle->name }} - {{ $vehicle->year }}</h3>
                                <p class="text-lg text-gray-600 dark:text-gray-300 mt-2">{{ $vehicle->category }} | {{ ucfirst($vehicle->transmission) }}</p>

                                <div class="mt-2">
                                    <span class="text-md text-gray-500 dark:text-gray-400">Rental Price:</span>
                                    <span class="text-lg font-semibold text-primary"> ${{ number_format($vehicle->price_per_day, 2) }}/day</span>
                                </div>

                                <!-- Total Price Box -->
                                <div class="mt-4 p-2 bg-zinc-200 dark:bg-zinc-800 rounded-lg shadow-lg flex items-center justify-between">
                                    <div>
                                        <span class="text-lg font-semibold text-gray-800 dark:text-white">Total Price</span>
                                        <p class="text-xl font-bold text-primary mt-2">
                                            ${{ number_format($totalPrice, 2) }}
                                            <span class="text-sm text-gray-300">For {{ $totalDays }} {{ Str::plural('day', $totalDays) }}</span>
                                        </p>
                                    </div>
                                </div>

                                <!-- Features -->
                                <div class="mt-6">
                                    <h4 class="text-md font-semibold text-gray-800 dark:text-white">Features</h4>
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        @foreach ($vehicle->features as $feature)
                                            <flux:badge class="px-3 py-1 text-sm bg-primary/10 text-primary rounded-full">{{ $feature }}</flux:badge>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rental Details -->
                        <div class="mt-6 bg-zinc-100 dark:bg-zinc-800 p-6 rounded-lg shadow-md">
                            <h4 class="text-lg font-semibold mb-4">Rental Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <flux:input wire:model.live="pickupLocation" label="Pickup Location" placeholder="Enter pickup location" required />
                                <flux:input wire:model.live="dropoffLocation" label="Drop-off Location" placeholder="Enter drop-off location" required />
                                <flux:input wire:model.live="startTime" type="datetime-local" label="Start Time" required />
                                <flux:input wire:model.live="endTime" type="datetime-local" label="End Time" required />
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="mt-6 flex justify-end gap-4">
                            <flux:button wire:click="nextStep" variant="primary">Proceed to Payment</flux:button>
                        </div>
                    </div>
                </div>
            @elseif ($step === 2)
                <!-- Step 2: Payment -->
                <div>
                    <flux:heading size="xl">Payment & Checkout</flux:heading>
                    <p class="text-gray-600 dark:text-gray-300 mt-4">Complete your booking by entering payment details.</p>

                    <div class="mt-6 bg-zinc-100 dark:bg-zinc-800 p-6 rounded-lg shadow-md">
                        <flux:input wire:model="cardNumber" label="Card Number" placeholder="1234 5678 9012 3456" />
                        <div class="grid grid-cols-2 gap-4 mt-6">
                            <flux:input wire:model="expiryDate" label="Expiry Date" placeholder="MM/YY" />
                            <flux:input wire:model="cvv" label="CVV" placeholder="123" />
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="mt-6 flex justify-between">
                        <flux:button wire:click="previousStep" variant="ghost">Back</flux:button>
                        <flux:button type="submit" variant="primary" wire:click="completeBooking">Confirm Payment</flux:button>
                    </div>
                </div>
            @endif
        </form>
    </div>
</div>
