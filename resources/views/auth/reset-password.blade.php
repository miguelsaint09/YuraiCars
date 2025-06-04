<x-layouts.app title="Restablecer Contraseña">
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
        max-width: 550px;
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
        padding: 3rem 4rem;
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
            rgba(245, 158, 11, 1), 
            rgba(251, 191, 36, 0.8), 
            rgba(245, 158, 11, 1), 
            transparent);
        filter: blur(1px);
        border-radius: 32px 32px 0 0;
    }

    .auth-logo {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
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
        width: 2.5rem;
        height: 2.5rem;
        color: rgba(245, 158, 11, 0.9);
        filter: drop-shadow(0 0 20px rgba(245, 158, 11, 0.5));
    }

    .auth-logo-text {
        font-size: 1.75rem;
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
        font-size: 2rem;
        font-weight: 900;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 25%, #ffffff 50%, #e2e8f0 75%, #ffffff 100%);
        background-size: 300% 300%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-align: center;
        margin-bottom: 0.75rem;
        letter-spacing: -0.05em;
        line-height: 1.1;
        opacity: 0;
        animation: titleFloat 1.5s ease-out 0.6s forwards,
                   titleGradientShift 12s ease-in-out infinite;
    }

    @keyframes titleFloat {
        0% {
            opacity: 0;
            transform: translateY(30px);
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

    .auth-subtitle {
        text-align: center;
        color: #cbd5e1;
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 2.5rem;
        opacity: 0.9;
        opacity: 0;
        animation: titleFloat 1.5s ease-out 0.8s forwards;
    }

    .form-input {
        width: 100%;
        padding: 1.2rem 1.5rem;
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.1) 0%, 
            rgba(255, 255, 255, 0.05) 100%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        color: #ffffff;
        font-size: 1rem;
        font-weight: 500;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        backdrop-filter: blur(20px);
        box-shadow: 
            0 6px 20px rgba(0, 0, 0, 0.25),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
        outline: none;
        margin-bottom: 1.75rem;
    }

    .form-input:focus {
        border-color: rgba(245, 158, 11, 0.7);
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.15) 0%, 
            rgba(255, 255, 255, 0.08) 100%);
        box-shadow: 
            0 0 0 4px rgba(245, 158, 11, 0.2),
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
        padding: 1.3rem 2rem;
        background: linear-gradient(145deg, 
            rgba(245, 158, 11, 1) 0%, 
            rgba(251, 191, 36, 0.9) 50%, 
            rgba(245, 158, 11, 1) 100%);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 18px;
        color: #ffffff;
        font-weight: 900;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        cursor: pointer;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: 
            0 15px 45px rgba(245, 158, 11, 0.5),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }

    .submit-button:hover {
        background: linear-gradient(145deg, 
            rgba(245, 158, 11, 1) 0%, 
            rgba(251, 191, 36, 1) 50%, 
            rgba(245, 158, 11, 1) 100%);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-4px);
        box-shadow: 
            0 25px 60px rgba(245, 158, 11, 0.7),
            inset 0 1px 0 rgba(255, 255, 255, 0.4);
    }

    .auth-footer {
        text-align: center;
        color: #cbd5e1;
        font-size: 1rem;
        font-weight: 500;
    }

    .auth-footer a {
        color: rgba(245, 158, 11, 1);
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .auth-footer a:hover {
        color: rgba(251, 191, 36, 1);
        text-shadow: 0 0 15px rgba(245, 158, 11, 0.6);
    }

    @media (max-width: 768px) {
        .auth-page {
            padding: 1rem;
        }
        
        .auth-container {
            max-width: 450px;
        }
        
        .auth-card {
            padding: 2.5rem 2rem;
        }
        
        .auth-title {
            font-size: 1.875rem;
        }

        .auth-subtitle {
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        .form-input {
            padding: 1.1rem 1.25rem;
            margin-bottom: 1.5rem;
        }

        .submit-button {
            padding: 1.2rem 1.75rem;
            font-size: 0.95rem;
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

            <h1 class="auth-title">Nueva Contraseña</h1>
            <p class="auth-subtitle">
                Ingresa tu nueva contraseña para restablecer el acceso a tu cuenta.
            </p>

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

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">
                
                <input 
                    name="password" 
                    type="password" 
                    placeholder="Nueva Contraseña" 
                    class="form-input"
                    required
                />

                <input 
                    name="password_confirmation" 
                    type="password" 
                    placeholder="Confirmar Nueva Contraseña" 
                    class="form-input"
                    required
                />

                <button type="submit" class="submit-button">
                    Restablecer Contraseña
                </button>
            </form>

            <div class="auth-footer">
                ¿Ya tienes acceso? <a href="{{ route('login') }}">Iniciar Sesión</a>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>
