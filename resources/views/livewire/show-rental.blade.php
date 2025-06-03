<div class="flex min-h-screen bg-zinc-100 dark:bg-zinc-900 gap-x-12">
    <!-- Left Sidebar -->
    <div class="w-1/4 p-6 bg-white dark:bg-zinc-800 shadow-md rounded-l-lg">
        <flux:heading size="lg" class="text-gray-800 dark:text-white mb-10">YuraiCars - Pasos de la Reserva</flux:heading>
        <ul class="space-y-4">
            <li class="flex items-center gap-2" :class="{ 'text-primary font-semibold': {{ $step }} === 1 }">
                <flux:icon.check-circle class="size-5 text-primary" /> Detalles de la Reserva
            </li>
            <li class="flex items-center gap-2" :class="{ 'text-primary font-semibold': {{ $step }} === 2 }">
                <flux:icon.credit-card class="size-5 text-primary" /> Pago
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
                    <flux:heading size="lg">YuraiCars - Confirmar tu Reserva</flux:heading>

                    <div class="max-w-6xl">
                        <div class="flex flex-col md:flex-row gap-x-12 mt-6">
                            <!-- Vehicle Image -->
                            @if($vehicle->image_url && is_array($vehicle->image_url) && !empty($vehicle->image_url))
                                <img src="{{ Storage::url($vehicle->image_url[0]) }}" class="flex-1 w-full h-64 object-cover rounded-lg" alt="{{ $vehicle->name }}" />
                            @endif

                            <!-- Vehicle Details -->
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $vehicle->name }} - {{ $vehicle->year }}</h3>
                                <p class="text-lg text-gray-600 dark:text-gray-300 mt-2">{{ $vehicle->category }} | {{ ucfirst($vehicle->transmission) }}</p>

                                <div class="mt-2">
                                    <span class="text-md text-gray-500 dark:text-gray-400">Precio de Alquiler:</span>
                                    <span class="text-lg font-semibold text-primary"> ${{ number_format($vehicle->price_per_day, 2) }} DOP/día</span>
                                </div>

                                <!-- Total Price Box -->
                                <div class="mt-4 p-2 bg-zinc-200 dark:bg-zinc-800 rounded-lg shadow-lg flex items-center justify-between">
                                    <div>
                                        <span class="text-lg font-semibold text-gray-800 dark:text-white">Precio Total</span>
                                        <p class="text-xl font-bold text-primary mt-2">
                                            ${{ number_format($totalPrice, 2) }} DOP
                                            <span class="text-sm text-gray-300">Por {{ $totalDays }} {{ Str::plural('día', $totalDays) }}</span>
                                        </p>
                                    </div>
                                </div>

                                <!-- Features -->
                                <div class="mt-6">
                                    <h4 class="text-md font-semibold text-gray-800 dark:text-white">Características</h4>
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        @foreach ($vehicle->features as $feature)
                                            <flux:badge class="px-3 py-1 text-sm bg-primary/10 text-primary rounded-full">{{ $feature }}</flux:badge>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rental Details Form -->
                        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <flux:input wire:model.live="pickupLocation" label="Lugar de Recogida" placeholder="Ingrese dirección en República Dominicana" required />
                            <flux:input wire:model.live="dropoffLocation" label="YuraiCars" readonly disabled />
                            <flux:input wire:model.live="startTime" type="datetime-local" label="Fecha de Inicio" required />
                            <flux:input wire:model.live="endTime" type="datetime-local" label="Fecha de Fin" required />
                        </div>
                        
                        <!-- Navigation Buttons -->
                        <div class="mt-6 flex justify-end gap-4">
                            <flux:button wire:click="nextStep" variant="primary">Proceder al Pago</flux:button>
                        </div>
                    </div>
                </div>
            @elseif ($step === 2)
                <!-- Step 2: Payment -->
                <div>
                    <flux:heading size="xl">YuraiCars - Pago y Confirmación</flux:heading>
                    <p class="text-gray-600 dark:text-gray-300 mt-4">Complete su reserva ingresando los detalles de pago.</p>

                    <div class="mt-6 bg-zinc-100 dark:bg-zinc-800 p-6 rounded-lg shadow-md">
                        <flux:input wire:model="cardNumber" label="Número de Tarjeta" placeholder="1234 5678 9012 3456" />
                        <div class="grid grid-cols-2 gap-4 mt-6">
                            <flux:input wire:model="expiryDate" label="Fecha de Vencimiento" placeholder="MM/YY" />
                            <flux:input wire:model="cvv" label="CVV" placeholder="123" />
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="mt-6 flex justify-between">
                        <flux:button wire:click="previousStep" variant="ghost">Volver</flux:button>
                        <flux:button type="submit" variant="primary" wire:click="completeBooking">Confirmar Pago</flux:button>
                    </div>
                </div>
            @endif
        </form>
    </div>
</div>
