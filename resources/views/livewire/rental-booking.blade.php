<div class="flex min-h-screen bg-zinc-100 dark:bg-zinc-900">
    <!-- Left Sidebar -->
    <div class="w-1/4 bg-white dark:bg-zinc-800 p-6 shadow-md">
        <flux:heading size="lg" class="text-gray-800 dark:text-white mb-4">Booking Steps</flux:heading>
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
    <div class="flex-1 p-10 bg-white dark:bg-zinc-900 shadow-lg rounded-lg">
        @if ($step === 1)
            <!-- Step 1: Booking Details -->
            <div>
                <flux:heading size="xl">Confirm Your Booking</flux:heading>
                <div class="max-w-6xl">
                    <div>
                        <h3 class="text-xl font-semibold">{{ $vehicle->name }} - {{ $vehicle->year }}</h3>
                        <p class="text-sm text-zinc-500">{{ $vehicle->model }}</p>
                    </div>

                    <div class="flex gap-x-20 flex-col md:flex-row">
                        <img src="{{ asset('images/sedan.png') }}" class="flex-1 w-full h-64 object-contain rounded-lg" />
            
                        <div class="flex-1">
                            {{-- <div class="mt-4 flex flex-wrap gap-2">
                                @foreach ($vehicle->features as $feature)
                                    <flux:badge>{{ $feature }}</flux:badge>
                                @endforeach
                            </div> --}}
            
                            <div class="mt-6">
                                <h4 class="text-lg font-semibold">Pricing Details</h4>
                                <div class="py-6 rounded-lg">
                                    <div class="flex justify-between">
                                        <span>Base Rate</span>
                                        <span>${{ number_format($vehicle->price_per_day - 20, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Tax</span>
                                        <span>${{ number_format($vehicle->price_per_day, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Insurance</span>
                                        <span>$10.00</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Cleaning Fee</span>
                                        <span>$5.00</span>
                                    </div>
                                    <div class="border-t mt-3 pt-3 font-bold text-lg flex justify-between">
                                        <span>Total</span>
                                        <span>${{ number_format($vehicle->price_per_day, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            <flux:button class="w-full" variant="primary" wire:click="proceed('{{ $vehicle->id }}')">Proceed</flux:button>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($step === 2)
            <!-- Step 2: Payment -->
            <div>
                <flux:heading size="xl">Payment & Checkout</flux:heading>
                <p class="text-gray-600 dark:text-gray-300 mt-4">Complete your booking by entering payment details.</p>

                <div class="mt-6 space-y-4">
                    <flux:input label="Card Number" placeholder="1234 5678 9012 3456" />
                    <div class="grid grid-cols-2 gap-4">
                        <flux:input label="Expiry Date" placeholder="MM/YY" />
                        <flux:input label="CVV" placeholder="123" />
                    </div>

                    <flux:button wire:click="previousStep" variant="ghost">Back</flux:button>
                    <flux:button wire:click="completeBooking" variant="primary" class="ml-4">Confirm Payment</flux:button>
                </div>
            </div>
        @endif
    </div>
</div>
