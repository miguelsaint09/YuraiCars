<div>
    <!-- Modal -->
    <div x-data="{ show: @entangle('showModal') }" 
         x-show="show" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-black/50"></div>

        <!-- Modal content -->
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white dark:bg-zinc-800 rounded-xl shadow-xl max-w-4xl w-full p-6 overflow-y-auto max-h-[90vh]">
                <!-- Close button -->
                <button wire:click="toggleModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <flux:icon.x-mark class="size-6" />
                </button>

                <!-- Modal header -->
                <div class="text-center mb-6">
                    <flux:heading size="xl" class="text-gray-900 dark:text-white">Rental Details</flux:heading>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Rental ID: {{ $rental->id }}</p>
                </div>

                <!-- Modal content -->
                <div class="space-y-6">
                    <!-- Customer Information -->
                    <div class="bg-zinc-50 dark:bg-zinc-900 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Customer Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Full Name</p>
                                <p class="font-medium">{{ $rental->user->profile->first_name }} {{ $rental->user->profile->last_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Email</p>
                                <p class="font-medium">{{ $rental->user->email }}</p>
                            </div>
                            @if($rental->user->profile)
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Phone</p>
                                <p class="font-medium">{{ $rental->user->profile->phone ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Address</p>
                                <p class="font-medium">{{ $rental->user->profile->address ?? 'Not provided' }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Vehicle Information -->
                    <div class="bg-zinc-50 dark:bg-zinc-900 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Vehicle Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Vehicle</p>
                                <p class="font-medium">{{ $rental->vehicle->name }} - {{ $rental->vehicle->year }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Category</p>
                                <p class="font-medium">{{ $rental->vehicle->category }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Transmission</p>
                                <p class="font-medium">{{ ucfirst($rental->vehicle->transmission) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Daily Rate</p>
                                <p class="font-medium">${{ number_format($rental->vehicle->price_per_day, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Make</p>
                                <p class="font-medium">{{ $rental->vehicle->make }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Model</p>
                                <p class="font-medium">{{ $rental->vehicle->model }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">License Plate</p>
                                <p class="font-medium">{{ $rental->vehicle->license_plate }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Color</p>
                                <p class="font-medium">{{ $rental->vehicle->color }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Seats</p>
                                <p class="font-medium">{{ $rental->vehicle->seats }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Fuel Type</p>
                                <p class="font-medium">{{ ucfirst($rental->vehicle->fuel_type) }}</p>
                            </div>
                            @if($rental->vehicle->features)
                            <div class="col-span-2">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Features</p>
                                <div class="flex flex-wrap gap-2 mt-1">
                                    @foreach($rental->vehicle->features as $feature)
                                        <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-md text-sm">
                                            {{ $feature }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Rental Information -->
                    <div class="bg-zinc-50 dark:bg-zinc-900 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Rental Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Pickup Location</p>
                                <p class="font-medium">{{ $rental->pickup_location }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Drop-off Location</p>
                                <p class="font-medium">{{ $rental->dropoff_location }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Start Time</p>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($rental->start_time)->format('M d, Y h:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">End Time</p>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($rental->end_time)->format('M d, Y h:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Total Days</p>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($rental->start_time)->diffInDays(\Carbon\Carbon::parse($rental->end_time)) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Status</p>
                                <flux:badge variant="{{ $rental->status === 'completed' ? 'success' : 'info' }}">
                                    {{ ucfirst($rental->status) }}
                                </flux:badge>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Created At</p>
                                <p class="font-medium">{{ $rental->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Last Updated</p>
                                <p class="font-medium">{{ $rental->updated_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="bg-zinc-50 dark:bg-zinc-900 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Payment Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Amount Paid</p>
                                <p class="font-medium">${{ number_format($rental->payment->amount, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Payment Method</p>
                                <p class="font-medium">{{ ucfirst(str_replace('_', ' ', $rental->payment->payment_method)) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Payment Status</p>
                                <flux:badge variant="{{ $rental->payment->status === 'paid' ? 'success' : 'warning' }}">
                                    {{ ucfirst($rental->payment->status) }}
                                </flux:badge>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Payment Date</p>
                                <p class="font-medium">{{ $rental->payment->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                            @if($rental->payment->transaction_id)
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Transaction ID</p>
                                <p class="font-medium">{{ $rental->payment->transaction_id }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Download Invoice Button -->
                    <div class="flex justify-end mt-6">
                        <flux:button wire:click="downloadInvoice" variant="primary">
                            <flux:icon.document-arrow-down class="size-5 mr-2" />
                            Download Invoice
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 