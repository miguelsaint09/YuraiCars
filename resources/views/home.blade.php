<x-layouts.app title="YuraiCars">
    @push('styles')
    <style>
        .gradient-text {
            background: linear-gradient(to right, #00ff87, #60efff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientFlow 8s ease infinite;
            background-size: 200% auto;
            font-size: min(max(2.5rem, 8vw), 4.5rem);
            line-height: 1.2;
            white-space: normal;
            display: block;
            margin: 0;
            text-align: left;
            position: relative;
            z-index: 2;
        }

        .gradient-text::after {
            content: attr(data-text);
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, #00ff87, #60efff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            opacity: 0.5;
            filter: blur(12px);
            animation: glowPulse 3s ease-in-out infinite;
            z-index: -1;
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

        @keyframes gradientFlow {
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
            animation: enhancedSmoke 30s ease infinite;
            mix-blend-mode: screen;
        }

        @keyframes enhancedSmoke {
            0% { 
                transform: scale(1) rotate(0deg); 
                opacity: 0.5;
                filter: blur(50px);
            }
            50% { 
                transform: scale(1.8) rotate(180deg); 
                opacity: 0.8;
                filter: blur(60px);
            }
            100% { 
                transform: scale(1) rotate(360deg); 
                opacity: 0.5;
                filter: blur(50px);
            }
        }

        /* Real Supercar Image Effects */
        .car-image-container {
            position: absolute;
            top: 50%;
            right: 5%;
            transform: translateY(-50%);
            width: 55%;
            max-width: 1000px;
            z-index: 5;
        }

        .car-image {
            width: 100%;
            height: auto;
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
                width: 55%;
                right: 4%;
                top: 45%;
            }
        }

        @media (max-width: 1400px) {
            .car-image-container {
                width: 50%;
                right: 3%;
                top: 42%;
            }
        }

        @media (max-width: 1200px) {
            .car-image-container {
                width: 45%;
                right: 2%;
                top: 40%;
            }
        }

        @media (max-width: 1024px) {
            .car-image-container {
                width: 40%;
                right: 1%;
                top: 38%;
            }
            
            .content-container {
                padding-left: 2rem;
                padding-right: 2rem;
            }
        }

        @media (max-width: 768px) {
            .car-image-container {
                position: static;
                width: 140%;
                max-width: none;
                margin-left: -20%;
                margin-top: 3rem;
                margin-bottom: -2rem;
                transform: none;
                animation: carFloatMobile 3s ease-in-out infinite;
            }

            .car-image {
                animation: carGlow 3s ease-in-out infinite;
            }

            @keyframes carFloatMobile {
                0%, 100% {
                    transform: translateY(0) rotate(-2deg);
                }
                50% {
                    transform: translateY(-15px) rotate(2deg);
                }
            }

            @keyframes carGlow {
                0%, 100% {
                    filter: drop-shadow(0 10px 30px rgba(0, 255, 135, 0.2));
                }
                50% {
                    filter: drop-shadow(0 20px 50px rgba(0, 255, 135, 0.4));
                }
            }

            .gradient-text {
                font-size: min(max(2rem, 12vw), 3.5rem);
                line-height: 1.3;
                padding: 0;
                margin-bottom: 2rem;
                transform-style: preserve-3d;
                perspective: 1000px;
                animation: titleFloat 5s ease-in-out infinite;
                text-align: center;
                margin: 0 auto;
            }

            .gradient-text::before {
                content: attr(data-text);
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(45deg, #00ff87, #60efff);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                opacity: 0.3;
                filter: blur(20px);
                transform: translateZ(-10px);
                animation: titleGlow 3s ease-in-out infinite alternate;
            }

            @keyframes titleFloat {
                0%, 100% {
                    transform: translateY(0) rotateX(0deg);
                }
                50% {
                    transform: translateY(-10px) rotateX(5deg);
                }
            }

            @keyframes titleGlow {
                0% {
                    opacity: 0.3;
                    filter: blur(20px);
                }
                100% {
                    opacity: 0.7;
                    filter: blur(25px);
                }
            }

            .text-content {
                text-align: center;
                padding: 3rem 1.5rem;
                position: relative;
                z-index: 2;
            }

            .text-content::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 150%;
                height: 150%;
                background: radial-gradient(circle, rgba(0, 255, 135, 0.15) 0%, transparent 70%);
                filter: blur(50px);
                z-index: -1;
                animation: contentGlow 5s ease-in-out infinite;
            }

            @keyframes contentGlow {
                0%, 100% {
                    transform: translate(-50%, -50%) scale(1);
                    opacity: 0.5;
                }
                50% {
                    transform: translate(-50%, -50%) scale(1.2);
                    opacity: 0.8;
                }
            }

            .btn-premium {
                width: 100%;
                height: 65px;
                font-size: 1.2rem;
                letter-spacing: 2px;
                background: linear-gradient(45deg, #00ff87, #60efff);
                border: none;
                position: relative;
                overflow: hidden;
                transition: all 0.5s cubic-bezier(0.2, 1, 0.3, 1);
                transform-style: preserve-3d;
                perspective: 1000px;
            }

            .btn-premium::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 200%;
                height: 100%;
                background: linear-gradient(115deg, 
                    transparent 0%,
                    transparent 40%,
                    rgba(255, 255, 255, 0.8) 50%,
                    transparent 60%,
                    transparent 100%
                );
                transform: translateX(-100%) rotateX(45deg);
                animation: buttonShine 3s infinite;
            }

            @keyframes buttonShine {
                0% {
                    transform: translateX(-100%) rotateX(45deg);
                }
                100% {
                    transform: translateX(100%) rotateX(45deg);
                }
            }

            .btn-premium::after {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: radial-gradient(circle, rgba(0, 255, 135, 0.4) 0%, transparent 70%);
                filter: blur(20px);
                animation: buttonGlow 3s ease-in-out infinite;
                z-index: -1;
            }

            @keyframes buttonGlow {
                0%, 100% {
                    transform: scale(1);
                    opacity: 0.5;
                }
                50% {
                    transform: scale(1.2);
                    opacity: 0.8;
                }
            }

            .btn-secondary {
                width: 100%;
                height: 65px;
                font-size: 1.2rem;
                letter-spacing: 2px;
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(15px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                position: relative;
                overflow: hidden;
                transition: all 0.5s cubic-bezier(0.2, 1, 0.3, 1);
            }

            .btn-secondary::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(45deg,
                    transparent 0%,
                    rgba(255, 255, 255, 0.05) 50%,
                    transparent 100%
                );
                transform: translateX(-100%);
                animation: secondaryButtonShine 4s infinite;
            }

            @keyframes secondaryButtonShine {
                0% {
                    transform: translateX(-100%) skewX(-15deg);
                }
                100% {
                    transform: translateX(100%) skewX(-15deg);
                }
            }

            .features-grid {
                margin-top: 4rem;
                gap: 1.5rem;
            }

            .glass-card {
                transform: scale(0.95);
                opacity: 0;
                animation: floatIn 0.8s cubic-bezier(0.2, 1, 0.3, 1) forwards;
            }

            .glass-card:nth-child(2) {
                animation-delay: 0.2s;
            }

            .glass-card:nth-child(3) {
                animation-delay: 0.4s;
            }

            .glass-card {
                padding: 2rem;
                background: rgba(255, 255, 255, 0.05);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.1);
                transition: all 0.5s cubic-bezier(0.2, 1, 0.3, 1);
            }

            .glass-card:hover {
                transform: translateY(-5px);
                background: rgba(255, 255, 255, 0.08);
                border-color: rgba(255, 255, 255, 0.2);
            }

            .glass-card h3 {
                font-size: 1.5rem;
                margin-bottom: 1rem;
                background: linear-gradient(to right, #ffffff, #e2e8f0);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            .glass-card p {
                font-size: 1.1rem;
                line-height: 1.6;
                color: rgba(255, 255, 255, 0.8);
            }
        }

        .content-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 8rem 4rem;
            position: relative;
            z-index: 10;
        }

        .hero-section {
            min-height: 100vh;
                display: flex;
                align-items: center;
            position: relative;
            overflow: hidden;
            padding-bottom: 8rem;
        }

        .text-content {
            max-width: 650px;
            position: relative;
            z-index: 15;
            margin-bottom: 2rem;
            }

        .features-grid {
            margin-top: 10rem;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            position: relative;
            z-index: 15;
        }

        @media (max-width: 768px) {
            .features-grid {
                grid-template-columns: 1fr;
                margin-top: 4rem;
            }
            
            .content-container {
                padding: 4rem 1rem;
            }
        }

        /* Enhanced Mobile Animations */
        @keyframes floatIn {
            0% {
                opacity: 0;
                transform: translateY(100px) scale(0.8);
                filter: blur(10px);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes glowPulse {
            0%, 100% {
                filter: drop-shadow(0 0 20px rgba(0, 255, 135, 0.2));
            }
            50% {
                filter: drop-shadow(0 0 40px rgba(0, 255, 135, 0.4));
            }
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        /* Responsive Breakpoints with Enhanced Effects */
        @media (min-width: 769px) and (max-width: 1024px) {
            .gradient-text {
                font-size: min(max(2.2rem, 6vw), 4rem);
            }
        }

        @media (min-width: 1025px) and (max-width: 1366px) {
            .gradient-text {
                font-size: min(max(2.8rem, 5vw), 4.2rem);
            }
        }

        @media (min-width: 1367px) {
            .gradient-text {
                font-size: min(max(3rem, 4vw), 4.5rem);
            }
        }
    </style>
    @endpush

    <!-- Force dark mode for this page -->
    <div class="dark">
        <!-- Hero Section -->
        <section class="hero-section bg-black text-white">
            <!-- Animated Background -->
            <div class="smoke-bg"></div>
            <div class="smoke-bg" style="animation-delay: -5s;"></div>
            <div class="smoke-bg" style="animation-delay: -10s;"></div>

            <!-- Ground Reflection -->
            <div class="ground-reflection"></div>

            <!-- Content Container -->
            <div class="content-container">
                <!-- Text Content -->
                <div class="text-content">
                    <h1 class="gradient-text font-black mb-8 tracking-tight animate-fade-in">
                        El Futuro de la<br>
                        Movilidad de Lujo
                    </h1>
                    
                    <p class="text-xl md:text-2xl text-zinc-300 mb-12 leading-relaxed animate-fade-in-delay">
                        Experimenta la próxima generación de alquiler de vehículos premium.
                        <span class="block mt-2">Donde el lujo encuentra la innovación.</span>
                    </p>

                    <div class="flex flex-wrap gap-6 animate-fade-in-delay-2">
                        <a href="{{ route('rent-a-car.index') }}" class="btn-premium neon-glow">
                            Reservar Ahora
                        </a>
                        <a href="{{ route('vehicles.index') }}" class="btn-secondary">
                            Explorar Flota
                        </a>
                    </div>
                </div>

                <!-- Car Image -->
                <div class="car-image-container">
                    <img src="{{ asset('images/Car3d.png') }}" 
                         alt="Supercar de lujo moderno" 
                         class="car-image"
                         loading="eager"
                         fetchpriority="high">
                </div>

                <!-- Features Grid -->
                <div class="features-grid">
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
        </section>
    </div>
</x-layouts.app>
