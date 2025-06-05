@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

    .vehicle-card-modern {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.08) 0%, 
            rgba(255, 255, 255, 0.04) 50%, 
            rgba(255, 255, 255, 0.02) 100%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 24px;
        overflow: hidden;
        transform-style: preserve-3d;
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        backdrop-filter: blur(20px);
        box-shadow: 
            0 10px 40px rgba(0, 0, 0, 0.4),
            0 0 0 1px rgba(255, 255, 255, 0.06),
            inset 0 1px 0 rgba(255, 255, 255, 0.15),
            inset 0 -1px 0 rgba(0, 0, 0, 0.1);
    }

    .vehicle-card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(168, 85, 247, 0.6), 
            rgba(120, 119, 198, 0.4), 
            rgba(99, 102, 241, 0.6), 
            transparent);
        filter: blur(1px);
        z-index: 1;
    }

    .vehicle-card-modern::after {
        content: '';
        position: absolute;
        top: -100%;
        left: -100%;
        width: 300%;
        height: 300%;
        background: conic-gradient(from 0deg, 
            transparent 0deg, 
            rgba(168, 85, 247, 0.05) 90deg, 
            transparent 180deg,
            rgba(120, 119, 198, 0.05) 270deg,
            transparent 360deg);
        animation: cardRotate 20s linear infinite;
        z-index: -1;
        opacity: 0;
        transition: opacity 0.6s ease;
    }

    @keyframes cardRotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .vehicle-card-modern:hover {
        transform: translateY(-12px) rotateY(3deg) rotateX(3deg);
        border-color: rgba(255, 255, 255, 0.2);
        box-shadow: 
            0 25px 60px rgba(0, 0, 0, 0.5),
            0 0 0 1px rgba(255, 255, 255, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.2),
            inset 0 -1px 0 rgba(0, 0, 0, 0.1),
            0 0 80px rgba(168, 85, 247, 0.2);
    }

    .vehicle-card-modern:hover::after {
        opacity: 1;
    }

    .vehicle-image-container {
        position: relative;
        height: 240px;
        overflow: hidden;
        background: linear-gradient(135deg, 
            rgba(255, 255, 255, 0.03) 0%, 
            rgba(255, 255, 255, 0.01) 50%, 
            rgba(255, 255, 255, 0.02) 100%);
    }

    .vehicle-image-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 50% 50%, 
            rgba(168, 85, 247, 0.08) 0%, 
            transparent 60%);
        z-index: 1;
        opacity: 0;
        transition: opacity 0.6s ease;
    }

    .vehicle-card-modern:hover .vehicle-image-container::before {
        opacity: 1;
    }

    .vehicle-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        filter: drop-shadow(0 8px 25px rgba(0, 0, 0, 0.4));
        position: relative;
        z-index: 2;
    }

    .vehicle-card-modern:hover .vehicle-image {
        transform: scale(1.08) translateZ(20px);
        filter: drop-shadow(0 15px 40px rgba(0, 0, 0, 0.6)) 
                drop-shadow(0 0 30px rgba(168, 85, 247, 0.3));
    }

    .info-button {
        position: absolute;
        top: 20px;
        right: 20px;
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.15) 0%, 
            rgba(255, 255, 255, 0.08) 100%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        backdrop-filter: blur(15px);
        z-index: 3;
        box-shadow: 
            0 6px 20px rgba(0, 0, 0, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    .info-button:hover {
        background: linear-gradient(145deg, 
            rgba(168, 85, 247, 0.8) 0%, 
            rgba(120, 119, 198, 0.6) 100%);
        transform: scale(1.15) translateZ(10px);
        border-color: rgba(255, 255, 255, 0.4);
        box-shadow: 
            0 10px 30px rgba(0, 0, 0, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.3),
            0 0 20px rgba(168, 85, 247, 0.6);
    }

    .vehicle-name {
        font-size: 1.4rem;
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff 0%, #f3f4f6 30%, #ffffff 70%, #e5e7eb 100%);
        background-size: 200% 200%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-align: center;
        margin-bottom: 1.5rem;
        letter-spacing: -0.03em;
        line-height: 1.2;
        animation: nameShimmer 8s ease-in-out infinite;
        position: relative;
    }

    @keyframes nameShimmer {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .specs-container {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin: 2rem 0;
    }

    .spec-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.06) 0%, 
            rgba(255, 255, 255, 0.03) 100%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 14px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        font-size: 0.9rem;
        font-weight: 600;
        color: #e5e7eb;
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
    }

    .spec-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(168, 85, 247, 0.1), 
            transparent);
        transition: left 0.6s ease;
    }

    .spec-item:hover::before {
        left: 100%;
    }

    .spec-item:hover {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.1) 0%, 
            rgba(255, 255, 255, 0.05) 100%);
        border-color: rgba(168, 85, 247, 0.4);
        transform: translateY(-3px) scale(1.02);
        box-shadow: 
            0 8px 25px rgba(0, 0, 0, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.15);
    }

    .spec-icon {
        color: rgba(168, 85, 247, 0.8);
        width: 20px;
        height: 20px;
        flex-shrink: 0;
        filter: drop-shadow(0 0 8px rgba(168, 85, 247, 0.4));
    }

    .price-section {
        border-top: 1px solid rgba(255, 255, 255, 0.15);
        padding-top: 2rem;
        margin-top: 2rem;
        text-align: center;
        position: relative;
    }

    .price-section::before {
        content: '';
        position: absolute;
        top: -1px;
        left: 25%;
        right: 25%;
        height: 2px;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(168, 85, 247, 0.6), 
            rgba(120, 119, 198, 0.4), 
            rgba(99, 102, 241, 0.6), 
            transparent);
        filter: blur(1px);
    }

    .price-display {
        font-size: 2.2rem;
        font-weight: 900;
        background: linear-gradient(135deg, #ffffff 0%, #f3f4f6 50%, #ffffff 100%);
        background-size: 200% 200%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        letter-spacing: -0.03em;
        line-height: 1.1;
        animation: priceGlow 6s ease-in-out infinite;
        text-shadow: 0 0 30px rgba(255, 255, 255, 0.2);
    }

    @keyframes priceGlow {
        0%, 100% { 
            background-position: 0% 50%; 
            filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.3));
        }
        50% { 
            background-position: 100% 50%; 
            filter: drop-shadow(0 0 20px rgba(168, 85, 247, 0.4));
        }
    }

    .currency {
        font-size: 1rem;
        color: #9ca3af;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .select-button {
        background: linear-gradient(145deg, 
            rgba(168, 85, 247, 0.9) 0%, 
            rgba(120, 119, 198, 0.8) 50%, 
            rgba(99, 102, 241, 0.9) 100%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 14px;
        padding: 1rem 2rem;
        font-weight: 700;
        color: #ffffff;
        width: 100%;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-transform: uppercase;
        letter-spacing: 0.1em;
        position: relative;
        overflow: hidden;
        font-size: 0.9rem;
        box-shadow: 
            0 8px 25px rgba(168, 85, 247, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    .select-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(255, 255, 255, 0.3), 
            transparent);
        transition: left 0.6s ease;
    }

    .select-button:hover::before {
        left: 100%;
    }

    .select-button:hover {
        background: linear-gradient(145deg, 
            rgba(168, 85, 247, 1) 0%, 
            rgba(120, 119, 198, 0.9) 50%, 
            rgba(99, 102, 241, 1) 100%);
        border-color: rgba(255, 255, 255, 0.4);
        transform: translateY(-3px) scale(1.02);
        box-shadow: 
            0 15px 40px rgba(168, 85, 247, 0.6),
            inset 0 1px 0 rgba(255, 255, 255, 0.3),
            0 0 25px rgba(168, 85, 247, 0.4);
    }

    .select-button:active {
        transform: translateY(-1px) scale(1.01);
        transition: transform 0.1s ease;
    }

    /* Ultra-Premium Modal */
    .modal-backdrop {
        background: rgba(0, 0, 0, 0.95);
        backdrop-filter: blur(25px);
    }

    .modal-content {
        background: linear-gradient(145deg, 
            rgba(10, 10, 10, 0.98) 0%, 
            rgba(26, 26, 26, 0.95) 50%, 
            rgba(15, 15, 15, 0.98) 100%);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 28px;
        backdrop-filter: blur(30px);
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 
            0 25px 80px rgba(0, 0, 0, 0.7),
            0 0 0 1px rgba(255, 255, 255, 0.08),
            inset 0 1px 0 rgba(255, 255, 255, 0.15),
            inset 0 -1px 0 rgba(0, 0, 0, 0.2);
        position: relative;
        overflow: hidden;
    }

    .modal-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(168, 85, 247, 0.8), 
            rgba(120, 119, 198, 0.6), 
            rgba(99, 102, 241, 0.8), 
            transparent);
        filter: blur(1px);
    }

    .modal-title {
        font-size: 2.5rem;
        font-weight: 900;
        background: linear-gradient(135deg, #ffffff 0%, #f3f4f6 30%, #ffffff 70%, #e5e7eb 100%);
        background-size: 200% 200%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.75rem;
        letter-spacing: -0.04em;
        line-height: 1.1;
        animation: modalTitleShift 8s ease-in-out infinite;
    }

    @keyframes modalTitleShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .modal-subtitle {
        color: #9ca3af;
        font-size: 1.25rem;
        font-weight: 500;
        margin-bottom: 3rem;
        letter-spacing: 0.02em;
    }

    .specs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
        margin: 3rem 0;
    }

    .spec-box {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.06) 0%, 
            rgba(255, 255, 255, 0.03) 100%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 16px;
        padding: 1.8rem;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        backdrop-filter: blur(15px);
        position: relative;
        overflow: hidden;
    }

    .spec-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(168, 85, 247, 0.08), 
            transparent);
        transition: left 0.8s ease;
    }

    .spec-box:hover::before {
        left: 100%;
    }

    .spec-box:hover {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.1) 0%, 
            rgba(255, 255, 255, 0.05) 100%);
        border-color: rgba(168, 85, 247, 0.3);
        transform: translateY(-5px) scale(1.02);
        box-shadow: 
            0 15px 35px rgba(0, 0, 0, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.15);
    }

    .spec-label {
        color: #9ca3af;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        margin-bottom: 0.75rem;
    }

    .spec-value {
        color: #ffffff;
        font-weight: 800;
        font-size: 1.2rem;
        letter-spacing: -0.02em;
    }

    .features-container {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin: 2rem 0;
    }

    .feature-badge {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.08) 0%, 
            rgba(255, 255, 255, 0.04) 100%);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 16px;
        padding: 0.75rem 1.5rem;
        font-size: 0.9rem;
        font-weight: 600;
        color: #e5e7eb;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
    }

    .feature-badge::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(168, 85, 247, 0.15), 
            transparent);
        transition: left 0.5s ease;
    }

    .feature-badge:hover::before {
        left: 100%;
    }

    .feature-badge:hover {
        background: linear-gradient(145deg, 
            rgba(168, 85, 247, 0.2) 0%, 
            rgba(120, 119, 198, 0.1) 100%);
        border-color: rgba(168, 85, 247, 0.4);
        transform: scale(1.05) translateY(-2px);
        color: #ffffff;
        box-shadow: 0 8px 20px rgba(168, 85, 247, 0.2);
    }

    .pricing-breakdown {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.06) 0%, 
            rgba(255, 255, 255, 0.03) 100%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 20px;
        padding: 2rem;
        margin: 3rem 0;
        backdrop-filter: blur(15px);
        box-shadow: 
            0 10px 30px rgba(0, 0, 0, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        color: #d1d5db;
        font-weight: 500;
    }

    .price-row:last-child {
        border-bottom: none;
        border-top: 2px solid rgba(168, 85, 247, 0.3);
        font-weight: 800;
        font-size: 1.3rem;
        background: linear-gradient(135deg, #ffffff, #e5e7eb);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
    }

    .proceed-button {
        background: linear-gradient(145deg, 
            rgba(168, 85, 247, 0.9) 0%, 
            rgba(120, 119, 198, 0.8) 50%, 
            rgba(99, 102, 241, 0.9) 100%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        padding: 1.5rem 3rem;
        font-weight: 800;
        color: #ffffff;
        width: 100%;
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        margin-top: 3rem;
        position: relative;
        overflow: hidden;
        box-shadow: 
            0 12px 35px rgba(168, 85, 247, 0.5),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    .proceed-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(255, 255, 255, 0.3), 
            transparent);
        transition: left 0.6s ease;
    }

    .proceed-button:hover::before {
        left: 100%;
    }

    .proceed-button:hover {
        background: linear-gradient(145deg, 
            rgba(168, 85, 247, 1) 0%, 
            rgba(120, 119, 198, 0.9) 50%, 
            rgba(99, 102, 241, 1) 100%);
        border-color: rgba(255, 255, 255, 0.4);
        transform: translateY(-4px) scale(1.02);
        box-shadow: 
            0 20px 50px rgba(168, 85, 247, 0.7),
            inset 0 1px 0 rgba(255, 255, 255, 0.3),
            0 0 30px rgba(168, 85, 247, 0.5);
    }

    .section-header {
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff, #e5e7eb);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1rem;
        letter-spacing: -0.025em;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .specs-container {
            grid-template-columns: 1fr;
        }
        
        .specs-grid {
            grid-template-columns: 1fr;
        }
        
        .price-display {
            font-size: 1.8rem;
        }
        
        .modal-title {
            font-size: 2rem;
        }
        
        .vehicle-name {
            font-size: 1.2rem;
        }
    }
</style>
@endpush

<div>
    <!-- Vehicle Card -->
    <div class="vehicle-card-modern">
        <!-- Info Button -->
        <button class="info-button" 
                wire:click="$dispatch('open-modal', { name: 'vehicle-detail-{{ $vehicle->id }}' })">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
        </button>

    <!-- Vehicle Image -->
        <div class="vehicle-image-container">
    @if($vehicle->image_url && is_array($vehicle->image_url) && !empty($vehicle->image_url))
                <img src="{{ Storage::url($vehicle->image_url[0]) }}" class="vehicle-image" alt="{{ $vehicle->name }}" />
            @else
                <img src="{{ asset('images/sedan.png') }}" class="vehicle-image" alt="{{ $vehicle->name }}" />
    @endif
        </div>

        <!-- Vehicle Content -->
        <div class="p-8">
            <!-- Vehicle Name -->
            <h3 class="vehicle-name">{{ $vehicle->name }} {{ $vehicle->year }}</h3>

            <!-- Specifications Grid -->
            <div class="specs-container">
                <div class="spec-item">
                    <svg class="spec-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12a1 1 0 100-2 1 1 0 000 2z"/>
                        <path d="M9 6a1 1 0 100-2 1 1 0 000 2z"/>
                        <path d="M15 12a1 1 0 100-2 1 1 0 000 2z"/>
                        <path d="M15 6a1 1 0 100-2 1 1 0 000 2z"/>
                        <path d="M3 12a1 1 0 100-2 1 1 0 000 2z"/>
                        <path d="M3 6a1 1 0 100-2 1 1 0 000 2z"/>
                    </svg>
                    <span>{{ $vehicle->seats }} Asientos</span>
                </div>

                <div class="spec-item">
                    <svg class="spec-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $vehicle->luggage_capacity }}L</span>
                </div>

                <div class="spec-item">
                    <svg class="spec-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                    </svg>
                    <span>
                {{ match($vehicle->transmission) {
                            'automatic' => 'Auto',
                    'manual' => 'Manual',
                    default => ucfirst($vehicle->transmission)
                } }}
            </span>
                </div>

                <div class="spec-item">
                    <svg class="spec-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"/>
                    </svg>
                    <span>
                {{ match($vehicle->fuel_type) {
                    'petrol' => 'Gasolina',
                    'diesel' => 'Diesel',
                    'electric' => 'Eléctrico',
                    'hybrid' => 'Híbrido',
                    default => ucfirst($vehicle->fuel_type)
                } }}
            </span>
        </div>
            </div>

            <!-- Price Section -->
            <div class="price-section">
                <div class="price-display">
                    ${{ number_format($vehicle->price_per_day, 2) }}
                    <span class="currency">DOP/día</span>
                </div>
                
                <button class="select-button" 
                        wire:click="proceed">
                    Seleccionar Premium
                </button>
            </div>
        </div>
    </div>

    <!-- Vehicle Details Modal -->
    <x-modal name="vehicle-detail-{{ $vehicle->id }}" :show="false">
        <div class="p-6 bg-zinc-900 text-white">
            <h2 class="text-2xl font-bold mb-4 bg-gradient-to-r from-purple-500 to-indigo-500 bg-clip-text text-transparent">{{ $vehicle->name }} {{ $vehicle->year }}</h2>
            
            <!-- Vehicle Image -->
            <div class="mb-6">
                @if($vehicle->image_url && is_array($vehicle->image_url) && !empty($vehicle->image_url))
                    <img src="{{ Storage::url($vehicle->image_url[0]) }}" class="w-full h-64 object-cover rounded-lg border border-zinc-700" alt="{{ $vehicle->name }}" />
                @endif
            </div>
            
            <!-- Vehicle Details -->
            <div class="space-y-6">
                <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                    <h3 class="text-lg font-semibold text-purple-400 mb-3">Especificaciones</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-zinc-400">Categoría:</span>
                            <span class="ml-2 text-white">{{ $vehicle->category }}</span>
                        </div>
                        <div>
                            <span class="text-zinc-400">Transmisión:</span>
                            <span class="ml-2 text-white">{{ ucfirst($vehicle->transmission) }}</span>
                        </div>
                        <div>
                            <span class="text-zinc-400">Asientos:</span>
                            <span class="ml-2 text-white">{{ $vehicle->seats }}</span>
                        </div>
                        <div>
                            <span class="text-zinc-400">Combustible:</span>
                            <span class="ml-2 text-white">{{ ucfirst($vehicle->fuel_type) }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Features -->
                @if($vehicle->features)
                <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                    <h3 class="text-lg font-semibold text-purple-400 mb-3">Características</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($vehicle->features as $feature)
                            <span class="px-3 py-1 bg-purple-500/10 text-purple-400 border border-purple-500/20 rounded-full text-sm">
                                {{ $feature }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Description -->
                @if($vehicle->remarks)
                <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                    <h3 class="text-lg font-semibold text-purple-400 mb-3">Descripción</h3>
                    <p class="text-zinc-300">{{ $vehicle->remarks }}</p>
                </div>
                @endif
                
                <!-- Price -->
                <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-bold bg-gradient-to-r from-purple-400 to-indigo-400 bg-clip-text text-transparent">${{ number_format($vehicle->price_per_day, 2) }} DOP</span>
                        <span class="text-zinc-400">por día</span>
                    </div>
                </div>
            </div>
            
            <!-- Action Button -->
            <div class="mt-6">
                <button class="select-button w-full" wire:click="proceed">
                    Seleccionar Premium
                </button>
            </div>
        </div>
    </x-modal>
</div>

@script
document.addEventListener('livewire:initialized', () => {
    console.log('VehicleCard Livewire initialized');
    
    // Handle navigation events
    Livewire.on('navigate', ({ url }) => {
        console.log('Navigation event received:', url);
        if (url) {
            window.location.href = url;
        }
    });

    // Handle toast events if they exist
    Livewire.on('show-toast', (message, type) => {
        console.log(`Toast: ${type}: ${message}`);
        // You can implement toast notifications here if needed
        
        // Simple alert for now - replace with proper toast later
        if (type === 'info') {
            alert(message);
        }
    });

    // Add click debugging for buttons
    document.addEventListener('click', (e) => {
        if (e.target.closest('[wire\\:click]')) {
            console.log('Livewire button clicked:', e.target);
            const wireClick = e.target.getAttribute('wire:click') || e.target.closest('[wire\\:click]').getAttribute('wire:click');
            console.log('Wire click action:', wireClick);
        }
    });
});

// Also listen for the document ready event
document.addEventListener('DOMContentLoaded', () => {
    console.log('VehicleCard DOM loaded');
    
    // Ensure modal buttons work even if Livewire hasn't initialized yet
    document.addEventListener('click', (e) => {
        const button = e.target.closest('button[wire\\:click*="open-modal"]');
        if (button) {
            console.log('Modal button clicked:', button);
        }
        
        const proceedButton = e.target.closest('button[wire\\:click="proceed"]');
        if (proceedButton) {
            console.log('Proceed button clicked:', proceedButton);
        }
    });
});
@endscript
