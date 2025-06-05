<!-- NAVBAR VISIBLE - VERSIÓN SIMPLE PERO FUNCIONAL -->
<nav class="fixed top-0 left-0 right-0 z-[9999] bg-black border-b border-gray-700">
    <div class="container mx-auto px-6 py-4">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <div class="bg-emerald-500 p-3 rounded-xl">
                    <flux:icon.car-front class="size-6 text-white" />
                </div>
                <span class="text-2xl font-black text-white">YuraiCars</span>
            </a>

            <!-- Mobile Menu Button -->
            <div class="flex items-center gap-4 lg:hidden">
                <!-- Dark Mode Toggle Mobile -->
                <button x-data x-on:click="$flux.dark = ! $flux.dark" class="p-3 text-white hover:text-emerald-400">
                    <flux:icon.moon class="size-5" />
                </button>

                <!-- User Menu Mobile -->
                @auth
                <flux:dropdown x-data align="end">
                    <flux:button variant="ghost" class="p-3 text-white hover:text-emerald-400">
                        <flux:icon.user-circle class="size-5" />
                    </flux:button>
                    
                    <flux:menu class="bg-gray-900 border border-gray-700">
                        <flux:menu.item icon="user" href="{{ route('profile') }}" class="text-white hover:bg-gray-700">Perfil</flux:menu.item>
                        <flux:menu.item icon="car-front" href="{{ route('profile.rents') }}" class="text-white hover:bg-gray-700">Alquileres</flux:menu.item>
                        <flux:menu.item icon="log-out" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-white hover:bg-gray-700">Cerrar Sesión</flux:menu.item>
                    </flux:menu>
                </flux:dropdown>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
                @else
                <a href="{{ route('login') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                    Iniciar Sesión
                </a>
                @endauth

                <!-- Mobile Menu Toggle -->
                <button x-data="{ open: false }" x-on:click="open = !open; $dispatch('toggle-mobile-menu', { open: open })" class="p-3 text-white hover:text-emerald-400">
                    <flux:icon.bars-3 class="size-6" />
                </button>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-white hover:text-emerald-400 font-semibold">Inicio</a>
                <a href="{{ route('rent-a-car.index') }}" class="text-white hover:text-emerald-400 font-semibold">Alquilar un Auto</a>
                <a href="{{ route('vehicles.index') }}" class="text-white hover:text-emerald-400 font-semibold">Vehículos</a>
                <a href="{{ route('about') }}" class="text-white hover:text-emerald-400 font-semibold">Nosotros</a>
                <a href="#" class="text-white hover:text-emerald-400 font-semibold">Contacto</a>
            </div>

            <!-- Desktop Controls -->
            <div class="hidden lg:flex items-center space-x-4">
                <!-- Dark Mode Toggle Desktop -->
                <flux:dropdown x-data align="end">
                    <flux:button variant="ghost" class="p-3 text-white hover:text-emerald-400">
                        <flux:icon.sun x-show="$flux.appearance === 'light'" variant="mini" />
                        <flux:icon.moon x-show="$flux.appearance === 'dark'" variant="mini" />
                        <flux:icon.moon x-show="$flux.appearance === 'system' && $flux.dark" variant="mini" />
                        <flux:icon.sun x-show="$flux.appearance === 'system' && ! $flux.dark" variant="mini" />
                    </flux:button>

                    <flux:menu class="bg-gray-900 border border-gray-700">
                        <flux:menu.item icon="sun" x-on:click="$flux.appearance = 'light'" class="text-white hover:bg-gray-700">Light</flux:menu.item>
                        <flux:menu.item icon="moon" x-on:click="$flux.appearance = 'dark'" class="text-white hover:bg-gray-700">Dark</flux:menu.item>
                        <flux:menu.item icon="computer-desktop" x-on:click="$flux.appearance = 'system'" class="text-white hover:bg-gray-700">System</flux:menu.item>
                    </flux:menu>
                </flux:dropdown>

                <!-- User Menu Desktop -->
                @auth
                <flux:dropdown x-data align="end">
                    <flux:button variant="ghost" class="p-3 text-white hover:text-emerald-400">
                        <flux:icon.user-circle class="size-5" />
                    </flux:button>

                    <flux:menu class="bg-gray-900 border border-gray-700">
                        <flux:menu.item icon="user" href="{{ route('profile') }}" class="text-white hover:bg-gray-700">Perfil</flux:menu.item>
                        <flux:menu.item icon="car-front" href="{{ route('profile.rents') }}" class="text-white hover:bg-gray-700">Alquileres</flux:menu.item>
                        <flux:menu.item icon="log-out" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();" class="text-white hover:bg-gray-700">Cerrar Sesión</flux:menu.item>
                    </flux:menu>
                </flux:dropdown>

                <form id="logout-form-desktop" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
                @else
                <a href="{{ route('login') }}" class="px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-semibold">
                    Iniciar Sesión
                </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Mobile Dropdown -->
    <div x-data="{ open: false }" 
         x-on:toggle-mobile-menu.window="open = $event.detail.open"
         x-show="open" 
         x-transition
         class="lg:hidden bg-gray-900 border-t border-gray-700">
        <div class="px-6 py-4 space-y-2">
            <a href="{{ route('home') }}" class="block py-2 text-white hover:text-emerald-400">Inicio</a>
            <a href="{{ route('rent-a-car.index') }}" class="block py-2 text-white hover:text-emerald-400">Alquilar un Auto</a>
            <a href="{{ route('vehicles.index') }}" class="block py-2 text-white hover:text-emerald-400">Vehículos</a>
            <a href="{{ route('about') }}" class="block py-2 text-white hover:text-emerald-400">Nosotros</a>
            <a href="#" class="block py-2 text-white hover:text-emerald-400">Contacto</a>
        </div>
    </div>
</nav>
