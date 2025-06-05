<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth dark">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
        <title>{{ $title ?? 'YuraiCars' }}</title>
        @livewireStyles
        
        {{-- Use Vite Assets for modern build --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        {{-- ULTRA PREMIUM MINIMALIST NAVBAR --}}
        <style>
        /* Main layout styles */
        body {
            padding-top: 80px; /* Space for fixed navbar */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        main {
            flex: 1;
        }
        
        /* Premium Navbar Styles */
        .premium-navbar-container {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 80px;
            z-index: 50;
            background: #000000;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .premium-navbar-container.navbar-scrolled {
            background: #000000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
        
        .premium-navbar-content {
            max-width: 1200px;
            margin: 0 auto;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
        }
        
        .premium-logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: transform 0.2s ease;
        }
        
        .premium-logo-container:hover {
            transform: translateY(-1px);
        }
        
        .premium-brand-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            letter-spacing: -0.025em;
        }
        
        .premium-nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 8px 16px;
            font-weight: 500;
            font-size: 0.95rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        
        .premium-nav-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-1px);
        }
        
        .premium-login-btn {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 8px 24px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            text-decoration: none;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
        }
        
        .premium-login-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.25);
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }
        
        .premium-profile-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .premium-profile-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }
        
        .premium-dropdown {
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            margin-top: 8px;
        }
        
        .premium-menu-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 16px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.15s ease;
            font-size: 0.95rem;
            font-weight: 500;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
        }
        
        .premium-menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        @media (max-width: 1024px) {
            .premium-navbar-container {
                height: auto;
                min-height: 70px;
            }
            
            body {
                padding-top: 70px;
            }
            
            .premium-navbar-content {
                padding: 12px 16px;
            }
        }
        </style>
        
        @fluxAppearance
        @stack('styles')
    </head>
    <body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white antialiased">
        <!-- Premium Navbar -->
        <nav id="premium-navbar" class="premium-navbar-container">
            <div class="premium-navbar-content">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="premium-logo-container">
                    <div class="bg-gradient-to-br from-emerald-400 to-cyan-400 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M5 11l4-4v3h5.28l-3.64 3.64.71.71L16 9.71V11a1 1 0 0 0 1 1h1v-1a3 3 0 0 0-3-3h-5V5l-4 4H5v2z"/>
                        </svg>
                    </div>
                    <span class="premium-brand-text">YuraiCars</span>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center gap-6">
                    <a href="{{ route('home') }}" class="premium-nav-link">Inicio</a>
                    <a href="{{ route('vehicles.index') }}" class="premium-nav-link">Vehículos</a>
                    <a href="{{ route('rent-a-car.index') }}" class="premium-nav-link">Alquilar</a>
                    <a href="{{ route('about') }}" class="premium-nav-link">Nosotros</a>
                </div>

                <!-- Desktop Controls -->
                <div class="hidden lg:flex items-center gap-4">
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="premium-profile-btn">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>
                                </svg>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 w-48 premium-dropdown"
                                 style="display: none;">
                                <a href="{{ route('profile') }}" class="premium-menu-item">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>
                                    </svg>
                                    Perfil
                                </a>
                                <a href="{{ route('profile.rents') }}" class="premium-menu-item">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M5 11l4-4v3h5.28l-3.64 3.64.71.71L16 9.71V11a1 1 0 0 0 1 1h1v-1a3 3 0 0 0-3-3h-5V5l-4 4H5v2z"/>
                                    </svg>
                                    Alquileres
                                </a>
                                <form action="{{ route('logout') }}" method="POST" class="block">
                                    @csrf
                                    <button type="submit" class="premium-menu-item">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M7.5 3.75A1.5 1.5 0 019 2.25h1.5a1.5 1.5 0 011.5 1.5v.75h-3v-.75z"/>
                                        </svg>
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="premium-login-btn">
                            Iniciar Sesión
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="lg:hidden flex items-center">
                    <button @click="mobileMenu = !mobileMenu" class="premium-profile-btn">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-16 6h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenu" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="lg:hidden bg-black border-t border-gray-800"
                 style="display: none;">
                <div class="px-4 py-3 space-y-1">
                    <a href="{{ route('home') }}" class="premium-menu-item">Inicio</a>
                    <a href="{{ route('vehicles.index') }}" class="premium-menu-item">Vehículos</a>
                    <a href="{{ route('rent-a-car.index') }}" class="premium-menu-item">Alquilar</a>
                    <a href="{{ route('about') }}" class="premium-menu-item">Nosotros</a>
                    @guest
                        <a href="{{ route('login') }}" class="premium-menu-item">Iniciar Sesión</a>
                    @endguest
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main>
            {{ $slot }}
        </main>

        <!-- Footer -->
        <livewire:footer />
        
        <livewire:ui.toast />
        @livewireScripts
        @stack('scripts')
        
        <script>
            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                const navbar = document.getElementById('premium-navbar');
                if (window.scrollY > 20) {
                    navbar.classList.add('navbar-scrolled');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                }
            });

            // Initialize mobile menu
            window.mobileMenu = false;
        </script>
    </body>
</html>

