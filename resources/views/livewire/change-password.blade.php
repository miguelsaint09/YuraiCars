@push('styles')
<style>
    .password-change-section {
        margin-top: 0;
    }

    .password-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0;
    }

    .password-info {
        flex: 1;
    }

    .password-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
    }

    .password-subtitle {
        color: #94a3b8;
        font-size: 0.9rem;
        font-weight: 500;
        margin: 0;
    }

    .btn-change-password {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.05) 0%, 
            rgba(255, 255, 255, 0.02) 100%);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #ffffff;
        padding: 0.8rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-transform: none;
        letter-spacing: 0;
    }

    .btn-change-password:hover {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.1) 0%, 
            rgba(255, 255, 255, 0.05) 100%);
        transform: translateY(-2px);
        border-color: rgba(255, 255, 255, 0.25);
    }

    .password-form {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.02) 0%, 
            rgba(255, 255, 255, 0.01) 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        padding: 2.5rem;
        margin-top: 1rem;
    }

    .password-form-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 2rem;
        letter-spacing: -0.02em;
    }

    .password-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
    }

    @media (max-width: 768px) {
        .password-header {
            flex-direction: column;
            align-items: stretch;
            gap: 1.5rem;
        }

        .password-info {
            text-align: center;
        }

        .btn-change-password {
            justify-content: center;
        }

        .password-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .btn {
            justify-content: center;
        }
    }
</style>
@endpush

<div class="password-change-section">
    @if (!$isChangingPassword)
        <div class="password-header">
            <div class="password-info">
                <h3 class="password-title">Cambio de Contraseña</h3>
                <p class="password-subtitle">Actualiza tu contraseña de manera segura</p>
            </div>
            <button wire:click="toggleChangePassword" class="btn btn-change-password">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v-2L4.257 10.257a6 6 0 018.486-8.486L16 5v2zm-2 10l1.5-1.5a6 6 0 002.121-4.243A6 6 0 1016.5 15.5z"></path>
                </svg>
                Cambiar Contraseña
            </button>
        </div>
    @else
        <div class="password-form">
            <h3 class="password-form-title">Cambiar Contraseña</h3>
            
            <div class="form-group">
                <label class="form-label">Contraseña Actual</label>
                <input 
                    type="password" 
                    wire:model="current_password" 
                    class="form-input" 
                    placeholder="Ingrese su contraseña actual"
                    required
                />
            </div>

            <div class="form-group">
                <label class="form-label">Nueva Contraseña</label>
                <input 
                    type="password" 
                    wire:model="password" 
                    class="form-input" 
                    placeholder="Ingrese nueva contraseña"
                    required
                />
            </div>

            <div class="form-group">
                <label class="form-label">Confirmar Nueva Contraseña</label>
                <input 
                    type="password" 
                    wire:model="password_confirmation" 
                    class="form-input" 
                    placeholder="Confirme la nueva contraseña"
                    required
                />
            </div>

            <div class="password-actions">
                <button wire:click="changePassword" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Actualizar Contraseña
                </button>
                <button wire:click="toggleChangePassword" class="btn btn-ghost">Cancelar</button>
            </div>
        </div>
    @endif
</div>