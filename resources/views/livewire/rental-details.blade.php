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
                    <flux:heading size="xl" class="text-gray-900 dark:text-white">YuraiCars - Detalles del Alquiler</flux:heading>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Rental ID: {{ $rental->id }}</p>
                </div>

                <!-- Modal content -->
                <div class="space-y-6 overflow-y-auto max-h-[70vh]">
                    <!-- Customer Information -->
                    <div class="bg-zinc-50 dark:bg-zinc-900 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Información del Cliente</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Nombre Completo</p>
                                <p class="font-medium">{{ $rental->user->profile->first_name }} {{ $rental->user->profile->last_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Correo Electrónico</p>
                                <p class="font-medium">{{ $rental->user->email }}</p>
                            </div>
                            @if($rental->user->profile)
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Teléfono</p>
                                <p class="font-medium">{{ $rental->user->profile->phone ?? 'No proporcionado' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Dirección</p>
                                <p class="font-medium">{{ $rental->user->profile->address ?? 'No proporcionada' }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Vehicle Information -->
                    <div class="bg-zinc-50 dark:bg-zinc-900 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Información del Vehículo</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Vehículo</p>
                                <p class="font-medium">{{ $rental->vehicle->name }} - {{ $rental->vehicle->year }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Categoría</p>
                                <p class="font-medium">{{ $rental->vehicle->category }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Transmisión</p>
                                <p class="font-medium">{{ ucfirst($rental->vehicle->transmission) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Tarifa Diaria</p>
                                <p class="font-medium">${{ number_format($rental->vehicle->price_per_day, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Asientos</p>
                                <p class="font-medium">{{ $rental->vehicle->seats }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Tipo de Combustible</p>
                                <p class="font-medium">{{ ucfirst($rental->vehicle->fuel_type) }}</p>
                            </div>
                            @if($rental->vehicle->features)
                            <div class="col-span-2">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Características</p>
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
                        <h3 class="text-lg font-semibold mb-4">Información del Alquiler</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Lugar de Recogida</p>
                                <p class="font-medium">{{ $rental->pickup_location }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Lugar de Devolución</p>
                                <p class="font-medium">{{ $rental->dropoff_location }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Fecha de Inicio</p>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($rental->start_time)->format('d M, Y h:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Fecha de Fin</p>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($rental->end_time)->format('d M, Y h:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Total de Días</p>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($rental->start_time)->diffInDays(\Carbon\Carbon::parse($rental->end_time)) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Estado</p>
                                <flux:badge variant="{{ $rental->status === 'completed' ? 'success' : 'info' }}">
                                    {{ match($rental->status) {
                                        'selected' => 'Seleccionado',
                                        'pending' => 'Pendiente',
                                        'confirmed' => 'Confirmado',
                                        'approved' => 'Aprobado',
                                        'rejected' => 'Rechazado',
                                        'active' => 'Activo',
                                        'completed' => 'Completado',
                                        'cancelled' => 'Cancelado',
                                        default => ucfirst($rental->status)
                                    } }}
                                </flux:badge>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="bg-zinc-50 dark:bg-zinc-900 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Información de Pago</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Monto Pagado</p>
                                <p class="font-medium">${{ number_format($rental->payment->amount, 2) }} DOP</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Método de Pago</p>
                                <p class="font-medium">{{ match($rental->payment->payment_method) {
                                    'credit_card' => 'Tarjeta de Crédito',
                                    'debit_card' => 'Tarjeta de Débito',
                                    'cash' => 'Efectivo',
                                    default => ucfirst(str_replace('_', ' ', $rental->payment->payment_method))
                                } }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Estado del Pago</p>
                                <flux:badge variant="{{ $rental->payment->status === 'success' ? 'success' : 'warning' }}">
                                    {{ match($rental->payment->status) {
                                        'pending' => 'Pendiente',
                                        'success' => 'Pagado',
                                        'failed' => 'Fallido',
                                        'canceled' => 'Cancelado',
                                        'refunded' => 'Reembolsado',
                                        default => ucfirst($rental->payment->status)
                                    } }}
                                </flux:badge>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Fecha de Pago</p>
                                <p class="font-medium">{{ $rental->payment->created_at->format('d M, Y h:i A') }}</p>
                            </div>
                            @if($rental->payment->transaction_id)
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">ID de Transacción</p>
                                <p class="font-medium">{{ $rental->payment->transaction_id }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Download Invoice Button -->
                <div class="flex justify-end mt-6">
                    <flux:button wire:click="downloadInvoice" variant="primary">
                        <flux:icon.document-arrow-down class="size-5 mr-2" />
                        Descargar Factura
                    </flux:button>
                </div>
            </div>
        </div>
    </div>
</div>