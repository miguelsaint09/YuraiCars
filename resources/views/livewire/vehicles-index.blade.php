@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

    .vehicles-page {
        background: radial-gradient(circle at 15% 30%, rgba(168, 85, 247, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 85% 70%, rgba(120, 119, 198, 0.08) 0%, transparent 50%),
                    radial-gradient(circle at 50% 50%, rgba(99, 102, 241, 0.05) 0%, transparent 50%),
                    linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 25%, #0f0f0f 50%, #1a1a1a 75%, #0a0a0a 100%);
        min-height: 100vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        position: relative;
        overflow-x: hidden;
    }

    .vehicles-page::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            radial-gradient(circle at 30% 20%, rgba(168, 85, 247, 0.12) 0%, transparent 60%),
            radial-gradient(circle at 70% 80%, rgba(120, 119, 198, 0.15) 0%, transparent 60%),
            radial-gradient(circle at 20% 80%, rgba(99, 102, 241, 0.08) 0%, transparent 60%);
        pointer-events: none;
        z-index: 1;
        animation: atmosphereShift 25s ease-in-out infinite;
    }

    @keyframes atmosphereShift {
        0%, 100% { opacity: 0.4; transform: scale(1) rotate(0deg); }
        33% { opacity: 0.7; transform: scale(1.05) rotate(0.3deg); }
        66% { opacity: 0.5; transform: scale(1.1) rotate(-0.3deg); }
    }

    .container-modern {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem;
        position: relative;
        z-index: 2;
    }

    .page-header {
        text-align: center;
        margin-bottom: 4rem;
        padding: 3rem 0;
        position: relative;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(168, 85, 247, 0.15) 0%, rgba(120, 119, 198, 0.1) 50%, transparent 70%);
        filter: blur(80px);
        animation: headerPulse 10s ease-in-out infinite;
        z-index: -1;
    }

    @keyframes headerPulse {
        0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.6; }
        50% { transform: translate(-50%, -50%) scale(1.3); opacity: 0.9; }
    }

    .page-title {
        font-size: 3.75rem;
        font-weight: 900;
        background: linear-gradient(135deg, #ffffff 0%, #f3f4f6 20%, #ffffff 40%, #e5e7eb 60%, #ffffff 80%, #d1d5db 100%);
        background-size: 300% 300%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1rem;
        letter-spacing: -0.06em;
        line-height: 1.05;
        opacity: 0;
        animation: titleMagnetize 1.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        text-shadow: 0 0 50px rgba(255, 255, 255, 0.15);
        animation: titleGradient 8s ease-in-out infinite, titleMagnetize 1.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }

    @keyframes titleGradient {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    @keyframes titleMagnetize {
        0% {
            opacity: 0;
            transform: translateY(80px) scale(0.7);
            filter: blur(15px);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0);
        }
    }

    .page-subtitle {
        font-size: 1.25rem;
        color: #9ca3af;
        font-weight: 400;
        max-width: 650px;
        margin: 0 auto;
        line-height: 1.6;
        opacity: 0;
        animation: subtitleFloat 1.2s ease-out 0.4s forwards;
        position: relative;
    }

    @keyframes subtitleFloat {
        0% {
            opacity: 0;
            transform: translateY(40px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .main-layout {
        display: grid;
        grid-template-columns: 360px 1fr;
        gap: 3rem;
        align-items: start;
    }

    /* Ultra-Premium Filters Panel */
    .filters-panel {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.08) 0%, 
            rgba(255, 255, 255, 0.04) 50%, 
            rgba(255, 255, 255, 0.02) 100%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 28px;
        padding: 2.5rem;
        backdrop-filter: blur(25px);
        position: sticky;
        top: 2rem;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 
            0 10px 40px rgba(0, 0, 0, 0.4),
            0 0 0 1px rgba(255, 255, 255, 0.06),
            inset 0 1px 0 rgba(255, 255, 255, 0.15),
            inset 0 -1px 0 rgba(0, 0, 0, 0.1);
        opacity: 0;
        animation: filtersReveal 1.2s cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.7s forwards;
        position: relative;
        overflow: hidden;
    }

    .filters-panel::before {
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
    }

    .filters-panel::after {
        content: '';
        position: absolute;
        top: -60%;
        left: -60%;
        width: 220%;
        height: 220%;
        background: conic-gradient(from 0deg, 
            transparent, 
            rgba(168, 85, 247, 0.08), 
            transparent, 
            rgba(120, 119, 198, 0.06), 
            transparent);
        animation: filtersBg 30s linear infinite;
        z-index: -1;
    }

    @keyframes filtersBg {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes filtersReveal {
        0% {
            opacity: 0;
            transform: translateX(-50px) scale(0.9);
            filter: blur(10px);
        }
        100% {
            opacity: 1;
            transform: translateX(0) scale(1);
            filter: blur(0);
        }
    }

    .filters-panel:hover {
        border-color: rgba(255, 255, 255, 0.2);
        transform: translateY(-8px);
        box-shadow: 
            0 25px 60px rgba(0, 0, 0, 0.5),
            0 0 0 1px rgba(255, 255, 255, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.2),
            inset 0 -1px 0 rgba(0, 0, 0, 0.1);
    }

    .filters-title {
        font-size: 1.6rem;
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff, #f3f4f6, #e5e7eb);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 2.5rem;
        text-align: center;
        letter-spacing: -0.03em;
        position: relative;
        padding-bottom: 1rem;
    }

    .filters-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(168, 85, 247, 0.7), 
            rgba(120, 119, 198, 0.5), 
            rgba(99, 102, 241, 0.7), 
            transparent);
        border-radius: 3px;
        filter: blur(0.5px);
    }

    .filter-group {
        margin-bottom: 2rem;
        position: relative;
    }

    .filter-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 700;
        color: #e5e7eb;
        margin-bottom: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        position: relative;
        padding-left: 16px;
    }

    .filter-label::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 16px;
        background: linear-gradient(180deg, 
            rgba(168, 85, 247, 0.9), 
            rgba(120, 119, 198, 0.7), 
            rgba(99, 102, 241, 0.9));
        border-radius: 3px;
        box-shadow: 0 0 8px rgba(168, 85, 247, 0.4);
    }

    .filter-select, .filter-input {
        width: 100%;
        padding: 1.1rem 1.4rem;
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.1) 0%, 
            rgba(255, 255, 255, 0.06) 50%, 
            rgba(255, 255, 255, 0.04) 100%);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 14px;
        color: #ffffff;
        font-size: 0.95rem;
        font-weight: 600;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        backdrop-filter: blur(15px);
        box-shadow: 
            0 4px 15px rgba(0, 0, 0, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }

    .filter-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23a855f7' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 1rem center;
        background-repeat: no-repeat;
        background-size: 1.8em 1.8em;
        padding-right: 3rem;
    }

    .filter-select:focus, .filter-input:focus {
        outline: none;
        border-color: rgba(168, 85, 247, 0.6);
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.15) 0%, 
            rgba(255, 255, 255, 0.08) 50%, 
            rgba(255, 255, 255, 0.06) 100%);
        box-shadow: 
            0 0 0 4px rgba(168, 85, 247, 0.15),
            0 8px 30px rgba(0, 0, 0, 0.25),
            inset 0 1px 0 rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
    }

    .filter-select option {
        background: #1a1a1a;
        color: #ffffff;
        padding: 1rem;
        font-weight: 600;
    }

    .filter-input::placeholder {
        color: #9ca3af;
        font-weight: 500;
    }

    .price-filters {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.2rem;
    }

    /* Ultra-Premium Vehicles Section */
    .vehicles-section {
        opacity: 0;
        animation: vehiclesReveal 1.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.9s forwards;
    }

    @keyframes vehiclesReveal {
        0% {
            opacity: 0;
            transform: translateX(60px) scale(0.9);
            filter: blur(8px);
        }
        100% {
            opacity: 1;
            transform: translateX(0) scale(1);
            filter: blur(0);
        }
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2.5rem;
        padding: 2rem 0;
        position: relative;
    }

    .section-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(255, 255, 255, 0.2), 
            rgba(168, 85, 247, 0.3), 
            rgba(255, 255, 255, 0.2), 
            transparent);
    }

    .section-title {
        font-size: 2.2rem;
        font-weight: 900;
        background: linear-gradient(135deg, #ffffff 0%, #f3f4f6 30%, #ffffff 60%, #e5e7eb 100%);
        background-size: 200% 200%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.04em;
        position: relative;
        animation: sectionTitleShift 6s ease-in-out infinite;
    }

    @keyframes sectionTitleShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .vehicles-count {
        font-size: 0.9rem;
        color: #d1d5db;
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.1) 0%, 
            rgba(255, 255, 255, 0.06) 50%, 
            rgba(255, 255, 255, 0.04) 100%);
        padding: 1rem 2rem;
        border-radius: 30px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(15px);
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        box-shadow: 
            0 6px 20px rgba(0, 0, 0, 0.15),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }

    .vehicles-count:hover {
        transform: translateY(-2px);
        box-shadow: 
            0 10px 30px rgba(0, 0, 0, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.15);
    }

    .vehicles-container {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.08) 0%, 
            rgba(255, 255, 255, 0.04) 50%, 
            rgba(255, 255, 255, 0.02) 100%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 28px;
        padding: 3rem;
        backdrop-filter: blur(25px);
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        box-shadow: 
            0 12px 45px rgba(0, 0, 0, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.15),
            inset 0 -1px 0 rgba(0, 0, 0, 0.1);
    }

    .vehicles-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(168, 85, 247, 0.4), 
            rgba(120, 119, 198, 0.6), 
            rgba(99, 102, 241, 0.4), 
            transparent);
        filter: blur(1px);
    }

    .vehicles-container:hover {
        border-color: rgba(255, 255, 255, 0.18);
        transform: translateY(-3px);
        box-shadow: 
            0 25px 70px rgba(0, 0, 0, 0.5),
            inset 0 1px 0 rgba(255, 255, 255, 0.2),
            inset 0 -1px 0 rgba(0, 0, 0, 0.1);
    }

    .vehicles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(370px, 1fr));
        gap: 2.5rem;
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 6rem 3rem;
        text-align: center;
        min-height: 500px;
        position: relative;
    }

    .empty-state::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, 
            rgba(168, 85, 247, 0.15) 0%, 
            rgba(120, 119, 198, 0.1) 40%, 
            transparent 70%);
        filter: blur(60px);
        animation: emptyAura 8s ease-in-out infinite;
    }

    @keyframes emptyAura {
        0%, 100% { 
            opacity: 0.4; 
            transform: translate(-50%, -50%) scale(1) rotate(0deg); 
        }
        50% { 
            opacity: 0.8; 
            transform: translate(-50%, -50%) scale(1.4) rotate(180deg); 
        }
    }

    .empty-icon {
        font-size: 6rem;
        opacity: 0.5;
        margin-bottom: 2rem;
        filter: drop-shadow(0 6px 20px rgba(0, 0, 0, 0.4));
        animation: emptyLevitate 6s ease-in-out infinite;
    }

    @keyframes emptyLevitate {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        33% { transform: translateY(-15px) rotate(1deg); }
        66% { transform: translateY(-8px) rotate(-1deg); }
    }

    .empty-title {
        font-size: 1.8rem;
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff, #e5e7eb);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1.5rem;
        letter-spacing: -0.03em;
    }

    .empty-description {
        color: #9ca3af;
        max-width: 500px;
        line-height: 1.8;
        font-size: 1.1rem;
        font-weight: 500;
    }

    .vehicle-card-wrapper {
        opacity: 0;
        animation: cardMaterialize 1s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }

    .vehicle-card-wrapper:nth-child(1) { animation-delay: 0.1s; }
    .vehicle-card-wrapper:nth-child(2) { animation-delay: 0.2s; }
    .vehicle-card-wrapper:nth-child(3) { animation-delay: 0.3s; }
    .vehicle-card-wrapper:nth-child(4) { animation-delay: 0.4s; }
    .vehicle-card-wrapper:nth-child(5) { animation-delay: 0.5s; }
    .vehicle-card-wrapper:nth-child(6) { animation-delay: 0.6s; }

    @keyframes cardMaterialize {
        0% {
            opacity: 0;
            transform: translateY(40px) scale(0.85) rotateX(15deg);
            filter: blur(8px);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1) rotateX(0deg);
            filter: blur(0);
        }
    }

    /* Premium Glitch Effect */
    .glitch-effect {
        position: relative;
        animation: glitch 4s infinite;
    }

    @keyframes glitch {
        0%, 100% { transform: translate(0); }
        1% { transform: translate(-1px, 1px); }
        2% { transform: translate(1px, -1px); }
        3% { transform: translate(0); }
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .main-layout {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .filters-panel {
            position: relative;
            top: 0;
        }
        
        .container-modern {
            padding: 1rem;
        }
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 2.8rem;
        }
        
        .price-filters {
            grid-template-columns: 1fr;
        }
        
        .vehicles-grid {
            grid-template-columns: 1fr;
        }
        
        .section-header {
            flex-direction: column;
            gap: 1.5rem;
            align-items: flex-start;
        }
    }
</style>
@endpush

<div class="vehicles-page text-white">
    <div class="container-modern">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Colección Exclusiva</h1>
            <p class="page-subtitle">
                Descubra nuestra selecta gama de vehículos premium, cada uno meticulosamente elegido para ofrecer una experiencia de conducción incomparable
            </p>
        </div>

        <div class="main-layout">
            <!-- Filters Panel -->
            <div class="filters-panel">
                <h2 class="filters-title">Criterios de Selección</h2>

                <div class="space-y-6">
                    <!-- Category Filter -->
                    <div class="filter-group">
                        <label class="filter-label">Categoría Premium</label>
                        <select wire:model.live="category" class="filter-select">
                            <option value="">Todas las categorías</option>
                            <option value="Sedan">Sedán Ejecutivo</option>
                            <option value="SUV">SUV de Lujo</option>
                            <option value="Hatchback">Hatchback Deportivo</option>
                            <option value="Convertible">Convertible Elite</option>
                            <option value="Truck">Camioneta Premium</option>
                            <option value="Van">Van Empresarial</option>
                        </select>
                    </div>

                    <!-- Transmission Filter -->
                    <div class="filter-group">
                        <label class="filter-label">Sistema de Transmisión</label>
                        <select wire:model.live="transmission" class="filter-select">
                            <option value="">Todos los sistemas</option>
                            <option value="Automático">Automático Avanzado</option>
                            <option value="Manual">Manual Deportivo</option>
                        </select>
                    </div>

                    <!-- Fuel Type Filter -->
                    <div class="filter-group">
                        <label class="filter-label">Tecnología Energética</label>
                        <select wire:model.live="fuelType" class="filter-select">
                            <option value="">Todas las tecnologías</option>
                            <option value="Gasolina">Gasolina Premium</option>
                            <option value="Diesel">Diesel Eficiente</option>
                            <option value="Eléctrico">Eléctrico Avanzado</option>
                            <option value="Híbrido">Híbrido Inteligente</option>
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div class="filter-group">
                        <label class="filter-label">Rango Tarifario (DOP)</label>
                        <div class="price-filters">
                            <input 
                                wire:model.live="priceMin" 
                                type="number" 
                                placeholder="Desde"
                                class="filter-input"
                            />
                            <input 
                                wire:model.live="priceMax" 
                                type="number" 
                                placeholder="Hasta"
                                class="filter-input"
                            />
                        </div>
                    </div>

                    <!-- Filter Button -->
                    <button 
                        wire:click="applyFilters"
                        class="w-full px-6 py-3 text-lg font-semibold text-white bg-gradient-to-r from-purple-600 to-indigo-600 rounded-lg shadow-lg hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-gray-900 transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]"
                    >
                        <div class="flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            <span>Aplicar Filtros</span>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Search Section -->
            <div class="bg-black/20 border border-white/10 rounded-2xl p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Search Fields -->
                        </div>
                </div>

            <!-- Results Section -->
            <div>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-white">Encontramos estos resultados para ti</h2>
                    <span class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-zinc-400">{{ count($vehicles) }} vehículos premium</span>
                        </div>

                <!-- Vehicle Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($vehicles as $vehicle)
                        <x-vehicle-card :vehicle="$vehicle" wire:key="vehicle-card-{{ $vehicle->id }}" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-[9999] overflow-y-auto" wire:click.self="closeModal">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>

            <!-- Modal Content -->
            <div class="relative min-h-screen flex items-center justify-center p-4">
                <div class="relative w-full max-w-4xl bg-black/90 rounded-2xl shadow-xl transform transition-all">
                    @if($selectedVehicle)
                        <div class="p-8">
                            <!-- Header -->
                            <div class="flex justify-between items-center mb-8">
                                <div>
                                    <h2 class="text-4xl font-black bg-gradient-to-r from-purple-400 via-purple-500 to-indigo-500 bg-clip-text text-transparent">
                                        {{ $selectedVehicle->name }}
                                    </h2>
                                    <p class="text-xl text-zinc-400 mt-1">{{ $selectedVehicle->year }} {{ $selectedVehicle->make }} {{ $selectedVehicle->model }}</p>
                                </div>
        <!-- Modal Content -->
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative w-full max-w-4xl bg-black/90 rounded-2xl shadow-xl transform transition-all">
                @if($selectedVehicle)
                    <div class="p-8">
                        <!-- Header -->
                        <div class="flex justify-between items-center mb-8">
                            <div>
                                <h2 class="text-4xl font-black bg-gradient-to-r from-purple-400 via-purple-500 to-indigo-500 bg-clip-text text-transparent">
                                    {{ $selectedVehicle->name }}
                                </h2>
                                <p class="text-xl text-zinc-400 mt-1">{{ $selectedVehicle->year }} {{ $selectedVehicle->make }} {{ $selectedVehicle->model }}</p>
                            </div>
                            <button 
                                wire:click="closeModal"
                                class="rounded-full p-2 hover:bg-white/10 transition-colors"
                            >
                                <svg class="w-6 h-6 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Content Grid -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <!-- Vehicle Image -->
                                <div class="relative rounded-2xl overflow-hidden border border-white/10 bg-black/20">
                                    @if($selectedVehicle->image_url && is_array($selectedVehicle->image_url) && !empty($selectedVehicle->image_url))
                                        <img 
                                            src="{{ Storage::url($selectedVehicle->image_url[0]) }}" 
                                            class="w-full aspect-[16/9] object-cover"
                                            alt="{{ $selectedVehicle->name }}"
                                        />
                @else
                                        <img 
                                            src="{{ asset('images/sedan.png') }}" 
                                            class="w-full aspect-[16/9] object-cover"
                                            alt="{{ $selectedVehicle->name }}"
                                        />
                                    @endif
@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

    .vehicles-page {
        background: radial-gradient(circle at 15% 30%, rgba(168, 85, 247, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 85% 70%, rgba(120, 119, 198, 0.08) 0%, transparent 50%),
                    radial-gradient(circle at 50% 50%, rgba(99, 102, 241, 0.05) 0%, transparent 50%),
                    linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 25%, #0f0f0f 50%, #1a1a1a 75%, #0a0a0a 100%);
        min-height: 100vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        position: relative;
        overflow-x: hidden;
    }

    .vehicles-page::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            radial-gradient(circle at 30% 20%, rgba(168, 85, 247, 0.12) 0%, transparent 60%),
            radial-gradient(circle at 70% 80%, rgba(120, 119, 198, 0.15) 0%, transparent 60%),
            radial-gradient(circle at 20% 80%, rgba(99, 102, 241, 0.08) 0%, transparent 60%);
        pointer-events: none;
        z-index: 1;
        animation: atmosphereShift 25s ease-in-out infinite;
    }

    @keyframes atmosphereShift {
        0%, 100% { opacity: 0.4; transform: scale(1) rotate(0deg); }
        33% { opacity: 0.7; transform: scale(1.05) rotate(0.3deg); }
        66% { opacity: 0.5; transform: scale(1.1) rotate(-0.3deg); }
    }

    .container-modern {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem;
        position: relative;
        z-index: 2;
    }

    .page-header {
        text-align: center;
        margin-bottom: 4rem;
        padding: 3rem 0;
        position: relative;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(168, 85, 247, 0.15) 0%, rgba(120, 119, 198, 0.1) 50%, transparent 70%);
        filter: blur(80px);
        animation: headerPulse 10s ease-in-out infinite;
        z-index: -1;
    }

    @keyframes headerPulse {
        0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.6; }
        50% { transform: translate(-50%, -50%) scale(1.3); opacity: 0.9; }
    }

    .page-title {
        font-size: 3.75rem;
        font-weight: 900;
        background: linear-gradient(135deg, #ffffff 0%, #f3f4f6 20%, #ffffff 40%, #e5e7eb 60%, #ffffff 80%, #d1d5db 100%);
        background-size: 300% 300%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1rem;
        letter-spacing: -0.06em;
        line-height: 1.05;
        opacity: 0;
        animation: titleMagnetize 1.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        text-shadow: 0 0 50px rgba(255, 255, 255, 0.15);
        animation: titleGradient 8s ease-in-out infinite, titleMagnetize 1.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }

    @keyframes titleGradient {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    @keyframes titleMagnetize {
        0% {
            opacity: 0;
            transform: translateY(80px) scale(0.7);
            filter: blur(15px);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0);
        }
    }

    .page-subtitle {
        font-size: 1.25rem;
        color: #9ca3af;
        font-weight: 400;
        max-width: 650px;
        margin: 0 auto;
        line-height: 1.6;
        opacity: 0;
        animation: subtitleFloat 1.2s ease-out 0.4s forwards;
        position: relative;
    }

    @keyframes subtitleFloat {
        0% {
            opacity: 0;
            transform: translateY(40px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .main-layout {
        display: grid;
        grid-template-columns: 360px 1fr;
        gap: 3rem;
        align-items: start;
    }

    /* Ultra-Premium Filters Panel */
    .filters-panel {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.08) 0%, 
            rgba(255, 255, 255, 0.04) 50%, 
            rgba(255, 255, 255, 0.02) 100%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 28px;
        padding: 2.5rem;
        backdrop-filter: blur(25px);
        position: sticky;
        top: 2rem;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 
            0 10px 40px rgba(0, 0, 0, 0.4),
            0 0 0 1px rgba(255, 255, 255, 0.06),
            inset 0 1px 0 rgba(255, 255, 255, 0.15),
            inset 0 -1px 0 rgba(0, 0, 0, 0.1);
        opacity: 0;
        animation: filtersReveal 1.2s cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.7s forwards;
        position: relative;
        overflow: hidden;
    }

    .filters-panel::before {
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
    }

    .filters-panel::after {
        content: '';
        position: absolute;
        top: -60%;
        left: -60%;
        width: 220%;
        height: 220%;
        background: conic-gradient(from 0deg, 
            transparent, 
            rgba(168, 85, 247, 0.08), 
            transparent, 
            rgba(120, 119, 198, 0.06), 
            transparent);
        animation: filtersBg 30s linear infinite;
        z-index: -1;
    }

    @keyframes filtersBg {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes filtersReveal {
        0% {
            opacity: 0;
            transform: translateX(-50px) scale(0.9);
            filter: blur(10px);
        }
        100% {
            opacity: 1;
            transform: translateX(0) scale(1);
            filter: blur(0);
        }
    }

    .filters-panel:hover {
        border-color: rgba(255, 255, 255, 0.2);
        transform: translateY(-8px);
        box-shadow: 
            0 25px 60px rgba(0, 0, 0, 0.5),
            0 0 0 1px rgba(255, 255, 255, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.2),
            inset 0 -1px 0 rgba(0, 0, 0, 0.1);
    }

    .filters-title {
        font-size: 1.6rem;
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff, #f3f4f6, #e5e7eb);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 2.5rem;
        text-align: center;
        letter-spacing: -0.03em;
        position: relative;
        padding-bottom: 1rem;
    }

    .filters-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(168, 85, 247, 0.7), 
            rgba(120, 119, 198, 0.5), 
            rgba(99, 102, 241, 0.7), 
            transparent);
        border-radius: 3px;
        filter: blur(0.5px);
    }

    .filter-group {
        margin-bottom: 2rem;
        position: relative;
    }

    .filter-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 700;
        color: #e5e7eb;
        margin-bottom: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        position: relative;
        padding-left: 16px;
    }

    .filter-label::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 16px;
        background: linear-gradient(180deg, 
            rgba(168, 85, 247, 0.9), 
            rgba(120, 119, 198, 0.7), 
            rgba(99, 102, 241, 0.9));
        border-radius: 3px;
        box-shadow: 0 0 8px rgba(168, 85, 247, 0.4);
    }

    .filter-select, .filter-input {
        width: 100%;
        padding: 1.1rem 1.4rem;
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.1) 0%, 
            rgba(255, 255, 255, 0.06) 50%, 
            rgba(255, 255, 255, 0.04) 100%);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 14px;
        color: #ffffff;
        font-size: 0.95rem;
        font-weight: 600;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        backdrop-filter: blur(15px);
        box-shadow: 
            0 4px 15px rgba(0, 0, 0, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }

    .filter-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23a855f7' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 1rem center;
        background-repeat: no-repeat;
        background-size: 1.8em 1.8em;
        padding-right: 3rem;
    }

    .filter-select:focus, .filter-input:focus {
        outline: none;
        border-color: rgba(168, 85, 247, 0.6);
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.15) 0%, 
            rgba(255, 255, 255, 0.08) 50%, 
            rgba(255, 255, 255, 0.06) 100%);
        box-shadow: 
            0 0 0 4px rgba(168, 85, 247, 0.15),
            0 8px 30px rgba(0, 0, 0, 0.25),
            inset 0 1px 0 rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
    }

    .filter-select option {
        background: #1a1a1a;
        color: #ffffff;
        padding: 1rem;
        font-weight: 600;
    }

    .filter-input::placeholder {
        color: #9ca3af;
        font-weight: 500;
    }

    .price-filters {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.2rem;
    }

    /* Ultra-Premium Vehicles Section */
    .vehicles-section {
        opacity: 0;
        animation: vehiclesReveal 1.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.9s forwards;
    }

    @keyframes vehiclesReveal {
        0% {
            opacity: 0;
            transform: translateX(60px) scale(0.9);
            filter: blur(8px);
        }
        100% {
            opacity: 1;
            transform: translateX(0) scale(1);
            filter: blur(0);
        }
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2.5rem;
        padding: 2rem 0;
        position: relative;
    }

    .section-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(255, 255, 255, 0.2), 
            rgba(168, 85, 247, 0.3), 
            rgba(255, 255, 255, 0.2), 
            transparent);
    }

    .section-title {
        font-size: 2.2rem;
        font-weight: 900;
        background: linear-gradient(135deg, #ffffff 0%, #f3f4f6 30%, #ffffff 60%, #e5e7eb 100%);
        background-size: 200% 200%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.04em;
        position: relative;
        animation: sectionTitleShift 6s ease-in-out infinite;
    }

    @keyframes sectionTitleShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .vehicles-count {
        font-size: 0.9rem;
        color: #d1d5db;
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.1) 0%, 
            rgba(255, 255, 255, 0.06) 50%, 
            rgba(255, 255, 255, 0.04) 100%);
        padding: 1rem 2rem;
        border-radius: 30px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(15px);
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        box-shadow: 
            0 6px 20px rgba(0, 0, 0, 0.15),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }

    .vehicles-count:hover {
        transform: translateY(-2px);
        box-shadow: 
            0 10px 30px rgba(0, 0, 0, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.15);
    }

    .vehicles-container {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.08) 0%, 
            rgba(255, 255, 255, 0.04) 50%, 
            rgba(255, 255, 255, 0.02) 100%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 28px;
        padding: 3rem;
        backdrop-filter: blur(25px);
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        box-shadow: 
            0 12px 45px rgba(0, 0, 0, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.15),
            inset 0 -1px 0 rgba(0, 0, 0, 0.1);
    }

    .vehicles-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(168, 85, 247, 0.4), 
            rgba(120, 119, 198, 0.6), 
            rgba(99, 102, 241, 0.4), 
            transparent);
        filter: blur(1px);
    }

    .vehicles-container:hover {
        border-color: rgba(255, 255, 255, 0.18);
        transform: translateY(-3px);
        box-shadow: 
            0 25px 70px rgba(0, 0, 0, 0.5),
            inset 0 1px 0 rgba(255, 255, 255, 0.2),
            inset 0 -1px 0 rgba(0, 0, 0, 0.1);
    }

    .vehicles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(370px, 1fr));
        gap: 2.5rem;
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 6rem 3rem;
        text-align: center;
        min-height: 500px;
        position: relative;
    }

    .empty-state::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, 
            rgba(168, 85, 247, 0.15) 0%, 
            rgba(120, 119, 198, 0.1) 40%, 
            transparent 70%);
        filter: blur(60px);
        animation: emptyAura 8s ease-in-out infinite;
    }

    @keyframes emptyAura {
        0%, 100% { 
            opacity: 0.4; 
            transform: translate(-50%, -50%) scale(1) rotate(0deg); 
        }
        50% { 
            opacity: 0.8; 
            transform: translate(-50%, -50%) scale(1.4) rotate(180deg); 
        }
    }

    .empty-icon {
        font-size: 6rem;
        opacity: 0.5;
        margin-bottom: 2rem;
        filter: drop-shadow(0 6px 20px rgba(0, 0, 0, 0.4));
        animation: emptyLevitate 6s ease-in-out infinite;
    }

    @keyframes emptyLevitate {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        33% { transform: translateY(-15px) rotate(1deg); }
        66% { transform: translateY(-8px) rotate(-1deg); }
    }

    .empty-title {
        font-size: 1.8rem;
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff, #e5e7eb);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1.5rem;
        letter-spacing: -0.03em;
    }

    .empty-description {
        color: #9ca3af;
        max-width: 500px;
        line-height: 1.8;
        font-size: 1.1rem;
        font-weight: 500;
    }

    .vehicle-card-wrapper {
        opacity: 0;
        animation: cardMaterialize 1s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }

    .vehicle-card-wrapper:nth-child(1) { animation-delay: 0.1s; }
    .vehicle-card-wrapper:nth-child(2) { animation-delay: 0.2s; }
    .vehicle-card-wrapper:nth-child(3) { animation-delay: 0.3s; }
    .vehicle-card-wrapper:nth-child(4) { animation-delay: 0.4s; }
    .vehicle-card-wrapper:nth-child(5) { animation-delay: 0.5s; }
    .vehicle-card-wrapper:nth-child(6) { animation-delay: 0.6s; }

    @keyframes cardMaterialize {
        0% {
            opacity: 0;
            transform: translateY(40px) scale(0.85) rotateX(15deg);
            filter: blur(8px);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1) rotateX(0deg);
            filter: blur(0);
        }
    }

    /* Premium Glitch Effect */
    .glitch-effect {
        position: relative;
        animation: glitch 4s infinite;
    }

    @keyframes glitch {
        0%, 100% { transform: translate(0); }
        1% { transform: translate(-1px, 1px); }
        2% { transform: translate(1px, -1px); }
        3% { transform: translate(0); }
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .main-layout {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .filters-panel {
            position: relative;
            top: 0;
        }
        
        .container-modern {
            padding: 1rem;
        }
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 2.8rem;
        }
        
        .price-filters {
            grid-template-columns: 1fr;
        }
        
        .vehicles-grid {
            grid-template-columns: 1fr;
        }
        
        .section-header {
            flex-direction: column;
            gap: 1.5rem;
            align-items: flex-start;
        }
    }
</style>
@endpush

<div class="vehicles-page text-white">
    <div class="container-modern">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Colección Exclusiva</h1>
            <p class="page-subtitle">
                Descubra nuestra selecta gama de vehículos premium, cada uno meticulosamente elegido para ofrecer una experiencia de conducción incomparable
            </p>
                                </div>

        <div class="main-layout">
            <!-- Filters Panel -->
            <div class="filters-panel">
                <h2 class="filters-title">Criterios de Selección</h2>

                <div class="space-y-6">
                    <!-- Category Filter -->
                    <div class="filter-group">
                        <label class="filter-label">Categoría Premium</label>
                        <select wire:model.live="category" class="filter-select">
                            <option value="">Todas las categorías</option>
                            <option value="Sedan">Sedán Ejecutivo</option>
                            <option value="SUV">SUV de Lujo</option>
                            <option value="Hatchback">Hatchback Deportivo</option>
                            <option value="Convertible">Convertible Elite</option>
                            <option value="Truck">Camioneta Premium</option>
                            <option value="Van">Van Empresarial</option>
                        </select>
                    </div>

                    <!-- Transmission Filter -->
                    <div class="filter-group">
                        <label class="filter-label">Sistema de Transmisión</label>
                        <select wire:model.live="transmission" class="filter-select">
                            <option value="">Todos los sistemas</option>
                            <option value="Automático">Automático Avanzado</option>
                            <option value="Manual">Manual Deportivo</option>
                        </select>
                    </div>

                    <!-- Fuel Type Filter -->
                    <div class="filter-group">
                        <label class="filter-label">Tecnología Energética</label>
                        <select wire:model.live="fuelType" class="filter-select">
                            <option value="">Todas las tecnologías</option>
                            <option value="Gasolina">Gasolina Premium</option>
                            <option value="Diesel">Diesel Eficiente</option>
                            <option value="Eléctrico">Eléctrico Avanzado</option>
                            <option value="Híbrido">Híbrido Inteligente</option>
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div class="filter-group">
                        <label class="filter-label">Rango Tarifario (DOP)</label>
                        <div class="price-filters">
                            <input 
                                wire:model.live="priceMin" 
                                type="number" 
                                placeholder="Desde"
                                class="filter-input"
                            />
                            <input 
                                wire:model.live="priceMax" 
                                type="number" 
                                placeholder="Hasta"
                                class="filter-input"
                            />
                        </div>
                    </div>

                    <!-- Filter Button -->
                    <button 
                        wire:click="applyFilters"
                        class="w-full px-6 py-3 text-lg font-semibold text-white bg-gradient-to-r from-purple-600 to-indigo-600 rounded-lg shadow-lg hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-gray-900 transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]"
                    >
                        <div class="flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            <span>Aplicar Filtros</span>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Search Section -->
            <div class="bg-black/20 border border-white/10 rounded-2xl p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Search Fields -->
                </div>
            </div>

            <!-- Results Section -->
            <div>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-white">Encontramos estos resultados para ti</h2>
                    <span class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-zinc-400">6 vehículos premium</span>
                </div>

                <!-- Vehicle Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($vehicles as $vehicle)
                        <x-vehicle-card :vehicle="$vehicle" />
                        @endforeach
                    </div>
            </div>
        </div>
    </div>
</div>

<!-- Vehicle Details Modal -->
<div x-data>
    <x-modal name="vehicle-details-modal" :show="false">
        @if($selectedVehicle)
            <div class="p-8">
                <!-- Header -->
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h2 class="text-4xl font-black bg-gradient-to-r from-purple-400 via-purple-500 to-indigo-500 bg-clip-text text-transparent">
                            {{ $selectedVehicle->name }}
                        </h2>
                        <p class="text-xl text-zinc-400 mt-1">{{ $selectedVehicle->year }} {{ $selectedVehicle->make }} {{ $selectedVehicle->model }}</p>
                    </div>
                    <button 
                        @click="$dispatch('close')"
                        class="rounded-full p-2 hover:bg-white/10 transition-colors"
                    >
                        <svg class="w-6 h-6 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Vehicle Image -->
                        <div class="relative rounded-2xl overflow-hidden border border-white/10 bg-black/20">
                            @if($selectedVehicle->image_url && is_array($selectedVehicle->image_url) && !empty($selectedVehicle->image_url))
                                <img 
                                    src="{{ Storage::url($selectedVehicle->image_url[0]) }}" 
                                    class="w-full aspect-[16/9] object-cover"
                                    alt="{{ $selectedVehicle->name }}"
                                />
                            @else
                                <img 
                                    src="{{ asset('images/sedan.png') }}" 
                                    class="w-full aspect-[16/9] object-cover"
                                    alt="{{ $selectedVehicle->name }}"
                                />
                @endif
            </div>

                        <!-- Basic Information -->
                        <div class="bg-white/5 rounded-2xl p-6 border border-white/10">
                            <h3 class="text-xl font-bold text-purple-400 mb-4">Información Básica</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="text-zinc-400 text-sm">Marca</span>
                                    <p class="text-white font-medium">{{ $selectedVehicle->make }}</p>
        </div>
                                <div>
                                    <span class="text-zinc-400 text-sm">Modelo</span>
                                    <p class="text-white font-medium">{{ $selectedVehicle->model }}</p>
    </div>
                                <div>
                                    <span class="text-zinc-400 text-sm">Año</span>
                                    <p class="text-white font-medium">{{ $selectedVehicle->year }}</p>
                                </div>
                                <div>
                                    <span class="text-zinc-400 text-sm">Color</span>
                                    <p class="text-white font-medium">{{ $selectedVehicle->color }}</p>
                                </div>
                                <div>
                                    <span class="text-zinc-400 text-sm">Matrícula</span>
                                    <p class="text-white font-medium">{{ $selectedVehicle->license_plate }}</p>
                                </div>
                                <div>
                                    <span class="text-zinc-400 text-sm">Categoría</span>
                                    <p class="text-white font-medium">{{ $selectedVehicle->category }}</p>
                                </div>
                            </div>
</div>
</div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Technical Specifications -->
                        <div class="bg-white/5 rounded-2xl p-6 border border-white/10">
                            <h3 class="text-xl font-bold text-purple-400 mb-4">Especificaciones Técnicas</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="text-zinc-400 text-sm">Transmisión</span>
                                    <p class="text-white font-medium">
                                        {{ $selectedVehicle->transmission === 'automatic' ? 'Automática' : 'Manual' }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-zinc-400 text-sm">Combustible</span>
                                    <p class="text-white font-medium">
                                        {{ $selectedVehicle->fuel_type === 'gasoline' ? 'Gasolina' : 'Diésel' }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-zinc-400 text-sm">Asientos</span>
                                    <p class="text-white font-medium">{{ $selectedVehicle->seats }}</p>
                                </div>
                                <div>
                                    <span class="text-zinc-400 text-sm">Maletas</span>
                                    <p class="text-white font-medium">{{ $selectedVehicle->luggage }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Features -->
                        <div class="bg-white/5 rounded-2xl p-6 border border-white/10">
                            <h3 class="text-xl font-bold text-purple-400 mb-4">Características</h3>
                            <div class="grid grid-cols-2 gap-3">
                                @if($selectedVehicle->features)
                                    @foreach($selectedVehicle->features as $feature)
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-purple-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span class="text-white">{{ $feature }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-zinc-400 col-span-2">No hay características especiales registradas.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Price and Rent Button -->
                        <div class="bg-white/5 rounded-2xl p-6 border border-white/10">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <span class="block text-zinc-400 text-sm">Tarifa por día</span>
                                    <span class="text-3xl font-bold bg-gradient-to-r from-purple-400 to-indigo-400 bg-clip-text text-transparent">
                                        ${{ number_format($selectedVehicle->price_per_day, 2) }} DOP
                                    </span>
                                </div>
                            </div>
                            
                            <button 
                                wire:click="proceedWithVehicle({{ $selectedVehicle->id }})"
                                class="w-full h-14 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-2"
                            >
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-lg">Rentar Ahora</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </x-modal>
</div>


