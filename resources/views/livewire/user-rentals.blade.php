<div class="container mx-auto px-6 py-10">
    <flux:heading size="xl" class="text-gray-900 dark:text-white">My Rentals</flux:heading>

    @if (session('status'))
        <div class="mt-4 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-lg">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mt-4 p-4 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    @if($rentals->isEmpty())
        <p class="mt-6 text-gray-600 dark:text-gray-400">You haven't rented any vehicles yet.</p>
    @else
        <div class="mt-6 space-y-6">
            @foreach($rentals as $rental)
                <div class="bg-white dark:bg-zinc-800 p-6 shadow-md rounded-lg flex flex-col md:flex-row gap-x-12 gap-y-6">
                    <!-- Vehicle Image -->
                    <img src="{{ asset('images/sedan.png') }}" 
                         class="w-48 h-32 object-contain rounded-lg shadow-md" 
                         alt="Car Image">

                    <!-- Rental Details -->
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                            {{ $rental->vehicle->name }} - {{ $rental->vehicle->year }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $rental->vehicle->category }} | {{ ucfirst($rental->vehicle->transmission) }}</p>

                        @if($rental->pickup_location)
                            <div class="mt-2">
                                <span class="text-gray-800 dark:text-white font-semibold">Pickup:</span>
                                <span class="text-gray-600 dark:text-gray-300">{{ $rental->pickup_location }}</span>
                            </div>
                        @endif

                        @if($rental->dropoff_location)
                            <div class="mt-1">
                                <span class="text-gray-800 dark:text-white font-semibold">Drop-off:</span>
                                <span class="text-gray-600 dark:text-gray-300">{{ $rental->dropoff_location }}</span>
                            </div>
                        @endif

                        @if($rental->start_time && $rental->end_time)
                            <div class="mt-1">
                                <span class="text-gray-800 dark:text-white font-semibold">Rental Period:</span>
                                <span class="text-gray-600 dark:text-gray-300 text-sm">
                                    {{ \Carbon\Carbon::parse($rental->start_time)->format('M d, h:i A') }} 
                                    - 
                                    {{ \Carbon\Carbon::parse($rental->end_time)->format('M d, h:i A') }}
                                </span>
                            </div>
                        @endif

                        <!-- Status Badge -->
                        <div class="mt-4">
                            <span class="text-gray-800 dark:text-white font-semibold">Status:</span>
                            <flux:badge variant="{{ in_array($rental->status, ['selected', 'pending']) ? 'warning' : ($rental->status === 'completed' ? 'success' : 'info') }}">
                                {{ ucfirst($rental->status) }}
                            </flux:badge>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-4 flex gap-2">
                            @if($rental->status === 'selected')
                                <flux:button wire:click="continueBooking('{{ $rental->id }}')" variant="primary">
                                    Continue Booking
                                </flux:button>
                                <flux:button 
                                    wire:click="deleteRental('{{ $rental->id }}')" 
                                    variant="danger"
                                    wire:confirm="Are you sure you want to delete this rental?">
                                    Delete Rental
                                </flux:button>
                            @endif

                            @if($rental->payment)
                                <livewire:rental-details :rental-id="$rental->id" :key="$rental->id" />
                                <button 
                                    wire:click="$dispatch('show-details', { rentalId: '{{ $rental->id }}' })"
                                    class="inline-flex items-center px-4 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 group">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5 mr-2 text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                        <polyline points="14 2 14 8 20 8"/>
                                        <line x1="16" y1="13" x2="8" y2="13"/>
                                        <line x1="16" y1="17" x2="8" y2="17"/>
                                        <line x1="10" y1="9" x2="8" y2="9"/>
                                    </svg>
                                    <span class="font-medium">View Details</span>
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Info -->
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Payment Details</h4>
                        @if($rental->payment)
                            <p class="text-gray-600 dark:text-gray-300">
                                <span class="font-semibold">Amount Paid:</span> ${{ number_format($rental->payment->amount, 2) }}
                            </p>
                            <p class="text-gray-600 dark:text-gray-300">
                                <span class="font-semibold">Payment Method:</span> {{ ucfirst(str_replace('_', ' ', $rental->payment->payment_method)) }}
                            </p>
                            <p class="text-gray-600 dark:text-gray-300">
                                <span class="font-semibold">Status:</span> 
                                <flux:badge variant="{{ $rental->payment->status === 'paid' ? 'success' : 'warning' }}">
                                    {{ ucfirst($rental->payment->status) }}
                                </flux:badge>
                            </p>
                        @else
                            <p class="text-red-500">Payment not found.</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>