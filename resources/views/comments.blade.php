<x-layouts.app title="Comentarios de Clientes - YuraiCars">
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
    </style>
    @endpush
    <div class="vehicles-page">
        <div class="container-modern">
            <div class="page-header">
                <h1 class="page-title">Comentarios de Clientes</h1>
                <div class="page-subtitle">Testimonios reales de quienes confiaron en YuraiCars para vivir una experiencia premium.</div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <!-- Comentario 1 -->
                <div class="glass-card">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                            J
                        </div>
                        <div class="ml-4">
                            <h4 class="text-xl font-bold text-white">Juan Pérez</h4>
                            <div class="flex text-yellow-400 mt-1">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <p class="text-zinc-300 text-lg italic">"La mejor experiencia de alquiler que he tenido. Los vehículos están en perfecto estado y el servicio es excepcional."</p>
                </div>
                <!-- Comentario 2 -->
                <div class="glass-card">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-red-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                            M
                        </div>
                        <div class="ml-4">
                            <h4 class="text-xl font-bold text-white">María García</h4>
                            <div class="flex text-yellow-400 mt-1">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <p class="text-zinc-300 text-lg italic">"El proceso de reserva fue muy sencillo y el personal es muy atento. Definitivamente volveré a alquilar con YuraiCars."</p>
                </div>
                <!-- Comentario 3 -->
                <div class="glass-card">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-teal-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                            C
                        </div>
                        <div class="ml-4">
                            <h4 class="text-xl font-bold text-white">Carlos López</h4>
                            <div class="flex text-yellow-400 mt-1">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <p class="text-zinc-300 text-lg italic">"La flota de vehículos es impresionante y los precios son muy competitivos. Una experiencia de lujo total."</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 