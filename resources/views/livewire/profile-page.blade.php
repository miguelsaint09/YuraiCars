@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .profile-page {
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

    .profile-page::before {
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

    .profile-container {
        position: relative;
        z-index: 2;
        max-width: 1400px;
        margin: 0 auto;
        padding: 1.5rem;
        opacity: 0;
        animation: containerReveal 1.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }

    @media (min-width: 640px) {
        .profile-container {
            padding: 3rem 2rem;
        }
    }

    .profile-card {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.02) 0%, 
            rgba(255, 255, 255, 0.01) 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        padding: 1.5rem;
        backdrop-filter: blur(20px);
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.3),
            0 0 0 1px rgba(255, 255, 255, 0.05),
            inset 0 1px 0 rgba(255, 255, 255, 0.08);
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        opacity: 0;
        animation: cardMaterialize 1.2s cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.3s forwards;
    }

    @media (min-width: 640px) {
        .profile-card {
            padding: 3rem;
            border-radius: 32px;
        }
    }

    .profile-grid {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .profile-header {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    @media (min-width: 768px) {
        .profile-header {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 4rem;
            align-items: start;
        }
    }

    .profile-sidebar {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 1rem;
        opacity: 0;
        animation: slideInLeft 1s ease-out 0.6s forwards;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.1) 0%, 
            rgba(255, 255, 255, 0.05) 100%);
        border: 2px solid rgba(255, 255, 255, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 900;
        color: #ffffff;
        margin: 0 auto;
        box-shadow: 
            0 15px 40px rgba(0, 0, 0, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
    }

    .profile-avatar::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, 
            rgba(120, 119, 198, 0.2), 
            rgba(168, 85, 247, 0.1), 
            rgba(99, 102, 241, 0.2));
        border-radius: 50%;
        z-index: -1;
    }

    .profile-avatar:hover {
        transform: translateY(-8px) scale(1.05);
        box-shadow: 
            0 25px 60px rgba(0, 0, 0, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }

    @media (min-width: 640px) {
        .profile-avatar {
            width: 140px;
            height: 140px;
            font-size: 2.5rem;
        }
    }

    .profile-name {
        font-size: 1.5rem;
        font-weight: 800;
        color: #ffffff;
        margin-top: 1rem;
        margin-bottom: 0.5rem;
    }

    @media (min-width: 640px) {
        .profile-name {
            font-size: 1.75rem;
            margin-top: 1.5rem;
        }
    }

    .profile-email {
        color: #94a3b8;
        font-size: 0.875rem;
        font-weight: 500;
    }

    @media (min-width: 640px) {
        .profile-email {
            font-size: 1rem;
        }
    }

    .profile-info {
        flex: 1;
        opacity: 0;
        animation: slideInRight 1s ease-out 0.8s forwards;
    }

    .profile-title {
        font-size: 1.75rem;
        font-weight: 900;
        color: #ffffff;
        margin-bottom: 1.5rem;
        letter-spacing: -0.03em;
    }

    @media (min-width: 640px) {
        .profile-title {
            font-size: 2rem;
            margin-bottom: 2rem;
        }
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    @media (min-width: 640px) {
        .form-group {
            margin-bottom: 2rem;
        }
    }

    .form-label {
        display: block;
        color: #e2e8f0;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        letter-spacing: 0.025em;
        text-transform: uppercase;
    }

    .form-input {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.03) 0%, 
            rgba(255, 255, 255, 0.01) 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        color: #ffffff;
        font-size: 0.875rem;
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

    .form-input:read-only {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.01) 0%, 
            rgba(255, 255, 255, 0.005) 100%);
        border-color: rgba(255, 255, 255, 0.05);
        color: #94a3b8;
        cursor: not-allowed;
    }

    .form-input::placeholder {
        color: #64748b;
        font-weight: 400;
    }

    .button-group {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    @media (min-width: 640px) {
        .btn {
            padding: 1rem 2rem;
            font-size: 1rem;
        }
    }

    .btn svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    .btn-primary {
        background: linear-gradient(145deg, 
            rgba(120, 119, 198, 0.8) 0%, 
            rgba(99, 102, 241, 0.7) 100%);
        border: none;
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
        color: #94a3b8;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .btn-ghost:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    .btn-subtle {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border: none;
    }

    .btn-subtle:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
    }

    .password-section {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .status-message {
        padding: 1rem;
        border-radius: 12px;
        font-weight: 500;
        margin-bottom: 1.5rem;
        backdrop-filter: blur(15px);
        border: 1px solid;
        animation: messageSlideDown 0.5s ease-out forwards;
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

    @media (min-width: 640px) {
        .status-message {
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
        }
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

    @keyframes cardMaterialize {
        0% {
            opacity: 0;
            transform: translateY(40px) scale(0.95);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
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

    @keyframes messageSlideDown {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

<div class="profile-page">
    <div class="profile-container">
        <div class="profile-card">
            <div class="profile-grid">
                <div class="profile-header">
                    <!-- Left: Profile Sidebar -->
                    <div class="profile-sidebar">
                        <!-- Profile Avatar -->
                        <div class="profile-avatar">
                            {{ strtoupper(substr($first_name, 0, 1) . substr($last_name, 0, 1)) ?: 'U' }}
                        </div>
                        <div class="profile-name">
                            {{ $first_name ? "$first_name $last_name" : '¡Bienvenido!' }}
                        </div>
                        <div class="profile-email">{{ $user->email }}</div>
                    </div>

                    <!-- Right: Profile Info -->
                    <div class="profile-info">
                        <h1 class="profile-title">Información del Perfil</h1>

                        @if($showCompletionMessage)
                            <div class="status-message" style="background: linear-gradient(145deg, rgba(59, 130, 246, 0.1), rgba(37, 99, 235, 0.05)); border: 1px solid rgba(59, 130, 246, 0.3); color: #3b82f6; margin-bottom: 2rem; text-align: left; display: flex; align-items: center; gap: 1rem;">
                                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="font-medium">Por favor, complete su información personal</p>
                                    <p class="text-sm opacity-80 mt-1">Necesitamos estos datos para procesar su reserva de manera segura.</p>
                                </div>
                            </div>
                        @endif

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

                        <!-- Profile Form -->
                        <form wire:submit.prevent="saveProfile" class="form-container">
                            <div class="form-group">
                                <label class="form-label">Nombre</label>
                                <input 
                                    type="text" 
                                    wire:model="first_name" 
                                    class="form-input" 
                                    placeholder="Ingrese su nombre"
                                    {{ !$isEditing ? 'readonly' : '' }}
                                />
                                @error('first_name')
                                    <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Apellido</label>
                                <input 
                                    type="text" 
                                    wire:model="last_name" 
                                    class="form-input" 
                                    placeholder="Ingrese su apellido"
                                    {{ !$isEditing ? 'readonly' : '' }}
                                />
                                @error('last_name')
                                    <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Teléfono</label>
                                <input 
                                    type="tel" 
                                    wire:model="phone" 
                                    class="form-input" 
                                    placeholder="Ingrese su teléfono"
                                    {{ !$isEditing ? 'readonly' : '' }}
                                />
                                @error('phone')
                                    <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Número de Licencia</label>
                                <input 
                                    type="text" 
                                    wire:model="license_number" 
                                    class="form-input" 
                                    placeholder="Ingrese su número de licencia"
                                    {{ !$isEditing ? 'readonly' : '' }}
                                />
                                @error('license_number')
                                    <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Fecha de Nacimiento</label>
                                <input 
                                    type="date" 
                                    wire:model="date_of_birth" 
                                    class="form-input"
                                    {{ !$isEditing ? 'readonly' : '' }}
                                    max="{{ now()->subYears(18)->format('Y-m-d') }}"
                                    min="{{ now()->subYears(100)->format('Y-m-d') }}"
                                />
                                <div style="color: #94a3b8; font-size: 0.875rem; margin-top: 0.5rem;">Debes tener al menos 18 años para registrarte</div>
                                @error('date_of_birth')
                                    <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="button-group">
                                @if ($isEditing)
                                    <button type="submit" class="btn btn-primary">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Guardar
                                    </button>
                                    <button type="button" wire:click="toggleEdit" class="btn btn-ghost">Cancelar</button>
                                @else
                                    <button type="button" wire:click="toggleEdit" class="btn btn-subtle">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Editar Perfil
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Password Change Section -->
                <div class="password-section">
                    <livewire:change-password />
                </div>
            </div>
        </div>
    </div>
</div>

@script
document.addEventListener('livewire:initialized', () => {
    Livewire.on('redirect-to', ({ url }) => {
        window.location.href = url;
    });
});
@endscript