<x-layouts.app title="YuraiCars">
    @push('styles')
    <style>
        .gradient-text {
            background: linear-gradient(to right, #00ff87, #60efff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradient 8s ease infinite;
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
    </style>
    @endpush

    <!-- Hero Section -->
    <div class="relative min-h-screen bg-black overflow-hidden">
        <!-- Animated Background -->
        <div class="smoke-bg"></div>
        <div class="smoke-bg" style="animation-delay: -5s;"></div>

        <!-- 3D Car Canvas -->
        <div id="car-canvas" class="absolute inset-0 z-0"></div>

        <!-- Main Content -->
        <div class="relative z-10 container mx-auto px-4 pt-32">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="gradient-text text-5xl md:text-7xl font-black mb-6 tracking-tight">
                    El Futuro de la
                    <span class="block">Movilidad de Lujo</span>
                </h1>
                
                <p class="text-xl md:text-2xl text-zinc-300 mb-12 leading-relaxed">
                    Experimenta la próxima generación de alquiler de vehículos premium.
                    <span class="block">Donde el lujo encuentra la innovación.</span>
                </p>

                <div class="flex flex-wrap justify-center gap-6">
                    <button class="glass-card neon-glow px-8 py-4 text-white font-bold text-lg transition-all hover:scale-105">
                        Reservar Ahora
                    </button>
                    <button class="bg-white/10 backdrop-blur px-8 py-4 text-white font-bold text-lg border border-white/20 rounded-xl transition-all hover:bg-white/20">
                        Explorar Flota
                    </button>
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

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/gsap.min.js"></script>
    <script>
        // Three.js initialization and animation
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ alpha: true });
        const canvas = document.getElementById('car-canvas');
        
        renderer.setSize(window.innerWidth, window.innerHeight);
        canvas.appendChild(renderer.domElement);

        // Add ambient light
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
        scene.add(ambientLight);

        // Add directional light
        const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
        directionalLight.position.set(5, 5, 5);
        scene.add(directionalLight);

        camera.position.z = 5;

        // Animation loop
        function animate() {
            requestAnimationFrame(animate);
            renderer.render(scene, camera);
        }
        animate();

        // Responsive canvas
        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });

        // GSAP animations for content
        gsap.from('.gradient-text', {
            duration: 1,
            y: 100,
            opacity: 0,
            ease: 'power4.out',
            delay: 0.5
        });

        gsap.from('.glass-card', {
            duration: 1,
            y: 50,
            opacity: 0,
            stagger: 0.2,
            ease: 'power3.out',
            delay: 1
        });
    </script>
    @endpush
</x-layouts.app>
