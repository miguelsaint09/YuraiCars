<x-layouts.app title="Registro">
@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

    /* Hide navbar and footer for auth pages */
    body nav,
    body footer {
        display: none !important;
    }

    body {
        background: linear-gradient(135deg, 
            #0a0a0a 0%, 
            #1a1a1a 25%, 
            #0f0f0f 50%, 
            #1a1a1a 75%, 
            #0a0a0a 100%) !important;
        min-height: 100vh;
        margin: 0;
        padding: 0;
    }

    .auth-page {
        background: radial-gradient(circle at 30% 20%, rgba(120, 119, 198, 0.08) 0%, transparent 50%),
                    radial-gradient(circle at 70% 80%, rgba(168, 85, 247, 0.06) 0%, transparent 50%),
                    radial-gradient(circle at 20% 70%, rgba(99, 102, 241, 0.04) 0%, transparent 50%),
                    linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 25%, #0f0f0f 50%, #1a1a1a 75%, #0a0a0a 100%);
        min-height: 100vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        position: relative;
        overflow-x: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .auth-container {
        width: 100%;
        max-width: 700px;
        position: relative;
        z-index: 2;
    }

    .auth-card {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.1) 0%, 
            rgba(255, 255, 255, 0.05) 50%, 
            rgba(255, 255, 255, 0.03) 100%);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 32px;
        padding: 4rem 5rem;
        backdrop-filter: blur(30px);
        box-shadow: 
            0 25px 80px rgba(0, 0, 0, 0.5),
            0 0 0 1px rgba(255, 255, 255, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.2),
            inset 0 -1px 0 rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
        opacity: 0;
        animation: cardMaterialize 1.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }

    @keyframes cardMaterialize {
        0% {
            opacity: 0;
            transform: translateY(80px) scale(0.85);
            filter: blur(15px);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0);
        }
    }

    .auth-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(34, 197, 94, 1), 
            rgba(16, 185, 129, 0.8), 
            rgba(5, 150, 105, 1), 
            transparent);
        filter: blur(1px);
        border-radius: 32px 32px 0 0;
    }

    .auth-logo {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2.5rem;
        opacity: 0;
        animation: logoReveal 1.2s ease-out 0.4s forwards;
    }

    @keyframes logoReveal {
        0% {
            opacity: 0;
            transform: translateY(30px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .auth-logo-icon {
        width: 3rem;
        height: 3rem;
        color: rgba(34, 197, 94, 0.9);
        filter: drop-shadow(0 0 20px rgba(34, 197, 94, 0.5));
    }

    .auth-logo-text {
        font-size: 2rem;
        font-weight: 900;
        background: linear-gradient(135deg, #ffffff 0%, #e5e7eb 30%, #ffffff 70%, #f3f4f6 100%);
        background-size: 300% 300%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.05em;
        animation: logoGradient 10s ease-in-out infinite;
    }

    @keyframes logoGradient {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .auth-title {
        font-size: 2.5rem;
        font-weight: 900;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 25%, #ffffff 50%, #e2e8f0 75%, #ffffff 100%);
        background-size: 300% 300%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-align: center;
        margin-bottom: 3rem;
        letter-spacing: -0.05em;
        line-height: 1.1;
        opacity: 0;
        animation: titleFloat 1.5s ease-out 0.6s forwards,
                   titleGradientShift 12s ease-in-out infinite;
    }

    @keyframes titleFloat {
        0% {
            opacity: 0;
            transform: translateY(40px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes titleGradientShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .separator {
        display: flex;
        align-items: center;
        margin: 2.5rem 0;
        opacity: 0;
        animation: separatorReveal 1s ease-out 0.8s forwards;
    }

    @keyframes separatorReveal {
        0% {
            opacity: 0;
            transform: scale(0.7);
        }
        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    .separator-line {
        flex: 1;
        height: 1px;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(255, 255, 255, 0.3), 
            transparent);
    }

    .separator-text {
        padding: 0 2rem;
        color: #cbd5e1;
        font-size: 0.95rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.15em;
    }

    .auth-form {
        opacity: 0;
        animation: formReveal 1.2s ease-out 1s forwards;
    }

    @keyframes formReveal {
        0% {
            opacity: 0;
            transform: translateY(30px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-group {
        margin-bottom: 1.8rem;
        position: relative;
    }

    .form-label {
        display: block;
        font-size: 0.95rem;
        font-weight: 800;
        color: #f1f5f9;
        margin-bottom: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        position: relative;
        padding-left: 16px;
    }

    .form-label::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 16px;
        background: linear-gradient(180deg, 
            rgba(34, 197, 94, 1), 
            rgba(16, 185, 129, 0.8));
        border-radius: 3px;
        box-shadow: 0 0 12px rgba(34, 197, 94, 0.6);
    }

    .form-input {
        width: 100%;
        padding: 1.3rem 1.8rem;
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.1) 0%, 
            rgba(255, 255, 255, 0.05) 100%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        color: #ffffff;
        font-size: 1.05rem;
        font-weight: 500;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        backdrop-filter: blur(20px);
        box-shadow: 
            0 6px 20px rgba(0, 0, 0, 0.25),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
        outline: none;
    }

    .form-input:focus {
        border-color: rgba(34, 197, 94, 0.7);
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.15) 0%, 
            rgba(255, 255, 255, 0.08) 100%);
        box-shadow: 
            0 0 0 4px rgba(34, 197, 94, 0.2),
            0 10px 35px rgba(0, 0, 0, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.15);
        transform: translateY(-3px);
    }

    .form-input::placeholder {
        color: #cbd5e1;
        font-weight: 400;
    }

    .submit-button {
        width: 100%;
        padding: 1.4rem 2.5rem;
        background: linear-gradient(145deg, 
            rgba(34, 197, 94, 1) 0%, 
            rgba(16, 185, 129, 0.9) 50%, 
            rgba(5, 150, 105, 1) 100%);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 18px;
        color: #ffffff;
        font-weight: 900;
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        cursor: pointer;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        margin: 2.5rem 0 2rem 0;
        box-shadow: 
            0 15px 45px rgba(34, 197, 94, 0.5),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }

    .submit-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(255, 255, 255, 0.4), 
            transparent);
        transition: left 0.8s ease;
    }

    .submit-button:hover::before {
        left: 100%;
    }

    .submit-button:hover {
        background: linear-gradient(145deg, 
            rgba(34, 197, 94, 1) 0%, 
            rgba(16, 185, 129, 1) 50%, 
            rgba(5, 150, 105, 1) 100%);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-4px);
        box-shadow: 
            0 25px 60px rgba(34, 197, 94, 0.7),
            inset 0 1px 0 rgba(255, 255, 255, 0.4);
    }

    .auth-footer {
        text-align: center;
        color: #cbd5e1;
        font-size: 1rem;
        font-weight: 500;
        opacity: 0;
        animation: footerReveal 1s ease-out 1.4s forwards;
    }

    @keyframes footerReveal {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .auth-footer a {
        color: rgba(34, 197, 94, 1);
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .auth-footer a:hover {
        color: rgba(16, 185, 129, 1);
        text-shadow: 0 0 15px rgba(34, 197, 94, 0.6);
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 1.8rem;
    }

    .password-strength {
        margin-top: 0.6rem;
        display: flex;
        gap: 3px;
    }

    .strength-bar {
        height: 4px;
        flex: 1;
        border-radius: 3px;
        background: rgba(255, 255, 255, 0.1);
        transition: all 0.4s ease;
    }

    .strength-bar.active-weak {
        background: linear-gradient(90deg, #ef4444, #f87171);
        box-shadow: 0 0 10px rgba(239, 68, 68, 0.5);
    }

    .strength-bar.active-medium {
        background: linear-gradient(90deg, #f59e0b, #fbbf24);
        box-shadow: 0 0 10px rgba(245, 158, 11, 0.5);
    }

    .strength-bar.active-strong {
        background: linear-gradient(90deg, #10b981, #34d399);
        box-shadow: 0 0 10px rgba(16, 185, 129, 0.5);
    }

    .terms-text {
        font-size: 0.9rem;
        color: #cbd5e1;
        line-height: 1.6;
        margin-bottom: 2rem;
        text-align: center;
        opacity: 0.9;
    }

    .terms-text a {
        color: rgba(34, 197, 94, 1);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .terms-text a:hover {
        color: rgba(16, 185, 129, 1);
        text-shadow: 0 0 10px rgba(34, 197, 94, 0.5);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .auth-page {
            padding: 1rem;
        }
        
        .auth-container {
            max-width: 450px;
        }
        
        .auth-card {
            padding: 2.5rem;
        }
        
        .auth-title {
            font-size: 2rem;
        }

        .form-grid {
            grid-template-columns: 1fr;
            gap: 0;
        }
    }

    @media (max-width: 480px) {
        .auth-card {
            padding: 2rem;
        }
        
        .auth-title {
            font-size: 1.875rem;
        }
        
        .form-input {
            padding: 1.1rem 1.5rem;
        }
    }
</style>
@endpush

<div class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-logo">
                <svg class="auth-logo-icon" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.5 7c0 .6-.4 1-1 1h-1c0 1.1-.9 2-2 2s-2-.9-2-2H6c0 1.1-.9 2-2 2s-2-.9-2-2H1c-.6 0-1-.4-1-1s.4-1 1-1h1c0-1.1.9-2 2-2s2 .9 2 2h11.5c0-1.1.9-2 2-2s2 .9 2 2h1c.6 0 1 .4 1 1zM20 13v5c0 1.1-.9 2-2 2H6c-1.1 0-2-.9-2-2v-5h16zM8 15H6v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2z"/>
                </svg>
                <span class="auth-logo-text">YuraiCars</span>
            </div>

            <h1 class="auth-title">Registra tu Cuenta</h1>

            @if (session('success'))
                <div style="background: linear-gradient(145deg, rgba(34, 197, 94, 0.1), rgba(16, 185, 129, 0.05)); border: 1px solid rgba(34, 197, 94, 0.3); border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem; color: #10b981; font-weight: 500; text-align: center;">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="background: linear-gradient(145deg, rgba(239, 68, 68, 0.1), rgba(248, 113, 113, 0.05)); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem; color: #ef4444; font-weight: 500; text-align: center;">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <div class="separator">
                <div class="separator-line"></div>
                <span class="separator-text">Únete a nosotros</span>
                <div class="separator-line"></div>
            </div>

            <form action="{{ route('register.store') }}" method="POST" class="auth-form">
                    @csrf

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nombre</label>
                        <input 
                            name="first_name" 
                            type="text" 
                            placeholder="Tu nombre" 
                            value="{{ old('first_name') }}"
                            class="form-input"
                            required
                        />
                        @error('first_name')
                            <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Apellido</label>
                        <input 
                            name="last_name" 
                            type="text" 
                            placeholder="Tus apellidos" 
                            value="{{ old('last_name') }}"
                            class="form-input"
                        />
                        @error('last_name')
                            <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Correo Electrónico</label>
                    <input 
                        name="email" 
                        type="email" 
                        placeholder="correo@ejemplo.com" 
                        value="{{ old('email') }}"
                        class="form-input"
                        required
                    />
                    @error('email')
                        <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <input 
                        name="password" 
                        type="password" 
                        placeholder="Crea una contraseña segura"
                        class="form-input"
                        required
                        id="password-input"
                    />
                    <div class="password-strength" id="password-strength">
                        <div class="strength-bar"></div>
                        <div class="strength-bar"></div>
                        <div class="strength-bar"></div>
                        <div class="strength-bar"></div>
                    </div>
                    @error('password')
                        <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Confirmar Contraseña</label>
                    <input 
                        name="password_confirmation" 
                        type="password" 
                        placeholder="Confirma tu contraseña"
                        class="form-input"
                        required
                    />
                    @error('password_confirmation')
                        <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="terms-text">
                    Al registrarte, aceptas nuestros 
                    <a href="#" onclick="return false;">Términos de Servicio</a> 
                    y 
                    <a href="#" onclick="return false;">Política de Privacidad</a>
                        </div>

                <button type="submit" class="submit-button">
                    Crear Cuenta Premium
                </button>
                </form>
    
            <div class="auth-footer">
                ¿Ya tienes una cuenta? <a href="{{ route('login') }}">Iniciar Sesión</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password-input');
    const strengthBars = document.querySelectorAll('.strength-bar');

    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = calculatePasswordStrength(password);
            
            // Reset all bars
            strengthBars.forEach(bar => {
                bar.classList.remove('active-weak', 'active-medium', 'active-strong');
            });
            
            // Apply strength classes
            for (let i = 0; i < strength; i++) {
                if (strength <= 1) {
                    strengthBars[i].classList.add('active-weak');
                } else if (strength <= 2) {
                    strengthBars[i].classList.add('active-medium');
                } else {
                    strengthBars[i].classList.add('active-strong');
                }
            }
        });
    }

    function calculatePasswordStrength(password) {
        let strength = 0;
        if (password.length >= 6) strength++;
        if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
        if (password.match(/\d/)) strength++;
        if (password.match(/[^a-zA-Z\d]/)) strength++;
        return strength;
    }
});
</script>
@endpush
</x-layouts.app>