<div class="container mx-auto px-6 py-10">
    <flux:heading size="xl" class="text-gray-900 dark:text-white">YuraiCars - Mis Alquileres</flux:heading>

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
        <p class="mt-6 text-gray-600 dark:text-gray-400">Aún no has alquilado ningún vehículo.</p>
    @else
        <div class="mt-6 space-y-6">
            @foreach($rentals as $rental)
                <div class="bg-white dark:bg-zinc-800 p-6 shadow-md rounded-lg">
                    <div class="flex flex-col md:flex-row gap-x-12 gap-y-6">
                        <!-- Vehicle Image -->
                        @if($rental->vehicle->image_url && is_array($rental->vehicle->image_url) && !empty($rental->vehicle->image_url))
                            <img src="{{ Storage::url($rental->vehicle->image_url[0]) }}" 
                             class="w-48 h-32 object-contain rounded-lg shadow-md" 
                                 alt="{{ $rental->vehicle->name }}">
                        @endif

                        <!-- Rental Details -->
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                                {{ $rental->vehicle->name }} - {{ $rental->vehicle->year }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $rental->vehicle->category }} | {{ ucfirst($rental->vehicle->transmission) }}</p>

                            @if($rental->pickup_location)
                                <div class="mt-2">
                                    <span class="text-gray-800 dark:text-white font-semibold">Lugar de Recogida:</span>
                                    <span class="text-gray-600 dark:text-gray-300">{{ $rental->pickup_location }}</span>
                                </div>
                            @endif

                            @if($rental->dropoff_location)
                                <div class="mt-1">
                                    <span class="text-gray-800 dark:text-white font-semibold">Lugar de Devolución:</span>
                                    <span class="text-gray-600 dark:text-gray-300">{{ $rental->dropoff_location }}</span>
                                </div>
                            @endif

                            @if($rental->start_time && $rental->end_time)
                                <div class="mt-1">
                                    <span class="text-gray-800 dark:text-white font-semibold">Período de Alquiler:</span>
                                    <span class="text-gray-600 dark:text-gray-300 text-sm">
                                        {{ \Carbon\Carbon::parse($rental->start_time)->format('d M, h:i A') }} 
                                        - 
                                        {{ \Carbon\Carbon::parse($rental->end_time)->format('d M, h:i A') }}
                                    </span>
                                </div>
                            @endif

                            <!-- Status Badge -->
                            <div class="mt-4">
                                <span class="text-gray-800 dark:text-white font-semibold">Estado:</span>
                                <flux:badge variant="{{ in_array($rental->status, ['selected', 'pending']) ? 'warning' : ($rental->status === 'completed' ? 'success' : 'info') }}">
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

                        <!-- Payment Info -->
                        <div class="flex-1">
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Detalles del Pago</h4>
                            @if($rental->payment)
                                <p class="text-gray-600 dark:text-gray-300">
                                    <span class="font-semibold">Monto Pagado:</span> ${{ number_format($rental->payment->amount, 2) }} DOP
                                </p>
                                <p class="text-gray-600 dark:text-gray-300">
                                    <span class="font-semibold">Método de Pago:</span> {{ match($rental->payment->payment_method) {
                                        'credit_card' => 'Tarjeta de Crédito',
                                        'debit_card' => 'Tarjeta de Débito',
                                        'cash' => 'Efectivo',
                                        default => ucfirst(str_replace('_', ' ', $rental->payment->payment_method))
                                    } }}
                                </p>
                                <p class="text-gray-600 dark:text-gray-300">
                                    <span class="font-semibold">Estado:</span> 
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
                                </p>
                            @else
                                <p class="text-red-500">Pago no encontrado.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 pt-4">
                        <div class="h-px w-full bg-zinc-200 dark:bg-zinc-700 mb-4"></div>
                        <div class="flex items-center justify-end gap-3">
                            @if($rental->payment)
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
                                    <span class="font-medium">Ver Detalles</span>
                                </button>
                                <livewire:rental-details :rental-id="$rental->id" :key="$rental->id" />
                            @endif

                            @if($rental->status === 'selected')
                                <flux:button 
                                    wire:click="deleteRental('{{ $rental->id }}')" 
                                    variant="danger"
                                    wire:confirm="¿Estás seguro de que deseas eliminar este alquiler?">
                                    Eliminar Alquiler
                                </flux:button>
                                <flux:button wire:click="continueBooking('{{ $rental->id }}')" variant="primary">
                                    Continuar Reserva
                                </flux:button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>