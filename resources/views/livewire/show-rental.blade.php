@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .booking-page {
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

    .booking-page::before {
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

    .booking-container {
        position: relative;
        z-index: 2;
        max-width: 1600px;
        margin: 0 auto;
        padding: 2rem;
        display: grid;
        grid-template-columns: 350px 1fr;
        gap: 3rem;
        min-height: 100vh;
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

    .sidebar {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.02) 0%, 
            rgba(255, 255, 255, 0.01) 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 32px;
        padding: 2.5rem;
        backdrop-filter: blur(20px);
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.3),
            0 0 0 1px rgba(255, 255, 255, 0.05),
            inset 0 1px 0 rgba(255, 255, 255, 0.08);
        position: sticky;
        top: 2rem;
        height: fit-content;
        opacity: 0;
        animation: slideInLeft 1.2s ease-out 0.3s forwards;
    }

    @keyframes slideInLeft {
        0% {
            opacity: 0;
            transform: translateX(-40px);
        }
        100% {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .sidebar-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 2rem;
        letter-spacing: -0.02em;
    }

    .steps-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .step-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        transition: all 0.4s ease;
    }

    .step-item:last-child {
        border-bottom: none;
    }

    .step-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.1) 0%, 
            rgba(255, 255, 255, 0.05) 100%);
        border: 1px solid rgba(255, 255, 255, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        transition: all 0.4s ease;
    }

    .step-icon.active {
        background: linear-gradient(145deg, 
            rgba(120, 119, 198, 0.8) 0%, 
            rgba(99, 102, 241, 0.7) 100%);
        border-color: rgba(120, 119, 198, 0.4);
        color: #ffffff;
        box-shadow: 0 8px 25px rgba(120, 119, 198, 0.3);
    }

    .step-text {
        color: #94a3b8;
        font-weight: 600;
        transition: all 0.4s ease;
    }

    .step-text.active {
        color: #ffffff;
        font-weight: 700;
    }

    .main-content {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.02) 0%, 
            rgba(255, 255, 255, 0.01) 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 32px;
        padding: 3rem;
        backdrop-filter: blur(20px);
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.3),
            0 0 0 1px rgba(255, 255, 255, 0.05),
            inset 0 1px 0 rgba(255, 255, 255, 0.08);
        opacity: 0;
        animation: slideInRight 1.2s ease-out 0.5s forwards;
    }

    @keyframes slideInRight {
        0% {
            opacity: 0;
            transform: translateX(40px);
        }
        100% {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 900;
        color: #ffffff;
        margin-bottom: 2rem;
        letter-spacing: -0.03em;
    }

    .vehicle-showcase {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        align-items: start;
        margin-bottom: 3rem;
    }

    .vehicle-image {
        width: 100%;
        height: 300px;
        border-radius: 24px;
        object-fit: cover;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    }

    .vehicle-info {
        padding-left: 1rem;
    }

    .vehicle-name {
        font-size: 2rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 0.75rem;
        letter-spacing: -0.02em;
    }

    .vehicle-details {
        color: #94a3b8;
        font-size: 1.25rem;
        font-weight: 500;
        margin-bottom: 1.5rem;
    }

    .price-info {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.03) 0%, 
            rgba(255, 255, 255, 0.01) 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .price-label {
        color: #94a3b8;
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .price-value {
        font-size: 1.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .total-price-box {
        background: linear-gradient(145deg, 
            rgba(120, 119, 198, 0.1) 0%, 
            rgba(99, 102, 241, 0.05) 100%);
        border: 1px solid rgba(120, 119, 198, 0.3);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        text-align: center;
    }

    .total-label {
        color: #ffffff;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .total-amount {
        font-size: 2.5rem;
        font-weight: 900;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
    }

    .total-duration {
        color: #94a3b8;
        font-size: 1rem;
        font-weight: 500;
    }

    .features-section {
        margin-bottom: 3rem;
    }

    .features-title {
        color: #ffffff;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .features-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .feature-tag {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.1) 0%, 
            rgba(255, 255, 255, 0.05) 100%);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #ffffff;
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .form-section {
        margin-bottom: 3rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    .form-group {
        margin-bottom: 2rem;
    }

    .form-label {
        display: block;
        color: #e2e8f0;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        letter-spacing: 0.025em;
        text-transform: uppercase;
    }

    .form-input {
        width: 100%;
        padding: 1.2rem 1.5rem;
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.03) 0%, 
            rgba(255, 255, 255, 0.01) 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        color: #ffffff;
        font-size: 1rem;
        font-weight: 500;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        backdrop-filter: blur(15px);
        outline: none;
    }

    .form-input:focus {
        border-color: rgba(120, 119, 198, 0.5);
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.05) 0%, 
            rgba(255, 255, 255, 0.02) 100%);
        box-shadow: 
            0 0 0 3px rgba(120, 119, 198, 0.15),
            0 8px 25px rgba(0, 0, 0, 0.2);
        transform: translateY(-2px);
    }

    .form-input:disabled {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.01) 0%, 
            rgba(255, 255, 255, 0.005) 100%);
        border-color: rgba(255, 255, 255, 0.05);
        color: #64748b;
        cursor: not-allowed;
    }

    .form-input::placeholder {
        color: #64748b;
        font-weight: 400;
    }

    .payment-section {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.02) 0%, 
            rgba(255, 255, 255, 0.01) 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        padding: 2.5rem;
        margin-bottom: 3rem;
    }

    .payment-title {
        color: #ffffff;
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
    }

    .payment-subtitle {
        color: #94a3b8;
        font-size: 1rem;
        margin-bottom: 2rem;
    }

    .navigation-buttons {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 2rem;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    .btn {
        padding: 1rem 2.5rem;
        border-radius: 16px;
        font-weight: 700;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid;
        backdrop-filter: blur(15px);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
    }

    .btn-primary {
        background: linear-gradient(145deg, 
            rgba(120, 119, 198, 0.8) 0%, 
            rgba(99, 102, 241, 0.7) 100%);
        border-color: rgba(120, 119, 198, 0.4);
        color: #ffffff;
        box-shadow: 
            0 12px 35px rgba(120, 119, 198, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    .btn-primary:hover {
        background: linear-gradient(145deg, 
            rgba(120, 119, 198, 0.9) 0%, 
            rgba(99, 102, 241, 0.8) 100%);
        transform: translateY(-3px);
        box-shadow: 
            0 18px 50px rgba(120, 119, 198, 0.4),
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

    @media (max-width: 1024px) {
        .booking-container {
            grid-template-columns: 1fr;
            gap: 2rem;
            padding: 1.5rem;
        }
        
        .sidebar {
            position: static;
            order: 2;
        }
        
        .main-content {
            order: 1;
        }
        
        .vehicle-showcase {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }
        
        .vehicle-name {
            font-size: 1.5rem;
        }
        
        .total-amount {
            font-size: 2rem;
        }
        
        .navigation-buttons {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }
        
        .btn {
            justify-content: center;
        }
    }
</style>
@endpush

<div class="booking-page">
    <div class="booking-container">
    <!-- Left Sidebar -->
        <div class="sidebar">
            <h2 class="sidebar-title">Pasos de la Reserva</h2>
            <ul class="steps-list">
                <li class="step-item">
                    <div class="step-icon {{ $step === 1 ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="step-text {{ $step === 1 ? 'active' : '' }}">Detalles de la Reserva</span>
            </li>
                <li class="step-item">
                    <div class="step-icon {{ $step === 2 ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <span class="step-text {{ $step === 2 ? 'active' : '' }}">Pago</span>
            </li>
        </ul>
    </div>

    <!-- Right Content -->
        <div class="main-content">
        <form wire:submit.prevent="completeBooking" method="POST">
            @csrf
            @if ($step === 1)
                <!-- Step 1: Booking Details -->
                <div>
                        <h1 class="page-title">Confirmar tu Reserva</h1>

                        <div class="vehicle-showcase">
                            <!-- Vehicle Image -->
                            @if($vehicle->image_url && is_array($vehicle->image_url) && !empty($vehicle->image_url))
                                <img src="{{ Storage::url($vehicle->image_url[0]) }}" class="vehicle-image" alt="{{ $vehicle->name }}" />
                            @else
                                <div class="vehicle-image" style="background: linear-gradient(145deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05)); display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif

                            <!-- Vehicle Details -->
                            <div class="vehicle-info">
                                <h3 class="vehicle-name">{{ $vehicle->name }} - {{ $vehicle->year }}</h3>
                                <p class="vehicle-details">{{ $vehicle->category }} | {{ ucfirst($vehicle->transmission) }}</p>

                                <div class="price-info">
                                    <div class="price-label">Precio de Alquiler</div>
                                    <div class="price-value">${{ number_format($vehicle->price_per_day, 2) }} DOP/día</div>
                                </div>

                                <!-- Total Price Box -->
                                <div class="total-price-box">
                                    <div class="total-label">Precio Total</div>
                                    <div class="total-amount">
                                            ${{ number_format($totalPrice, 2) }} DOP
                                    </div>
                                    <div class="total-duration">Por {{ $totalDays }} {{ Str::plural('día', $totalDays) }}</div>
                                </div>

                                <!-- Features -->
                                <div class="features-section">
                                    <h4 class="features-title">Características</h4>
                                    <div class="features-grid">
                                        @foreach ($vehicle->features as $feature)
                                            <span class="feature-tag">{{ $feature }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rental Details Form -->
                        <div class="form-section">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Lugar de Recogida</label>
                                    <input 
                                        type="text"
                                        wire:model.live="pickupLocation" 
                                        class="form-input" 
                                        placeholder="Ingrese dirección en República Dominicana" 
                                        required 
                                    />
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Lugar de Devolución</label>
                                    <input 
                                        type="text"
                                        wire:model.live="dropoffLocation" 
                                        class="form-input" 
                                        value="YuraiCars" 
                                        readonly 
                                        disabled 
                                    />
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Fecha de Inicio</label>
                                    <input 
                                        type="datetime-local"
                                        wire:model.live="startTime" 
                                        class="form-input" 
                                        required 
                                    />
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Fecha de Fin</label>
                                    <input 
                                        type="datetime-local"
                                        wire:model.live="endTime" 
                                        class="form-input" 
                                        required 
                                    />
                                </div>
                            </div>
                        </div>
                        
                        <!-- Navigation Buttons -->
                        <div class="navigation-buttons">
                            <div></div>
                            <button wire:click="nextStep" class="btn btn-primary" type="button">
                                <span>Proceder al Pago</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </button>
                    </div>
                </div>
            @elseif ($step === 2)
                <!-- Step 2: Payment -->
                <div>
                    <livewire:payment-form :rentalId="$onGoingRental->id" :amount="$totalPrice" />
                </div>
            @endif
        </form>
        </div>
    </div>
</div>
