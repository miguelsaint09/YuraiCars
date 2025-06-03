<div class="flex min-h-screen bg-zinc-100 dark:bg-zinc-900">
    <!-- Left Sidebar -->
    <div class="w-1/4 bg-white dark:bg-zinc-800 p-6 shadow-md">
        <flux:heading size="lg" class="text-gray-800 dark:text-white mb-4">YuraiCars - Proceso de Reserva</flux:heading>
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
    <div class="flex-1 p-10 bg-white dark:bg-zinc-900 shadow-lg rounded-lg">
        @if ($step === 1)
            <!-- Step 1: Booking Details -->
            <div>
                <flux:heading size="xl">YuraiCars - Confirmar Reserva</flux:heading>
                <div class="max-w-6xl">
                    <div>
                        <h3 class="text-xl font-semibold">{{ $vehicle->name }} - {{ $vehicle->year }}</h3>
                        <p class="text-sm text-zinc-500">{{ $vehicle->model }}</p>
                    </div>

                    <div class="flex gap-x-20 flex-col md:flex-row">
                        @if($vehicle->image_url && is_array($vehicle->image_url) && !empty($vehicle->image_url))
                            <img src="{{ Storage::url($vehicle->image_url[0]) }}" class="flex-1 w-full h-64 object-contain rounded-lg" alt="{{ $vehicle->name }}" />
                        @endif
            
                        <div class="flex-1">
                            {{-- <div class="mt-4 flex flex-wrap gap-2">
                                @foreach ($vehicle->features as $feature)
                                    <flux:badge>{{ $feature }}</flux:badge>
                                @endforeach
                            </div> --}}
            
                            <div class="mt-6">
                                <h4 class="text-lg font-semibold">Detalles del Precio</h4>
                                <div class="py-6 rounded-lg">
                                    <div class="flex justify-between">
                                        <span>Tarifa Base</span>
                                        <span>${{ number_format($vehicle->price_per_day - 20, 2) }} DOP</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Impuesto</span>
                                        <span>${{ number_format($vehicle->price_per_day, 2) }} DOP</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Seguro</span>
                                        <span>$10.00 DOP</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Tarifa de Limpieza</span>
                                        <span>$5.00 DOP</span>
                                    </div>
                                    <div class="border-t mt-3 pt-3 font-bold text-lg flex justify-between">
                                        <span>Total</span>
                                        <span>${{ number_format($vehicle->price_per_day, 2) }} DOP</span>
                                    </div>
                                </div>
                            </div>
                            <flux:button class="w-full" variant="primary" wire:click="proceed('{{ $vehicle->id }}')">Continuar</flux:button>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($step === 2)
            <!-- Step 2: Payment -->
            <div>
                <flux:heading size="xl">Pago y Checkout</flux:heading>
                <p class="text-gray-600 dark:text-gray-300 mt-4">Complete su reserva ingresando los detalles de pago.</p>

                <div class="mt-6 space-y-4">
                    <flux:input label="Número de Tarjeta" placeholder="1234 5678 9012 3456" />
                    <div class="grid grid-cols-2 gap-4">
                        <flux:input label="Fecha de Expiración" placeholder="MM/AA" />
                        <flux:input label="CVV" placeholder="123" />
                    </div>

                    <flux:button wire:click="previousStep" variant="ghost">Atrás</flux:button>
                    <flux:button wire:click="completeBooking" variant="primary" class="ml-4">Confirmar Pago</flux:button>
                </div>
            </div>
        @endif
    </div>
</div>
