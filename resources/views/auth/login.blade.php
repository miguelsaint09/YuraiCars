<x-layouts.app title="Iniciar Sesión">
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
        max-width: 650px;
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
            rgba(120, 119, 198, 1), 
            rgba(168, 85, 247, 0.8), 
            rgba(99, 102, 241, 1), 
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
        color: rgba(120, 119, 198, 0.9);
        filter: drop-shadow(0 0 20px rgba(120, 119, 198, 0.5));
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

    .google-button {
        width: 100%;
        padding: 1.3rem 1.8rem;
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0.06) 100%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 18px;
        color: #ffffff;
        font-weight: 600;
        font-size: 1.05rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        margin-bottom: 2.5rem;
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(20px);
        box-shadow: 
            0 10px 30px rgba(0, 0, 0, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
        cursor: pointer;
        opacity: 0;
        animation: buttonReveal 1s ease-out 0.8s forwards;
    }

    @keyframes buttonReveal {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .google-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(255, 255, 255, 0.15), 
            transparent);
        transition: left 0.8s ease;
    }

    .google-button:hover::before {
        left: 100%;
    }

    .google-button:hover {
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.18) 0%, rgba(255, 255, 255, 0.1) 100%);
        border-color: rgba(255, 255, 255, 0.3);
        transform: translateY(-3px);
        box-shadow: 
            0 15px 40px rgba(0, 0, 0, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    .separator {
        display: flex;
        align-items: center;
        margin: 2.5rem 0;
        opacity: 0;
        animation: separatorReveal 1s ease-out 1s forwards;
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
        animation: formReveal 1.2s ease-out 1.2s forwards;
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
            rgba(120, 119, 198, 1), 
            rgba(168, 85, 247, 0.8));
        border-radius: 3px;
        box-shadow: 0 0 12px rgba(120, 119, 198, 0.6);
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
        border-color: rgba(120, 119, 198, 0.7);
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.15) 0%, 
            rgba(255, 255, 255, 0.08) 100%);
        box-shadow: 
            0 0 0 4px rgba(120, 119, 198, 0.2),
            0 10px 35px rgba(0, 0, 0, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.15);
        transform: translateY(-3px);
    }

    .form-input::placeholder {
        color: #cbd5e1;
        font-weight: 400;
    }

    .forgot-password {
        color: #e2e8f0;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
    }

    .forgot-password:hover {
        color: rgba(120, 119, 198, 1);
        text-shadow: 0 0 12px rgba(120, 119, 198, 0.6);
    }

    .checkbox-container {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 2rem 0;
    }

    .checkbox {
        width: 1.4rem;
        height: 1.4rem;
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.1) 0%, 
            rgba(255, 255, 255, 0.05) 100%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        position: relative;
        cursor: pointer;
        transition: all 0.4s ease;
    }

    .checkbox:checked {
        background: linear-gradient(145deg, 
            rgba(120, 119, 198, 1) 0%, 
            rgba(168, 85, 247, 0.8) 100%);
        border-color: rgba(120, 119, 198, 0.8);
        box-shadow: 0 0 20px rgba(120, 119, 198, 0.5);
    }

    .checkbox-label {
        color: #e2e8f0;
        font-size: 0.95rem;
        font-weight: 500;
        cursor: pointer;
    }

    .submit-button {
        width: 100%;
        padding: 1.4rem 2.5rem;
        background: linear-gradient(145deg, 
            rgba(120, 119, 198, 1) 0%, 
            rgba(168, 85, 247, 0.9) 50%, 
            rgba(99, 102, 241, 1) 100%);
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
            0 15px 45px rgba(120, 119, 198, 0.5),
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
            rgba(120, 119, 198, 1) 0%, 
            rgba(168, 85, 247, 1) 50%, 
            rgba(99, 102, 241, 1) 100%);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-4px);
        box-shadow: 
            0 25px 60px rgba(120, 119, 198, 0.7),
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
        color: rgba(120, 119, 198, 1);
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .auth-footer a:hover {
        color: rgba(168, 85, 247, 1);
        text-shadow: 0 0 15px rgba(120, 119, 198, 0.6);
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

            <h1 class="auth-title">¡Bienvenido de nuevo!</h1>

            @if (session('success'))
                <div style="background: linear-gradient(145deg, rgba(34, 197, 94, 0.1), rgba(16, 185, 129, 0.05)); border: 1px solid rgba(34, 197, 94, 0.3); border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem; color: #10b981; font-weight: 500; text-align: center;">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="background: linear-gradient(145deg, rgba(239, 68, 68, 0.1), rgba(248, 113, 113, 0.05)); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem; color: #ef4444; font-weight: 500; text-align: center;">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            <button class="google-button">
                <svg width="24" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M23.06 12.25C23.06 11.47 22.99 10.72 22.86 10H12.5V14.26H18.42C18.16 15.63 17.38 16.79 16.21 17.57V20.34H19.78C21.86 18.42 23.06 15.6 23.06 12.25Z" fill="#4285F4"/>
                                <path d="M12.4997 23C15.4697 23 17.9597 22.02 19.7797 20.34L16.2097 17.57C15.2297 18.23 13.9797 18.63 12.4997 18.63C9.63969 18.63 7.20969 16.7 6.33969 14.1H2.67969V16.94C4.48969 20.53 8.19969 23 12.4997 23Z" fill="#34A853"/>
                                <path d="M6.34 14.0899C6.12 13.4299 5.99 12.7299 5.99 11.9999C5.99 11.2699 6.12 10.5699 6.34 9.90995V7.06995H2.68C1.93 8.54995 1.5 10.2199 1.5 11.9999C1.5 13.7799 1.93 15.4499 2.68 16.9299L5.53 14.7099L6.34 14.0899Z" fill="#FBBC05"/>
                                <path d="M12.4997 5.38C14.1197 5.38 15.5597 5.94 16.7097 7.02L19.8597 3.87C17.9497 2.09 15.4697 1 12.4997 1C8.19969 1 4.48969 3.47 2.67969 7.07L6.33969 9.91C7.20969 7.31 9.63969 5.38 12.4997 5.38Z" fill="#EA4335"/>
                            </svg>
                        Continuar con Google
            </button>

            <div class="separator">
                <div class="separator-line"></div>
                <span class="separator-text">o</span>
                <div class="separator-line"></div>
            </div>

            <form action="{{ route('login.store') }}" method="POST" class="auth-form">
                @csrf

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
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                        <label class="form-label" style="margin-bottom: 0;">Contraseña</label>
                        <a href="{{ route('password.request') }}" class="forgot-password">¿Olvidaste tu contraseña?</a>
                    </div>
                    <input 
                        name="password" 
                        type="password" 
                        placeholder="Tu contraseña"
                        class="form-input"
                        required
                    />
                    @error('password')
                        <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="checkbox-container">
                    <input type="checkbox" name="remember" id="remember" class="checkbox" />
                    <label for="remember" class="checkbox-label">Recuérdame por 30 días</label>
                        </div>

                <button type="submit" class="submit-button">
                    Iniciar Sesión Premium
                </button>
                </form>

            <div class="auth-footer">
                ¿Primera vez aquí? <a href="{{ route('register') }}">Regístrate gratis</a>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>