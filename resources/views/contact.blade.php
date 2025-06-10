<x-layouts.app title="Contacto - YuraiCars">
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
            font-size: 3.2rem;
            font-weight: 900;
            background: linear-gradient(135deg, #ffffff 0%, #f3f4f6 20%, #ffffff 40%, #e5e7eb 60%, #ffffff 80%, #d1d5db 100%);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            letter-spacing: -0.06em;
            line-height: 1.05;
            text-shadow: 0 0 50px rgba(255, 255, 255, 0.15);
            animation: titleGradient 8s ease-in-out infinite;
        }
        @keyframes titleGradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .page-subtitle {
            font-size: 1.25rem;
            color: #9ca3af;
            font-weight: 400;
            max-width: 650px;
            margin: 0 auto 2.5rem auto;
            line-height: 1.6;
        }
        .glass-card {
            background: linear-gradient(145deg, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0.04) 50%, rgba(255,255,255,0.02) 100%);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 28px;
            padding: 2.5rem;
            backdrop-filter: blur(25px);
            box-shadow: 0 10px 40px rgba(0,0,0,0.4), 0 0 0 1px rgba(255,255,255,0.06), inset 0 1px 0 rgba(255,255,255,0.15), inset 0 -1px 0 rgba(0,0,0,0.1);
        }
        .input-premium {
            background: rgba(20, 20, 30, 0.85) !important;
            color: #fff !important;
            border: 1.5px solid rgba(255,255,255,0.13) !important;
            border-radius: 1rem !important;
            box-shadow: 0 2px 16px 0 rgba(0,0,0,0.10);
            font-size: 1.08rem;
        }
        .input-premium::placeholder {
            color: #b6b6c1 !important;
            opacity: 1 !important;
        }
        .input-premium:focus {
            outline: none !important;
            border-color: #34ffe6 !important;
            box-shadow: 0 0 0 2px #34ffe6a0;
        }
        .btn-premium {
            background: linear-gradient(90deg, #34ffe6 0%, #60efff 100%);
            color: #18181b !important;
            font-weight: 800;
            font-size: 1.15rem;
            border-radius: 1rem;
            box-shadow: 0 4px 32px 0 #34ffe633, 0 1.5px 0 #fff1;
            transition: all 0.18s cubic-bezier(.4,2,.6,1);
        }
        .btn-premium:hover {
            filter: brightness(1.15) drop-shadow(0 0 8px #60efff);
            transform: scale(1.03);
        }
    </style>
    @endpush
    <div class="vehicles-page">
        <div class="container-modern">
            <div class="page-header">
                <h1 class="page-title">Contacto</h1>
                <div class="page-subtitle">¿Tienes dudas, sugerencias o quieres comunicarte con nosotros? Completa el formulario o usa los datos de contacto.</div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Información de Contacto -->
                <div class="space-y-8">
                    <div class="glass-card flex items-center gap-4">
                        <div class="bg-blue-500 p-4 rounded-full">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Teléfono</h3>
                            <p class="text-zinc-300">+51 999 999 999</p>
                        </div>
                    </div>
                    <div class="glass-card flex items-center gap-4">
                        <div class="bg-red-500 p-4 rounded-full">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Email</h3>
                            <p class="text-zinc-300">contacto@yuraicars.com</p>
                        </div>
                    </div>
                </div>
                <!-- Formulario de Contacto -->
                <div class="glass-card">
                    <h2 class="text-2xl font-semibold mb-6 text-white">Envíanos un mensaje</h2>
                    <form action="#" method="POST" class="space-y-6">
                        <div>
                            <input type="text" name="name" id="name" placeholder="Tu nombre completo" class="input-premium w-full px-5 py-3 placeholder:text-zinc-400">
                        </div>
                        <div>
                            <input type="email" name="email" id="email" placeholder="tucorreo@email.com" class="input-premium w-full px-5 py-3 placeholder:text-zinc-400">
                        </div>
                        <div>
                            <textarea name="message" id="message" rows="5" placeholder="Escribe tu mensaje aquí..." class="input-premium w-full px-5 py-3 placeholder:text-zinc-400 resize-none"></textarea>
                        </div>
                        <button type="submit" class="btn-premium w-full py-3 mt-2">Enviar Mensaje</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 