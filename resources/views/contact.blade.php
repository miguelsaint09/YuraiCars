<x-layouts.app title="Contacto - YuraiCars">
@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

    .contact-page {
        background: radial-gradient(circle at 25% 40%, rgba(99, 102, 241, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 75% 60%, rgba(168, 85, 247, 0.08) 0%, transparent 50%),
                    radial-gradient(circle at 45% 20%, rgba(120, 119, 198, 0.06) 0%, transparent 50%),
                    linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 25%, #0f0f0f 50%, #1a1a1a 75%, #0a0a0a 100%);
        min-height: 100vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        color: #ffffff;
        position: relative;
        overflow-x: hidden;
    }

    .contact-page::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            radial-gradient(circle at 35% 30%, rgba(99, 102, 241, 0.12) 0%, transparent 60%),
            radial-gradient(circle at 65% 70%, rgba(168, 85, 247, 0.15) 0%, transparent 60%),
            radial-gradient(circle at 15% 80%, rgba(120, 119, 198, 0.08) 0%, transparent 60%);
        pointer-events: none;
        z-index: 1;
        animation: atmosphericFlow 30s ease-in-out infinite;
    }

    @keyframes atmosphericFlow {
        0%, 100% { opacity: 0.4; transform: scale(1) rotate(0deg); }
        25% { opacity: 0.7; transform: scale(1.05) rotate(0.25deg); }
        50% { opacity: 0.5; transform: scale(1.1) rotate(-0.25deg); }
        75% { opacity: 0.8; transform: scale(1.05) rotate(0.5deg); }
    }

    .container-modern {
        max-width: 1200px;
        margin: 0 auto;
        padding: 4rem 2rem;
        position: relative;
        z-index: 2;
    }

    .hero-section {
        text-align: center;
        margin-bottom: 4rem;
        padding: 4rem 0;
        position: relative;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, 
            rgba(99, 102, 241, 0.15) 0%, 
            rgba(168, 85, 247, 0.1) 40%, 
            transparent 70%);
        filter: blur(100px);
        animation: heroAura 12s ease-in-out infinite;
        z-index: -1;
    }

    @keyframes heroAura {
        0%, 100% { 
            transform: translate(-50%, -50%) scale(1); 
            opacity: 0.6; 
        }
        50% { 
            transform: translate(-50%, -50%) scale(1.4); 
            opacity: 0.9; 
        }
    }

    .hero-title {
        font-size: 4.5rem;
        font-weight: 900;
        background: linear-gradient(135deg, 
            #ffffff 0%, 
            #f3f4f6 15%, 
            #ffffff 30%, 
            #e5e7eb 45%, 
            #ffffff 60%, 
            #d1d5db 75%, 
            #ffffff 90%, 
            #f9fafb 100%);
        background-size: 400% 400%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1.5rem;
        letter-spacing: -0.08em;
        line-height: 1.05;
        opacity: 0;
        animation: titleCinematic 1.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards,
                   titleGradientFlow 10s ease-in-out infinite;
        text-shadow: 0 0 60px rgba(255, 255, 255, 0.2);
    }

    @keyframes titleCinematic {
        0% {
            opacity: 0;
            transform: translateY(100px) scale(0.6) rotateX(15deg);
            filter: blur(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1) rotateX(0deg);
            filter: blur(0);
        }
    }

    @keyframes titleGradientFlow {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .hero-subtitle {
        font-size: 1.4rem;
        color: #d1d5db;
        font-weight: 500;
        max-width: 700px;
        margin: 0 auto 4rem;
        line-height: 1.7;
        opacity: 0;
        animation: subtitleEmerge 1.4s ease-out 0.5s forwards;
        position: relative;
        letter-spacing: 0.02em;
    }

    @keyframes subtitleEmerge {
        0% {
            opacity: 0;
            transform: translateY(50px);
            filter: blur(5px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
            filter: blur(0);
        }
    }

    .contact-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2.5rem;
        margin: 4rem 0;
    }

    .contact-card {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.08) 0%, 
            rgba(255, 255, 255, 0.04) 50%, 
            rgba(255, 255, 255, 0.02) 100%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 24px;
        padding: 3rem;
        text-align: center;
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        backdrop-filter: blur(20px);
        box-shadow: 
            0 12px 45px rgba(0, 0, 0, 0.4),
            0 0 0 1px rgba(255, 255, 255, 0.06),
            inset 0 1px 0 rgba(255, 255, 255, 0.15),
            inset 0 -1px 0 rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .contact-card:hover {
        transform: translateY(-8px);
        border-color: rgba(255, 255, 255, 0.2);
        box-shadow: 
            0 25px 70px rgba(0, 0, 0, 0.5),
            0 0 0 1px rgba(255, 255, 255, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.2),
            inset 0 -1px 0 rgba(0, 0, 0, 0.1);
    }

    .contact-icon {
        font-size: 2.5rem;
        margin-bottom: 1.5rem;
        color: #ffffff;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .contact-icon img {
        transition: transform 0.3s ease;
    }

    .contact-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 1rem;
    }

    .contact-info {
        color: #d1d5db;
        font-size: 1.1rem;
        line-height: 1.6;
    }

    .contact-form {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.08) 0%, 
            rgba(255, 255, 255, 0.04) 50%, 
            rgba(255, 255, 255, 0.02) 100%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 28px;
        padding: 4rem;
        backdrop-filter: blur(25px);
        margin-top: 4rem;
        box-shadow: 
            0 15px 50px rgba(0, 0, 0, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.15),
            inset 0 -1px 0 rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 2rem;
    }

    .form-label {
        display: block;
        color: #ffffff;
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .form-input {
        width: 100%;
        padding: 1rem 1.5rem;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        color: #ffffff;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: rgba(99, 102, 241, 0.5);
        background: rgba(255, 255, 255, 0.08);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
    }

    .form-textarea {
        min-height: 150px;
        resize: vertical;
    }

    .submit-button {
        background: linear-gradient(145deg, 
            rgba(99, 102, 241, 0.9) 0%, 
            rgba(168, 85, 247, 0.8) 50%, 
            rgba(120, 119, 198, 0.9) 100%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        padding: 1rem 2.5rem;
        color: #ffffff;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .submit-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
    }

    @media (max-width: 768px) {
        .container-modern {
            padding: 2rem 1rem;
        }
        
        .hero-title {
            font-size: 3rem;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
        }
        
        .contact-form {
            padding: 2rem;
        }
    }

    .contact-link {
        text-decoration: none;
        color: inherit;
        display: block;
        transition: all 0.3s ease;
    }

    .contact-link:hover {
        transform: translateY(-5px);
    }

    .contact-card:hover .contact-icon img {
        transform: scale(1.1);
    }
</style>
@endpush

<div class="contact-page">
    <div class="container-modern">
        <!-- Hero Section -->
        <div class="hero-section">
            <h1 class="hero-title">Contacto</h1>
            <p class="hero-subtitle">
                Estamos aquí para ayudarte. Contáctanos para cualquier consulta, sugerencia o asistencia que necesites.
            </p>
        </div>

        <!-- Contact Information -->
        <div class="contact-grid">
            <div class="contact-card">
                <a href="https://wa.me/18095550123" target="_blank" class="contact-link">
                    <div class="contact-icon">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/WhatsApp.svg/1022px-WhatsApp.svg.png" alt="WhatsApp" style="width: 48px; height: 48px; filter: brightness(0) invert(1);">
                    </div>
                    <h3 class="contact-title">WhatsApp</h3>
                    <p class="contact-info">+1 (809) 555-0123</p>
                </a>
            </div>
            <div class="contact-card">
                <div class="contact-icon">✉️</div>
                <h3 class="contact-title">Email</h3>
                <p class="contact-info">info@yuraicars.com</p>
            </div>
            <div class="contact-card">
                <div class="contact-icon">📍</div>
                <h3 class="contact-title">Ubicación</h3>
                <p class="contact-info">Santo Domingo, República Dominicana</p>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="contact-form">
            <form action="{{ route('contact.submit') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="name">Nombre</label>
                    <input type="text" id="name" name="name" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="subject">Asunto</label>
                    <input type="text" id="subject" name="subject" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="message">Mensaje</label>
                    <textarea id="message" name="message" class="form-input form-textarea" required></textarea>
                </div>
                <button type="submit" class="submit-button">Enviar Mensaje</button>
            </form>
        </div>
    </div>
</div>
</x-layouts.app> 