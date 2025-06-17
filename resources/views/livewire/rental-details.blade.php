@push('styles')
<style>
    .rental-details-page {
        background: linear-gradient(135deg, 
            #0a0a0a 0%, 
            #1a1a1a 25%, 
            #0f0f0f 50%, 
            #1a1a1a 75%, 
            #0a0a0a 100%);
        min-height: 100vh;
        padding: 2rem;
    }

    .rental-details-container {
        max-width: 1200px;
        margin: 0 auto;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 24px;
        padding: 2rem;
        backdrop-filter: blur(20px);
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.3),
            0 0 0 1px rgba(255, 255, 255, 0.05);
    }

    .rental-header {
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: 2rem;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .vehicle-image {
        width: 200px;
        height: 140px;
        border-radius: 16px;
        object-fit: cover;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .vehicle-info {
        min-width: 0;
    }

    .vehicle-name {
        font-size: 2rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
    }

    .vehicle-category {
        color: #94a3b8;
        font-size: 1.1rem;
        font-weight: 500;
        margin-bottom: 1rem;
    }

    .rental-status {
        display: flex;
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

    .status-selected,
    .status-pending {
        background: linear-gradient(145deg, rgba(245, 158, 11, 0.15), rgba(251, 191, 36, 0.1));
        border-color: rgba(245, 158, 11, 0.4);
        color: #f59e0b;
    }

    .status-confirmed,
    .status-approved,
    .status-active {
        background: linear-gradient(145deg, rgba(59, 130, 246, 0.15), rgba(96, 165, 250, 0.1));
        border-color: rgba(59, 130, 246, 0.4);
        color: #3b82f6;
    }

    .status-completed {
        background: linear-gradient(145deg, rgba(34, 197, 94, 0.15), rgba(16, 185, 129, 0.1));
        border-color: rgba(34, 197, 94, 0.4);
        color: #22c55e;
    }

    .status-cancelled,
    .status-rejected {
        background: linear-gradient(145deg, rgba(239, 68, 68, 0.15), rgba(248, 113, 113, 0.1));
        border-color: rgba(239, 68, 68, 0.4);
        color: #ef4444;
    }

    .rental-sections {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .rental-section {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 16px;
        padding: 1.5rem;
    }

    .section-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title svg {
        width: 1.5rem;
        height: 1.5rem;
        opacity: 0.7;
    }

    .detail-item {
        margin-bottom: 1.25rem;
    }

    .detail-label {
        color: #94a3b8;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .detail-value {
        color: #ffffff;
        font-size: 1.1rem;
        font-weight: 500;
    }

    .price-value {
        font-size: 1.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .rental-actions {
        margin-top: 2rem;
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .btn svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    .btn-primary {
        background: linear-gradient(145deg, 
            rgba(99, 102, 241, 0.9) 0%, 
            rgba(79, 70, 229, 0.9) 100%);
        border-color: rgba(99, 102, 241, 0.4);
        color: #ffffff;
        box-shadow: 
            0 10px 30px rgba(99, 102, 241, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 
            0 15px 40px rgba(99, 102, 241, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }

    .btn-primary:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .alert {
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        font-weight: 500;
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: #ef4444;
    }

    @media (max-width: 768px) {
        .rental-header {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .vehicle-image {
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
        }

        .rental-status {
            justify-content: center;
            margin: 0 auto;
            width: fit-content;
        }
    }
</style>
@endpush

<div class="rental-details-page">
    <div class="rental-details-container">
        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <div class="rental-header">
            @if($rental->vehicle->image_url && is_array($rental->vehicle->image_url) && !empty($rental->vehicle->image_url))
                <img src="{{ Storage::url($rental->vehicle->image_url[0]) }}" class="vehicle-image" alt="{{ $rental->vehicle->name }}" />
            @else
                <div class="vehicle-image" style="background: linear-gradient(145deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05)); display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            @endif

            <div class="vehicle-info">
                <h1 class="vehicle-name">{{ $rental->vehicle->name }} - {{ $rental->vehicle->year }}</h1>
                <p class="vehicle-category">{{ $rental->vehicle->category }} | {{ ucfirst($rental->vehicle->transmission) }}</p>
            </div>

            <div class="rental-status status-{{ $rental->status }}">
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

        <div class="rental-sections">
            <!-- Rental Information -->
            <div class="rental-section">
                <h2 class="section-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Información del Alquiler
                </h2>

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
                    <div class="detail-label">Duración</div>
                    <div class="detail-value">
                        {{ round(\Carbon\Carbon::parse($rental->start_time)->floatDiffInDays(\Carbon\Carbon::parse($rental->end_time))) }} días
                    </div>
                </div>
            </div>

            <!-- Financial Summary -->
            <div class="rental-section">
                <h2 class="section-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                    Resumen Financiero
                </h2>

                <div class="detail-item">
                    <div class="detail-label">Monto Total del Alquiler</div>
                    <div class="detail-value price-value">{{ $rental->formatAmount($rental->total_amount) }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Total Pagado</div>
                    <div class="detail-value" style="color: {{ $rental->paid_amount > 0 ? '#10b981' : '#6b7280' }};">{{ $rental->formatAmount($rental->paid_amount) }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Monto Pendiente</div>
                    <div class="detail-value" style="color: {{ $rental->pending_amount > 0 ? '#f59e0b' : '#10b981' }};">{{ $rental->formatAmount($rental->pending_amount) }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Estado General de Pagos</div>
                    <div class="detail-value">
                        <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 500; 
                                     background: {{ match($rental->payment_status) {
                                         'Completamente pagado' => 'rgba(16, 185, 129, 0.1); color: #10b981',
                                         'Parcialmente pagado' => 'rgba(245, 158, 11, 0.1); color: #f59e0b',
                                         'Sin pagos' => 'rgba(239, 68, 68, 0.1); color: #ef4444',
                                         default => 'rgba(107, 114, 128, 0.1); color: #6b7280'
                                     } }};">
                            {{ $rental->payment_status }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Payment History -->
            @if($rental->payments->count() > 0)
            <div class="rental-section">
                <h2 class="section-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    Historial de Pagos
                </h2>

                @foreach($rental->payments->sortBy('created_at') as $payment)
                <div class="payment-item" style="background: rgba(255, 255, 255, 0.02); padding: 1.5rem; border-radius: 16px; margin-bottom: 1rem; border: 1px solid rgba(255, 255, 255, 0.05);">
                    <div style="display: grid; grid-template-columns: 1fr auto; gap: 1rem; align-items: start;">
                        <div>
                            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                                <h3 style="color: #ffffff; font-weight: 600; margin: 0;">{{ $payment->formatted_description }}</h3>
                                <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em;
                                             background: {{ match($payment->status) {
                                                 'success' => 'rgba(16, 185, 129, 0.1); color: #10b981',
                                                 'pending' => 'rgba(245, 158, 11, 0.1); color: #f59e0b',
                                                 'failed' => 'rgba(239, 68, 68, 0.1); color: #ef4444',
                                                 default => 'rgba(107, 114, 128, 0.1); color: #6b7280'
                                             } }};">
                                    {{ $payment->formatted_status }}
                                </span>
                            </div>
                            
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; color: #94a3b8; font-size: 0.875rem;">
                                <div>
                                    <strong>Monto:</strong> {{ $payment->formatted_amount }}
                                </div>
                                <div>
                                    <strong>Método:</strong> {{ $payment->formatted_payment_method }}
                                </div>
                                @if($payment->additional_days)
                                <div>
                                    <strong>Días Adicionales:</strong> {{ $payment->additional_days }}
                                </div>
                                @endif
                                <div>
                                    <strong>Fecha:</strong> {{ $payment->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        </div>
                        
                        @if($payment->status === 'success')
                        <div style="display: flex; justify-content: flex-end; width: 100%;">
                            <button wire:click="downloadPaymentInvoice('{{ $payment->id }}')" 
                                    class="download-invoice-btn"
                                    style="background: linear-gradient(145deg, rgba(99, 102, 241, 0.15), rgba(79, 70, 229, 0.1)); 
                                           color: #6366f1; 
                                           border: 1px solid rgba(99, 102, 241, 0.3); 
                                           padding: 0.5rem 0.75rem; 
                                           border-radius: 8px; 
                                           font-size: 0.8rem; 
                                           font-weight: 600; 
                                           cursor: pointer; 
                                           transition: all 0.3s ease;
                                           display: flex;
                                           align-items: center;
                                           gap: 0.4rem;
                                           box-shadow: 0 2px 8px rgba(99, 102, 241, 0.15);
                                           backdrop-filter: blur(8px);
                                           white-space: nowrap;
                                           min-width: fit-content;
                                           max-width: 140px;"
                                    onmouseover="this.style.background='linear-gradient(145deg, rgba(99, 102, 241, 0.25), rgba(79, 70, 229, 0.2))'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(99, 102, 241, 0.25)'"
                                    onmouseout="this.style.background='linear-gradient(145deg, rgba(99, 102, 241, 0.15), rgba(79, 70, 229, 0.1))'; this.style.transform='translateY(0px)'; this.style.boxShadow='0 2px 8px rgba(99, 102, 241, 0.15)'"
                                    wire:loading.attr="disabled"
                                    wire:target="downloadPaymentInvoice">
                                <svg style="width: 0.9rem; height: 0.9rem; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span wire:loading.remove wire:target="downloadPaymentInvoice" style="overflow: hidden; text-overflow: ellipsis;">Descargar</span>
                                <span wire:loading wire:target="downloadPaymentInvoice" style="overflow: hidden; text-overflow: ellipsis;">Generando...</span>
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Vehicle Features -->
            <div class="rental-section">
                <h2 class="section-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                    Características del Vehículo
                </h2>

                <div class="features-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 1rem;">
                    @foreach ($rental->vehicle->features as $feature)
                        <div class="feature-item" style="background: rgba(255, 255, 255, 0.05); padding: 0.75rem; border-radius: 12px; text-align: center; color: #ffffff; font-size: 0.9rem; font-weight: 500;">
                            {{ $feature }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="rental-actions">
            @if($rental->payments()->where('status', 'success')->count() > 0)
                <button wire:click="downloadCompleteInvoice" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Descargar Factura Completa
                </button>
            @endif
        </div>
    </div>
</div> 