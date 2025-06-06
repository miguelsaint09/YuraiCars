@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .rentals-page {
        background: linear-gradient(135deg, 
            #0a0a0a 0%, 
            #1a1a1a 25%, 
            #0f0f0f 50%, 
            #1a1a1a 75%, 
            #0a0a0a 100%);
        min-height: 100vh;
        position: relative;
        overflow-x: hidden;
    }

    .rentals-page::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.05) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(168, 85, 247, 0.03) 0%, transparent 50%),
            radial-gradient(circle at 40% 40%, rgba(99, 102, 241, 0.02) 0%, transparent 50%);
        pointer-events: none;
    }

    .rentals-container {
        position: relative;
        z-index: 2;
        max-width: 1400px;
        margin: 0 auto;
        padding: 3rem 2rem;
        opacity: 0;
        animation: containerReveal 1.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }

    @keyframes containerReveal {
        0% {
            opacity: 0;
            transform: translateY(60px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .page-header {
        text-align: center;
        margin-bottom: 3rem;
        opacity: 0;
        animation: headerReveal 1.2s ease-out 0.3s forwards;
    }

    @keyframes headerReveal {
        0% {
            opacity: 0;
            transform: translateY(40px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .page-title {
        font-size: 3rem;
        font-weight: 900;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 25%, #ffffff 50%, #e2e8f0 75%, #ffffff 100%);
        background-size: 300% 300%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.05em;
        line-height: 1.1;
        margin-bottom: 1rem;
        animation: titleGradientShift 12s ease-in-out infinite;
    }

    @keyframes titleGradientShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .status-message {
        padding: 1.5rem 2rem;
        border-radius: 18px;
        font-weight: 600;
        text-align: center;
        margin-bottom: 3rem;
        backdrop-filter: blur(20px);
        border: 1px solid;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .status-success {
        background: linear-gradient(145deg, rgba(34, 197, 94, 0.1), rgba(16, 185, 129, 0.05));
        border-color: rgba(34, 197, 94, 0.3);
        color: #10b981;
    }

    .status-error {
        background: linear-gradient(145deg, rgba(239, 68, 68, 0.1), rgba(248, 113, 113, 0.05));
        border-color: rgba(239, 68, 68, 0.3);
        color: #ef4444;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        opacity: 0;
        animation: fadeInUp 1s ease-out 0.6s forwards;
    }

    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(40px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .empty-state-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 2rem;
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.1) 0%, 
            rgba(255, 255, 255, 0.05) 100%);
        border: 2px solid rgba(255, 255, 255, 0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
    }

    .empty-state-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 0.5rem;
    }

    .empty-state-text {
        color: #94a3b8;
        font-size: 1.1rem;
        font-weight: 500;
    }

    .rentals-grid {
        display: grid;
        gap: 2rem;
        opacity: 0;
        animation: gridReveal 1.2s ease-out 0.6s forwards;
    }

    @keyframes gridReveal {
        0% {
            opacity: 0;
            transform: translateY(60px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .rental-card {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.02) 0%, 
            rgba(255, 255, 255, 0.01) 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 28px;
        padding: 2.5rem;
        backdrop-filter: blur(20px);
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.3),
            0 0 0 1px rgba(255, 255, 255, 0.05),
            inset 0 1px 0 rgba(255, 255, 255, 0.08);
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
    }

    .rental-card:hover {
        transform: translateY(-8px);
        box-shadow: 
            0 30px 80px rgba(0, 0, 0, 0.4),
            0 0 0 1px rgba(255, 255, 255, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.15);
    }

    .rental-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(120, 119, 198, 0.6), 
            rgba(168, 85, 247, 0.4), 
            rgba(99, 102, 241, 0.6), 
            transparent);
        border-radius: 28px 28px 0 0;
    }

    .rental-header {
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: 2rem;
        align-items: center;
        margin-bottom: 2rem;
    }

    .vehicle-image {
        width: 120px;
        height: 80px;
        border-radius: 16px;
        object-fit: cover;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .vehicle-info {
        min-width: 0;
    }

    .vehicle-name {
        font-size: 1.5rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
    }

    .vehicle-category {
        color: #94a3b8;
        font-size: 1rem;
        font-weight: 500;
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

    .rental-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
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
    }

    .detail-value.price {
        font-size: 1.25rem;
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .rental-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
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

    .btn-danger {
        background: linear-gradient(145deg, 
            rgba(239, 68, 68, 0.8) 0%, 
            rgba(248, 113, 113, 0.7) 100%);
        border-color: rgba(239, 68, 68, 0.4);
        color: #ffffff;
        box-shadow: 
            0 10px 30px rgba(239, 68, 68, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    .btn-danger:hover {
        background: linear-gradient(145deg, 
            rgba(239, 68, 68, 0.9) 0%, 
            rgba(248, 113, 113, 0.8) 100%);
        transform: translateY(-3px);
        box-shadow: 
            0 15px 40px rgba(239, 68, 68, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }

    .btn-info {
        background: linear-gradient(145deg, 
            rgba(14, 165, 233, 0.8) 0%, 
            rgba(59, 130, 246, 0.7) 100%);
        border-color: rgba(14, 165, 233, 0.4);
        color: #ffffff;
        box-shadow: 
            0 10px 30px rgba(14, 165, 233, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    .btn-info:hover {
        background: linear-gradient(145deg, 
            rgba(14, 165, 233, 0.9) 0%, 
            rgba(59, 130, 246, 0.8) 100%);
        transform: translateY(-3px);
        box-shadow: 
            0 15px 40px rgba(14, 165, 233, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }

    @media (max-width: 768px) {
        .rentals-container {
            padding: 2rem 1rem;
        }
        
        .page-title {
            font-size: 2rem;
        }
        
        .rental-card {
            padding: 2rem;
        }
        
        .rental-header {
            grid-template-columns: 1fr;
            gap: 1rem;
            text-align: center;
        }
        
        .rental-details {
            grid-template-columns: 1fr;
        }
        
        .rental-actions {
            flex-direction: column;
            align-items: stretch;
        }
        
        .btn {
            justify-content: center;
        }
    }
</style>
@endpush

<div class="rentals-page">
    <div class="rentals-container">
        <div class="page-header">
            <h1 class="page-title">Mis Alquileres</h1>
        </div>

    @if (session('status'))
            <div class="status-message status-success">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
            <div class="status-message status-error">
            {{ session('error') }}
        </div>
    @endif

    @if($rentals->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="empty-state-title">Sin Alquileres</h3>
                <p class="empty-state-text">Aún no has alquilado ningún vehículo. ¡Explora nuestra flota y haz tu primera reserva!</p>
            </div>
    @else
            <div class="rentals-grid">
            @foreach($rentals as $rental)
                    <div class="rental-card">
                        <div class="rental-header">
                        @if($rental->vehicle->image_url && is_array($rental->vehicle->image_url) && !empty($rental->vehicle->image_url))
                                <img src="{{ Storage::url($rental->vehicle->image_url[0]) }}" class="vehicle-image" alt="{{ $rental->vehicle->name }}" />
                            @else
                                <div class="vehicle-image" style="background: linear-gradient(145deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05)); display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif

                            <div class="vehicle-info">
                                <h3 class="vehicle-name">{{ $rental->vehicle->name }} - {{ $rental->vehicle->year }}</h3>
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

                        <div class="rental-details">
                            @if($rental->pickup_location)
                                <div class="detail-item">
                                    <div class="detail-label">Lugar de Recogida</div>
                                    <div class="detail-value">{{ $rental->pickup_location }}</div>
                                </div>
                            @endif

                            @if($rental->dropoff_location)
                                <div class="detail-item">
                                    <div class="detail-label">Lugar de Devolución</div>
                                    <div class="detail-value">{{ $rental->dropoff_location }}</div>
                                </div>
                            @endif

                            @if($rental->start_time && $rental->end_time)
                                <div class="detail-item">
                                    <div class="detail-label">Período de Alquiler</div>
                                    <div class="detail-value">
                                        {{ \Carbon\Carbon::parse($rental->start_time)->format('d M, h:i A') }} 
                                        - 
                                        {{ \Carbon\Carbon::parse($rental->end_time)->format('d M, h:i A') }}
                                    </div>
                                </div>
                            @endif

                            @if($rental->payment)
                                <div class="detail-item">
                                    <div class="detail-label">Total Pagado</div>
                                    <div class="detail-value price">${{ number_format($rental->payment->amount, 2) }} DOP</div>
                                </div>

                                <div class="detail-item">
                                    <div class="detail-label">Método de Pago</div>
                                    <div class="detail-value">{{ match($rental->payment->payment_method) {
                                        'credit_card' => 'Tarjeta de Crédito',
                                        'debit_card' => 'Tarjeta de Débito',
                                        'cash' => 'Efectivo',
                                        'bank_transfer' => 'Transferencia Bancaria',
                                        default => ucfirst($rental->payment->payment_method)
                                    } }}</div>
                                </div>

                                <div class="detail-item">
                                    <div class="detail-label">Estado del Pago</div>
                                    <div class="detail-value">{{ match($rental->payment->status) {
                                        'success' => 'Exitoso',
                                            'pending' => 'Pendiente',
                                            'failed' => 'Fallido',
                                        'cancelled' => 'Cancelado',
                                            default => ucfirst($rental->payment->status)
                                    } }}</div>
                                </div>
                            @endif
                    </div>

                        <div class="rental-actions">
                            @if($rental->status === 'selected')
                                <button 
                                    wire:click="deleteRental('{{ $rental->id }}')" 
                                    class="btn btn-danger"
                                    wire:confirm="¿Estás seguro de que deseas eliminar este alquiler?">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Eliminar
                                </button>
                                <button wire:click="continueBooking('{{ $rental->id }}')" class="btn btn-primary">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                    Continuar Reserva
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('close-modal', function() {
        Livewire.dispatch('close-modal');
    });
</script>
@endpush