@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

    .rent-page {
        background: radial-gradient(circle at 20% 50%, rgba(120, 119, 198, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.05) 0%, transparent 50%),
                    radial-gradient(circle at 40% 80%, rgba(120, 119, 198, 0.08) 0%, transparent 50%),
                    linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 25%, #0f0f0f 50%, #1a1a1a 75%, #0a0a0a 100%);
        min-height: 100vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        position: relative;
        overflow-x: hidden;
    }

    .rent-page::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.15) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(99, 102, 241, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 40% 40%, rgba(168, 85, 247, 0.08) 0%, transparent 50%);
        pointer-events: none;
        z-index: 1;
        animation: backgroundShift 20s ease-in-out infinite;
    }

    @keyframes backgroundShift {
        0%, 100% { opacity: 0.3; transform: scale(1) rotate(0deg); }
        50% { opacity: 0.6; transform: scale(1.1) rotate(0.5deg); }
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
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(120, 119, 198, 0.2) 0%, transparent 70%);
        filter: blur(60px);
        animation: headerGlow 8s ease-in-out infinite;
        z-index: -1;
    }

    @keyframes headerGlow {
        0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.5; }
        50% { transform: translate(-50%, -50%) scale(1.2); opacity: 0.8; }
    }

    .page-title {
        font-size: 3.5rem;
        font-weight: 900;
        background: linear-gradient(135deg, #ffffff 0%, #e5e7eb 25%, #ffffff 50%, #d1d5db 75%, #ffffff 100%);
        background-size: 200% 200%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1rem;
        letter-spacing: -0.05em;
        line-height: 1.1;
        opacity: 0;
        animation: titleReveal 1.2s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        text-shadow: 0 0 40px rgba(255, 255, 255, 0.1);
    }

    @keyframes titleReveal {
        0% {
            opacity: 0;
            transform: translateY(60px) scale(0.8);
            filter: blur(10px);
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
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
        opacity: 0;
        animation: subtitleReveal 1s ease-out 0.3s forwards;
        position: relative;
    }

    @keyframes subtitleReveal {
        0% {
            opacity: 0;
            transform: translateY(30px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .main-grid {
        display: grid;
        grid-template-columns: 420px 1fr;
        gap: 3rem;
        align-items: start;
    }

    /* Enhanced Form Panel */
    .form-panel {
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.02) 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        padding: 2.5rem;
        backdrop-filter: blur(20px);
        position: sticky;
        top: 2rem;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.3),
            0 0 0 1px rgba(255, 255, 255, 0.05),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
        opacity: 0;
        animation: panelSlide 1s cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.6s forwards;
        position: relative;
        overflow: hidden;
    }

    .form-panel::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    }

    .form-panel::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: conic-gradient(from 0deg, transparent, rgba(120, 119, 198, 0.1), transparent);
        animation: panelRotate 20s linear infinite;
        z-index: -1;
    }

    @keyframes panelRotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes panelSlide {
        0% {
            opacity: 0;
            transform: translateX(-40px) scale(0.95);
        }
        100% {
            opacity: 1;
            transform: translateX(0) scale(1);
        }
    }

    .form-panel:hover {
        border-color: rgba(255, 255, 255, 0.2);
        transform: translateY(-5px);
        box-shadow: 
            0 20px 50px rgba(0, 0, 0, 0.4),
            0 0 0 1px rgba(255, 255, 255, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.15);
    }

    .form-title {
        font-size: 1.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #ffffff, #e5e7eb);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 2rem;
        text-align: center;
        letter-spacing: -0.025em;
        position: relative;
    }

    .form-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 2px;
        background: linear-gradient(90deg, transparent, rgba(120, 119, 198, 0.6), transparent);
        border-radius: 2px;
    }

    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }

    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #d1d5db;
        margin-bottom: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        position: relative;
        padding-left: 12px;
    }

    .form-label::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 12px;
        background: linear-gradient(180deg, rgba(120, 119, 198, 0.8), rgba(99, 102, 241, 0.6));
        border-radius: 2px;
    }

    .form-input {
        width: 100%;
        padding: 1rem 1.25rem;
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0.04) 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        color: #ffffff;
        font-size: 0.925rem;
        font-weight: 500;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        backdrop-filter: blur(10px);
    }

    .form-input:focus {
        outline: none;
        border-color: rgba(120, 119, 198, 0.5);
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0.06) 100%);
        box-shadow: 
            0 0 0 3px rgba(120, 119, 198, 0.1),
            0 8px 25px rgba(0, 0, 0, 0.15),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
        transform: translateY(-1px);
    }

    .form-input::placeholder {
        color: #6b7280;
        font-weight: 400;
    }

    .form-input:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.03) 0%, rgba(255, 255, 255, 0.01) 100%);
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .btn-primary {
        width: 100%;
        padding: 1.25rem 1.5rem;
        background: linear-gradient(145deg, rgba(120, 119, 198, 0.9) 0%, rgba(99, 102, 241, 0.8) 50%, rgba(168, 85, 247, 0.9) 100%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.925rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        box-shadow: 
            0 8px 25px rgba(120, 119, 198, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.6s ease;
    }

    .btn-primary:hover::before {
        left: 100%;
    }

    .btn-primary:hover {
        background: linear-gradient(145deg, rgba(120, 119, 198, 1) 0%, rgba(99, 102, 241, 0.9) 50%, rgba(168, 85, 247, 1) 100%);
        border-color: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
        box-shadow: 
            0 15px 35px rgba(120, 119, 198, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }

    .btn-primary:active {
        transform: translateY(0);
        transition: transform 0.1s ease;
    }

    /* Enhanced Vehicles Section */
    .vehicles-section {
        opacity: 0;
        animation: sectionReveal 1s cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.8s forwards;
    }

    @keyframes sectionReveal {
        0% {
            opacity: 0;
            transform: translateX(40px) scale(0.95);
        }
        100% {
            opacity: 1;
            transform: translateX(0) scale(1);
        }
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding: 1.5rem 0;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff 0%, #e5e7eb 50%, #ffffff 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.025em;
        position: relative;
    }

    .vehicles-count {
        font-size: 0.875rem;
        color: #9ca3af;
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0.04) 100%);
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        font-weight: 600;
        letter-spacing: 0.05em;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .vehicles-container {
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.02) 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        padding: 2.5rem;
        backdrop-filter: blur(20px);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }

    .vehicles-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    }

    .vehicles-container:hover {
        border-color: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
        box-shadow: 
            0 20px 50px rgba(0, 0, 0, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.15);
    }

    .vehicles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 5rem 2rem;
        text-align: center;
        min-height: 400px;
        position: relative;
    }

    .empty-state::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(120, 119, 198, 0.1) 0%, transparent 70%);
        filter: blur(40px);
        animation: emptyGlow 6s ease-in-out infinite;
    }

    @keyframes emptyGlow {
        0%, 100% { opacity: 0.3; transform: translate(-50%, -50%) scale(1); }
        50% { opacity: 0.6; transform: translate(-50%, -50%) scale(1.2); }
    }

    .empty-icon {
        font-size: 5rem;
        opacity: 0.4;
        margin-bottom: 1.5rem;
        filter: drop-shadow(0 4px 15px rgba(0, 0, 0, 0.3));
        animation: emptyIconFloat 4s ease-in-out infinite;
    }

    @keyframes emptyIconFloat {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 1rem;
        letter-spacing: -0.025em;
    }

    .empty-description {
        color: #9ca3af;
        max-width: 450px;
        line-height: 1.7;
        font-size: 1rem;
    }

    .vehicle-card-wrapper {
        opacity: 0;
        animation: cardReveal 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }

    .vehicle-card-wrapper:nth-child(1) { animation-delay: 0.1s; }
    .vehicle-card-wrapper:nth-child(2) { animation-delay: 0.2s; }
    .vehicle-card-wrapper:nth-child(3) { animation-delay: 0.3s; }
    .vehicle-card-wrapper:nth-child(4) { animation-delay: 0.4s; }

    @keyframes cardReveal {
        0% {
            opacity: 0;
            transform: translateY(30px) scale(0.9);
            filter: blur(5px);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0);
        }
    }

    /* Premium Loading Effect */
    .loading-shimmer {
        background: linear-gradient(90deg, 
            rgba(255, 255, 255, 0.05) 25%, 
            rgba(255, 255, 255, 0.1) 50%, 
            rgba(255, 255, 255, 0.05) 75%);
        background-size: 200% 100%;
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .main-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .form-panel {
            position: relative;
            top: 0;
        }
        
        .container-modern {
            padding: 1rem;
        }
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 2.5rem;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .vehicles-grid {
            grid-template-columns: 1fr;
        }
        
        .section-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }
    }
</style>
@endpush

<div class="rent-page text-white">
    <div class="container-modern">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Alquiler Premium</h1>
            <p class="page-subtitle">
                Experimenta la excelencia en cada kilómetro con nuestra flota de vehículos premium cuidadosamente seleccionados
            </p>
        </div>

        <div class="main-grid">
    <!-- Booking Form -->
            <div class="form-panel">
                <h2 class="form-title">Configuración de Reserva</h2>

        <form wire:submit.prevent="filterAvailableVehicles" class="space-y-6">
                    <div class="form-group">
                        <label class="form-label">Ubicación de Recogida</label>
                        <input 
                            wire:model.debounce.500ms="pickupLocation" 
                            type="text"
                            placeholder="Ingrese su dirección preferida"
                            class="form-input"
                            required
                        />
                    </div>

                    <div class="form-group">
                        <label class="form-label">Punto de Devolución</label>
                        <input 
                            wire:model.debounce.500ms="dropoffLocation" 
                            type="text"
                            value="YuraiCars Central"
                            class="form-input"
                            readonly
                            disabled
                        />
                    </div>

                    <div class="form-group">
                        <label class="form-label">Fecha de Inicio</label>
                        <input 
                            wire:model.live="startTime" 
                            type="datetime-local"
                            class="form-input"
                            required
                        />
                    </div>

                    <div class="form-group">
                        <label class="form-label">Fecha de Finalización</label>
                        <input 
                            wire:model.live="endTime" 
                            type="datetime-local"
                            class="form-input"
                            required
                        />
            </div>

                    <div class="form-group">
                        <label class="form-label">Perfil del Conductor</label>
                        <select 
                            wire:model.live="ageRange"
                            class="form-input"
                            required
                        >
                            <option value="">Seleccione su rango de edad</option>
                            <option value="18-24">18-24 años</option>
                            <option value="25-34">25-34 años</option>
                            <option value="35-50">35-50 años</option>
                            <option value="50+">50+ años</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-primary">
                        Buscar Vehículos Disponibles
                    </button>
        </form>
    </div>

            <!-- Vehicles Section -->
            <div class="vehicles-section">
                <div class="section-header">
                    @if(!empty($availableVehicles) && count($availableVehicles) > 0)
                        <h2 class="section-title">Encontramos estos resultados para ti</h2>
                        <div class="vehicles-count">
                            {{ count($availableVehicles) }} vehículo{{ count($availableVehicles) !== 1 ? 's' : '' }} premium{{ count($availableVehicles) !== 1 ? 's' : '' }}
                        </div>
                    @elseif(isset($availableVehicles))
                        <h2 class="section-title">Resultados de Búsqueda</h2>
                    @else
                        <h2 class="section-title">Flota Disponible</h2>
                    @endif
                </div>

                <div class="vehicles-container">
                    @if(!empty($availableVehicles) && count($availableVehicles) > 0)
                        <div class="vehicles-grid">
                            @foreach ($availableVehicles as $index => $vehicle)
                                <div class="vehicle-card-wrapper" style="animation-delay: {{ ($index * 0.15) + 0.1 }}s;">
                    <livewire:vehicle-card :vehicle="$vehicle" />
                                </div>
                @endforeach
            </div>
                    @elseif(isset($availableVehicles) && empty($availableVehicles))
                        <div class="empty-state">
                            <div class="empty-icon">❌</div>
                            <h3 class="empty-title">No hay vehículos disponibles</h3>
                            <p class="empty-description">
                                No encontramos vehículos que coincidan con sus criterios de búsqueda. 
                                Por favor, intente ajustar las fechas o verifique la disponibilidad 
                                para otros períodos.
                            </p>
                        </div>
        @else
                        <div class="empty-state">
                            <div class="empty-icon">🔍</div>
                            <h3 class="empty-title">Preparando su Experiencia Premium</h3>
                            <p class="empty-description">
                                Configure sus preferencias de viaje para descubrir vehículos premium 
                                disponibles para sus fechas seleccionadas. Nuestro sistema inteligente 
                                encontrará las mejores opciones para usted.
                            </p>
                        </div>
        @endif
                </div>
            </div>
        </div>
    </div>
</div>
