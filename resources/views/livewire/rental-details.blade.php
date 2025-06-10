@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

    .rental-details-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(10px);
        z-index: 50;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .rental-details-modal.show {
        opacity: 1;
        visibility: visible;
    }

    .modal-content {
        background: linear-gradient(145deg, 
            rgba(10, 10, 10, 0.95) 0%, 
            rgba(26, 26, 26, 0.9) 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 32px;
        max-width: 1000px;
        width: 100%;
        max-height: 90vh;
        overflow: hidden;
        box-shadow: 
            0 25px 80px rgba(0, 0, 0, 0.5),
            0 0 0 1px rgba(255, 255, 255, 0.05),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
        transform: scale(0.8) translateY(60px);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        backdrop-filter: blur(20px);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .rental-details-modal.show .modal-content {
        transform: scale(1) translateY(0);
    }

    .modal-header {
        padding: 2.5rem 3rem 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-title {
        font-size: 2rem;
        font-weight: 900;
        color: #ffffff;
        letter-spacing: -0.03em;
    }

    .close-button {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.1) 0%, 
            rgba(255, 255, 255, 0.05) 100%);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #ffffff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .close-button:hover {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.15) 0%, 
            rgba(255, 255, 255, 0.08) 100%);
        transform: scale(1.1);
    }

    .modal-body {
        padding: 2rem 3rem;
        overflow-y: auto;
        max-height: calc(90vh - 200px);
    }

    .details-section {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.02) 0%, 
            rgba(255, 255, 255, 0.01) 100%);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 24px;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 1.5rem;
        letter-spacing: -0.02em;
    }

    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .detail-item {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.03) 0%, 
            rgba(255, 255, 255, 0.01) 100%);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 16px;
        padding: 1.25rem;
    }

    .detail-label {
        color: #94a3b8;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }

    .detail-value {
        color: #ffffff;
        font-size: 1rem;
        font-weight: 600;
        line-height: 1.4;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 16px;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border: 1px solid;
        backdrop-filter: blur(15px);
    }

    .badge-selected,
    .badge-pending {
        background: linear-gradient(145deg, rgba(245, 158, 11, 0.15), rgba(251, 191, 36, 0.1));
        border-color: rgba(245, 158, 11, 0.4);
        color: #f59e0b;
    }

    .badge-confirmed,
    .badge-approved,
    .badge-active {
        background: linear-gradient(145deg, rgba(59, 130, 246, 0.15), rgba(96, 165, 250, 0.1));
        border-color: rgba(59, 130, 246, 0.4);
        color: #3b82f6;
    }

    .badge-completed {
        background: linear-gradient(145deg, rgba(34, 197, 94, 0.15), rgba(16, 185, 129, 0.1));
        border-color: rgba(34, 197, 94, 0.4);
        color: #22c55e;
    }

    .badge-cancelled,
    .badge-rejected {
        background: linear-gradient(145deg, rgba(239, 68, 68, 0.15), rgba(248, 113, 113, 0.1));
        border-color: rgba(239, 68, 68, 0.4);
        color: #ef4444;
    }

    .features-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .feature-tag {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.1) 0%, 
            rgba(255, 255, 255, 0.05) 100%);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #ffffff;
        padding: 0.5rem 1rem;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .rental-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1.5rem;
    }

    .rental-table th,
    .rental-table td {
        padding: 1rem 1.5rem;
        text-align: left;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    }

    .rental-table th {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.05) 0%, 
            rgba(255, 255, 255, 0.02) 100%);
        color: #94a3b8;
        font-weight: 700;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .rental-table td {
        color: #ffffff;
        font-weight: 500;
    }

    .modal-footer {
        padding: 2rem 3rem;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }

    .btn {
        padding: 0.9rem 2rem;
        border-radius: 14px;
        font-weight: 700;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid;
        backdrop-filter: blur(15px);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(145deg, 
            rgba(120, 119, 198, 0.8) 0%, 
            rgba(99, 102, 241, 0.7) 100%);
        border-color: rgba(120, 119, 198, 0.4);
        color: #ffffff;
        box-shadow: 
            0 10px 30px rgba(120, 119, 198, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    .btn-primary:hover {
        background: linear-gradient(145deg, 
            rgba(120, 119, 198, 0.9) 0%, 
            rgba(99, 102, 241, 0.8) 100%);
        transform: translateY(-3px);
        box-shadow: 
            0 15px 40px rgba(120, 119, 198, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }

    .btn-ghost {
        background: transparent;
        border-color: rgba(255, 255, 255, 0.2);
        color: #e2e8f0;
    }

    .btn-ghost:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .rental-details-modal {
            padding: 1rem;
        }
        
        .modal-content {
            max-height: 95vh;
        }
        
        .modal-header,
        .modal-body,
        .modal-footer {
            padding-left: 2rem;
            padding-right: 2rem;
        }
        
        .modal-title {
            font-size: 1.5rem;
        }
        
        .details-grid {
            grid-template-columns: 1fr;
        }
        
        .rental-table {
            font-size: 0.85rem;
        }
        
        .rental-table th,
        .rental-table td {
            padding: 0.75rem 1rem;
        }
        
        .modal-footer {
            flex-direction: column;
            align-items: stretch;
        }
        
        .btn {
            justify-content: center;
        }
    }
</style>
@endpush

<div class="rental-details-modal {{ $showModal ? 'show' : '' }}" wire:click.self="toggleModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Detalles del Alquiler</h2>
            <button wire:click="toggleModal" class="close-button">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                </button>
                </div>

        <div class="modal-body">
                    <!-- Customer Information -->
            <div class="details-section">
                <h3 class="section-title">Información del Cliente</h3>
                <div class="details-grid">
                    <div class="detail-item">
                        <div class="detail-label">Nombre Completo</div>
                        <div class="detail-value">{{ $rental->user->profile->first_name }} {{ $rental->user->profile->last_name }}</div>
                            </div>
                    <div class="detail-item">
                        <div class="detail-label">Correo Electrónico</div>
                        <div class="detail-value">{{ $rental->user->email }}</div>
                            </div>
                            @if($rental->user->profile)
                    <div class="detail-item">
                        <div class="detail-label">Teléfono</div>
                        <div class="detail-value">{{ $rental->user->profile->phone ?? 'No proporcionado' }}</div>
                            </div>
                    <div class="detail-item">
                        <div class="detail-label">Dirección</div>
                        <div class="detail-value">{{ $rental->user->profile->address ?? 'No proporcionada' }}</div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Vehicle Information -->
            <div class="details-section">
                <h3 class="section-title">Información del Vehículo</h3>
                <div class="details-grid">
                    <div class="detail-item">
                        <div class="detail-label">Vehículo</div>
                        <div class="detail-value">{{ $rental->vehicle->name }} - {{ $rental->vehicle->year }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Categoría</div>
                        <div class="detail-value">{{ $rental->vehicle->category }}</div>
                            </div>
                    <div class="detail-item">
                        <div class="detail-label">Transmisión</div>
                        <div class="detail-value">{{ ucfirst($rental->vehicle->transmission) }}</div>
                            </div>
                    <div class="detail-item">
                        <div class="detail-label">Tarifa Diaria</div>
                        <div class="detail-value">${{ number_format($rental->vehicle->price_per_day, 2) }}</div>
                            </div>
                    <div class="detail-item">
                        <div class="detail-label">Asientos</div>
                        <div class="detail-value">{{ $rental->vehicle->seats }}</div>
                            </div>
                    <div class="detail-item">
                        <div class="detail-label">Tipo de Combustible</div>
                        <div class="detail-value">{{ ucfirst($rental->vehicle->fuel_type) }}</div>
                            </div>
                            </div>
                            @if($rental->vehicle->features)
                    <div class="detail-item" style="grid-column: 1 / -1; margin-top: 1rem;">
                        <div class="detail-label">Características</div>
                        <div class="features-list">
                                    @foreach($rental->vehicle->features as $feature)
                                <span class="feature-tag">{{ $feature }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

            <!-- Rental Information -->
            <div class="details-section">
                <h3 class="section-title">Información del Alquiler</h3>
                <div class="details-grid">
                    <div class="detail-item">
                        <div class="detail-label">Lugar de Recogida</div>
                        <div class="detail-value">{{ $rental->pickup_location }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Lugar de Devolución</div>
                        <div class="detail-value">{{ $rental->dropoff_location }}</div>
                            </div>
                    <div class="detail-item">
                        <div class="detail-label">Fecha de Inicio</div>
                        <div class="detail-value">{{ \Carbon\Carbon::parse($rental->start_time)->format('d M, Y h:i A') }}</div>
                            </div>
                    <div class="detail-item">
                        <div class="detail-label">Fecha de Fin</div>
                        <div class="detail-value">{{ \Carbon\Carbon::parse($rental->end_time)->format('d M, Y h:i A') }}</div>
                            </div>
                    <div class="detail-item">
                        <div class="detail-label">Total de Días</div>
                        <div class="detail-value">{{ \Carbon\Carbon::parse($rental->start_time)->diffInDays(\Carbon\Carbon::parse($rental->end_time)) }}</div>
                            </div>
                    <div class="detail-item">
                        <div class="detail-label">Estado</div>
                        <div class="detail-value">
                            <div class="badge badge-{{ $rental->status }}">
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
                            </div>
                        </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
            @if($rental->payment)
            <div class="details-section">
                <h3 class="section-title">Información del Pago</h3>
                <div class="details-grid">
                    <div class="detail-item">
                        <div class="detail-label">Monto Total</div>
                        <div class="detail-value">${{ number_format($rental->payment->amount, 2) }} DOP</div>
                            </div>
                    <div class="detail-item">
                        <div class="detail-label">Método de Pago</div>
                        <div class="detail-value">{{ match($rental->payment->payment_method) {
                                    'credit_card' => 'Tarjeta de Crédito',
                                    'debit_card' => 'Tarjeta de Débito',
                                    'cash' => 'Efectivo',
                            'bank_transfer' => 'Transferencia Bancaria',
                                    default => ucfirst(str_replace('_', ' ', $rental->payment->payment_method))
                        } }}</div>
                            </div>
                    <div class="detail-item">
                        <div class="detail-label">Estado del Pago</div>
                        <div class="detail-value">
                            <div class="badge badge-{{ $rental->payment->status === 'success' ? 'completed' : 'pending' }}">
                                    {{ match($rental->payment->status) {
                                    'success' => 'Exitoso',
                                        'pending' => 'Pendiente',
                                        'failed' => 'Fallido',
                                    'cancelled' => 'Cancelado',
                                        'refunded' => 'Reembolsado',
                                        default => ucfirst($rental->payment->status)
                                    } }}
                            </div>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Fecha de Pago</div>
                        <div class="detail-value">{{ $rental->payment->created_at->format('d M, Y h:i A') }}</div>
                    </div>
                </div>

                <table class="rental-table">
                    <thead>
                        <tr>
                            <th>Descripción</th>
                            <th>Días</th>
                            <th>Tarifa Diaria</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                {{ $rental->vehicle->name }} - {{ $rental->vehicle->year }}<br>
                                <small style="color: #94a3b8;">{{ $rental->vehicle->category }} | {{ ucfirst($rental->vehicle->transmission) }}</small>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($rental->start_time)->diffInDays(\Carbon\Carbon::parse($rental->end_time)) }}</td>
                            <td>${{ number_format($rental->vehicle->price_per_day, 2) }} DOP</td>
                            <td>${{ number_format($rental->payment->amount, 2) }} DOP</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        <div class="modal-footer">
            <button wire:click="downloadInvoice" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Descargar Factura
            </button>
            <button wire:click="toggleModal" class="btn btn-ghost">Cerrar</button>
        </div>
    </div>
</div>