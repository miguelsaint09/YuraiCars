<x-layouts.app title="YuraiCars">
    @push('styles')
    <style>
        .gradient-text {
            background: linear-gradient(to right, #00ff87, #60efff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradient 8s ease infinite;
            background-size: 200% auto;
        }

        .neon-glow {
            filter: drop-shadow(0 0 15px rgba(0, 255, 135, 0.5));
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .smoke-bg {
            position: absolute;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 50% 50%, 
                rgba(76, 0, 255, 0.1) 0%,
                rgba(0, 255, 135, 0.1) 100%);
            filter: blur(100px);
            animation: smoke 20s ease infinite;
        }

        @keyframes smoke {
            0% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.5) rotate(180deg); }
            100% { transform: scale(1) rotate(360deg); }
        }

        /* Real Supercar Image Effects */
        .car-image-container {
            position: absolute;
            top: 35%;
            right: 2%;
            transform: translateY(-50%);
            width: 1200px;
            height: 800px;
            opacity: 1;
            z-index: 5;
        }

        .car-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.4));
            animation: carFloat 4s ease-in-out infinite;
        }

        @keyframes carFloat {
            0%, 100% { 
                transform: translateY(0px); 
            }
            50% { 
                transform: translateY(-15px); 
            }
        }

        /* Ground reflection */
        .ground-reflection {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 300px;
            background: linear-gradient(to top, 
                rgba(0, 0, 0, 0.4) 0%, 
                rgba(0, 255, 135, 0.1) 30%,
                transparent 100%);
            opacity: 0.7;
        }

        /* Responsive */
        @media (max-width: 1600px) {
            .car-image-container {
                width: 1000px;
                height: 670px;
                right: 1%;
                top: 38%;
        }
        }

        @media (max-width: 1400px) {
            .car-image-container {
                width: 900px;
                height: 600px;
                right: 0%;
                top: 40%;
            }
        }

        @media (max-width: 1200px) {
            .car-image-container {
                width: 750px;
                height: 500px;
                right: -1%;
                top: 42%;
            }
        }

        @media (max-width: 1024px) {
            .car-image-container {
                width: 650px;
                height: 430px;
                right: -2%;
                top: 45%;
            }
        }

        @media (max-width: 768px) {
            .car-image-container {
                position: relative;
                top: auto;
                right: auto;
                transform: none;
                width: 100%;
                height: 400px;
                margin: 3rem 0 2rem 0;
                display: flex;
                justify-content: center;
                align-items: center;
                order: 2;
            }
        }

        @media (max-width: 480px) {
            .car-image-container {
                height: 320px;
            }
        }

        /* Responsive para el contenido principal */
        @media (max-width: 1024px) {
            .max-w-2xl.lg\\:ml-16 {
                margin-left: 2rem;
            }
        }

        @media (max-width: 768px) {
            .max-w-2xl.lg\\:ml-16 {
                margin-left: 0;
                max-width: 100%;
                order: 1;
            }
            
            .hero-section-mobile {
                display: flex;
                flex-direction: column;
            }
        }
    </style>
    @endpush

    <!-- Force dark mode for this page -->
    <div class="dark">
        <!-- Hero Section -->
        <div class="relative min-h-screen bg-black overflow-hidden text-white hero-section-mobile">
            <!-- Animated Background -->
            <div class="smoke-bg"></div>
            <div class="smoke-bg" style="animation-delay: -5s;"></div>
            <div class="smoke-bg" style="animation-delay: -10s;"></div>

            <!-- Ground Reflection -->
            <div class="ground-reflection"></div>

            <!-- Real Supercar Image -->
            <div class="car-image-container">
                <img src="{{ asset('images/Car3d.png') }}" 
                     alt="Supercar de lujo moderno" 
                     class="car-image"
                     loading="eager"
                     fetchpriority="high">
            </div>

            <!-- Main Content -->
            <div class="relative z-10 container mx-auto px-4 pt-32">
                <div class="max-w-2xl text-center lg:text-left lg:ml-16">
                    <h1 class="gradient-text text-5xl md:text-7xl font-black mb-6 tracking-tight animate-fade-in">
                        El Futuro de la
                        <span class="block">Movilidad de Lujo</span>
                    </h1>
                    
                    <p class="text-xl md:text-2xl text-zinc-300 mb-12 leading-relaxed animate-fade-in-delay max-w-2xl">
                        Experimenta la próxima generación de alquiler de vehículos premium.
                        <span class="block">Donde el lujo encuentra la innovación.</span>
                    </p>

                    <div class="flex flex-wrap justify-center lg:justify-start gap-6 animate-fade-in-delay-2">
                        <a href="{{ route('vehicles.index') }}" class="btn-premium neon-glow">
                            Reservar Ahora
                        </a>
                        <a href="{{ route('vehicles.index') }}" class="btn-secondary">
                            Explorar Flota
                        </a>
                    </div>
                </div>

                <!-- Features Grid -->
                <div class="mt-32 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="glass-card p-8 floating" style="animation-delay: 0s;">
                        <div class="h-16 w-16 mb-6 bg-gradient-to-br from-emerald-400 to-cyan-400 rounded-xl flex items-center justify-center">
                            <flux:icon.sparkles class="text-white size-8" />
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-4">Experiencia Premium</h3>
                        <p class="text-zinc-300">Vehículos de lujo equipados con la última tecnología para una experiencia incomparable.</p>
                    </div>

                    <div class="glass-card p-8 floating" style="animation-delay: 0.2s;">
                        <div class="h-16 w-16 mb-6 bg-gradient-to-br from-purple-400 to-pink-400 rounded-xl flex items-center justify-center">
                            <flux:icon.shield-check class="text-white size-8" />
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-4">Seguridad Total</h3>
                        <p class="text-zinc-300">Sistemas de seguridad avanzados y mantenimiento premium garantizado.</p>
                    </div>

                    <div class="glass-card p-8 floating" style="animation-delay: 0.4s;">
                        <div class="h-16 w-16 mb-6 bg-gradient-to-br from-amber-400 to-orange-400 rounded-xl flex items-center justify-center">
                            <flux:icon.clock class="text-white size-8" />
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-4">24/7 Disponible</h3>
                        <p class="text-zinc-300">Servicio personalizado y soporte disponible en cualquier momento que lo necesites.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
