<!-- Navbar Component -->
<div class="relative">
    <!-- Navbar -->
    <nav x-data="{ open: false }" class="sticky top-0 left-0 right-0 z-[100] bg-black shadow-sm">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="text-xl font-bold text-white flex items-center gap-2">
                <flux:icon.car-front class="size-8 text-white" />
                <span>YuraiCars</span>
            </a>

            <!-- Menus (Mobile) -->
            <div class="flex items-center gap-x-4 lg:hidden">
                @auth
                <flux:dropdown x-data align="end">
                    <flux:button variant="subtle" square class="group">
                        <flux:icon.user-circle class="size-6 text-white" />
                    </flux:button>

                    <flux:menu class="z-[101] bg-black shadow-lg border border-gray-800 rounded-lg mt-2 w-48 flux-menu">
                        <div class="py-1">
                            <a href="{{ route('profile') }}" class="flux-menu-item flex items-center px-4 py-2 text-sm">
                                <flux:icon.user class="mr-3 size-5" />
                                <span>Perfil</span>
                            </a>
                            <a href="{{ route('profile.rents') }}" class="flux-menu-item flex items-center px-4 py-2 text-sm">
                                <flux:icon.car-front class="mr-3 size-5" />
                                <span>Alquileres</span>
                            </a>
                            <a href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                               class="flux-menu-item flex items-center px-4 py-2 text-sm">
                                <flux:icon.log-out class="mr-3 size-5" />
                                <span>Cerrar Sesión</span>
                            </a>
                        </div>
                    </flux:menu>
                </flux:dropdown>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
                @else
                <ul>
                    <li><a href="{{ route('login') }}" class="text-white hover:text-gray-300 transition-colors">Iniciar Sesión</a></li>
                </ul>
                @endauth
                <flux:button x-on:click="open = !open" variant="ghost" icon="menu" class="text-white" />
            </div>

            <!-- Desktop Menu -->
            <ul class="hidden lg:flex space-x-10">
                <li><a href="{{ route('home') }}" class="text-white hover:text-gray-300 transition-colors">Inicio</a></li>
                <li><a href="{{ route('vehicles.index') }}" class="text-white hover:text-gray-300 transition-colors">Vehículos</a></li>
                <li><a href="{{ route('about') }}" class="text-white hover:text-gray-300 transition-colors">Nosotros</a></li>
                <li><a href="{{ route('contact') }}" class="text-white hover:text-gray-300 transition-colors">Contacto</a></li>
            </ul>

            <!-- User Menu (Desktop) -->
            <div class="hidden lg:flex lg:items-center lg:gap-x-4">
                @auth
                <flux:dropdown x-data align="end">
                    <flux:button variant="subtle" square class="group">
                        <flux:icon.user-circle class="size-6 text-white" />
                    </flux:button>

                    <flux:menu class="z-[101] bg-black shadow-lg border border-gray-800 rounded-lg mt-2 w-48 flux-menu">
                        <div class="py-1">
                            <a href="{{ route('profile') }}" class="flux-menu-item flex items-center px-4 py-2 text-sm">
                                <flux:icon.user class="mr-3 size-5" />
                                <span>Perfil</span>
                            </a>
                            <a href="{{ route('profile.rents') }}" class="flux-menu-item flex items-center px-4 py-2 text-sm">
                                <flux:icon.car-front class="mr-3 size-5" />
                                <span>Alquileres</span>
                            </a>
                            <a href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();" 
                               class="flux-menu-item flex items-center px-4 py-2 text-sm">
                                <flux:icon.log-out class="mr-3 size-5" />
                                <span>Cerrar Sesión</span>
                            </a>
                        </div>
                    </flux:menu>
                </flux:dropdown>

                <form id="logout-form-desktop" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
                @else
                    <ul>
                        <li><a href="{{ route('login') }}" class="text-white hover:text-gray-300 transition-colors">Iniciar Sesión</a></li>
                    </ul>
                @endauth
            </div>
        </div>

        <!-- Mobile Dropdown -->
        <div class="lg:hidden border-t border-gray-800" x-show="open" x-transition>
            <ul class="bg-black space-y-2 p-4">
                <li><a href="{{ route('home') }}" class="block px-4 py-2 text-white hover:text-gray-300 transition-colors">Inicio</a></li>
                <li><a href="{{ route('vehicles.index') }}" class="block px-4 py-2 text-white hover:text-gray-300 transition-colors">Vehículos</a></li>
                <li><a href="{{ route('about') }}" class="block px-4 py-2 text-white hover:text-gray-300 transition-colors">Nosotros</a></li>
                <li><a href="{{ route('contact') }}" class="block px-4 py-2 text-white hover:text-gray-300 transition-colors">Contacto</a></li>
            </ul>
        </div>
    </nav>

    <!-- Spacer to prevent content from hiding under fixed navbar -->
    <div class="h-20"></div>
</div>
