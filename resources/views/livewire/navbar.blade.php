<nav x-data="{ open: false }" class="bg-white dark:bg-black border-b border-neutral-200 dark:border-neutral-700 transition-colors duration-300">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <!-- Logo -->
        <a href="/" class="text-xl font-bold text-gray-900 dark:text-white transition-colors">
            <flux:icon.car-front class="size-8 text-black dark:text-white" />
        </a>


        <!-- Menus (Mobile) -->
        <div class="flex items-center gap-x-4 lg:hidden">
            <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" icon="moon" variant="subtle" aria-label="Toggle dark mode" />
            @auth
            <flux:dropdown x-data align="end">
                <flux:button variant="subtle" square class="group">
                    <flux:icon.user-circle class="size-6 text-gray-700 dark:text-white" />
                </flux:button>

                <flux:menu>
                    <flux:menu.item icon="user" href="{{ route('profile') }}">Profile</flux:menu.item>
                    <flux:menu.item icon="car-front" href="{{ route('profile.rents') }}">Rents</flux:menu.item>
                    <flux:menu.item icon="log-out" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</flux:menu.item>
                </flux:menu>
            </flux:dropdown>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
            @else
            <ul>
                <li><a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">Sign In</a></li>
            </ul>
            @endauth
            <flux:button x-on:click="open = !open" variant="ghost" icon="menu" />
        </div>

        <!-- Desktop Menu -->
        <ul class="hidden lg:flex space-x-10">
            <li><a href="/" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">Home</a></li>
            <li><a href="/rent-a-car" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">Rent a car</a></li>
            <li><a href="/vehicles" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">Vehicles</a></li>
            <li><a href="/about" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">About</a></li>
            <li><a href="/contact" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">Contact</a></li>
        </ul>

        <!-- Dark Mode Switcher (Desktop) -->
        <div class="hidden lg:flex lg:items-center lg:gap-x-4">
            <flux:dropdown x-data align="end">
                <flux:button variant="subtle" square class="group" aria-label="Preferred color scheme">
                    <flux:icon.sun x-show="$flux.appearance === 'light'" variant="mini" class="text-zinc-500 dark:text-white transition-colors" />
                    <flux:icon.moon x-show="$flux.appearance === 'dark'" variant="mini" class="text-zinc-500 dark:text-white transition-colors" />
                    <flux:icon.moon x-show="$flux.appearance === 'system' && $flux.dark" variant="mini" />
                    <flux:icon.sun x-show="$flux.appearance === 'system' && ! $flux.dark" variant="mini" />
                </flux:button>

                <flux:menu>
                    <flux:menu.item icon="sun" x-on:click="$flux.appearance = 'light'">Light</flux:menu.item>
                    <flux:menu.item icon="moon" x-on:click="$flux.appearance = 'dark'">Dark</flux:menu.item>
                    <flux:menu.item icon="computer-desktop" x-on:click="$flux.appearance = 'system'">System</flux:menu.item>
                </flux:menu>
            </flux:dropdown>

            @auth
            <flux:dropdown x-data align="end">
                <flux:button variant="subtle" square class="group">
                    <flux:icon.user-circle class="size-6 text-gray-700 dark:text-white" />
                </flux:button>

                <flux:menu>
                    <flux:menu.item icon="user" href="{{ route('profile') }}">Profile</flux:menu.item>
                    <flux:menu.item icon="car-front" href="{{ route('profile.rents') }}">Rents</flux:menu.item>
                    <flux:menu.item icon="log-out" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();">Logout</flux:menu.item>
                </flux:menu>
            </flux:dropdown>

            <form id="logout-form-desktop" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
            @else
                <ul>
                    <li><a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">Sign In</a></li>
                </ul>
            @endauth
        </div>
    </div>

    <!-- Mobile Dropdown -->
    <div class="lg:hidden border-t border-neutral-200 dark:border-neutral-700" x-show="open" x-transition>
        <ul class="bg-white dark:bg-black space-y-2 p-4">
            <li><a href="/" class="block text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">Home</a></li>
            <li><a href="/rent-a-car" class="block text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">Rent a car</a></li>
            <li><a href="/vehicles" class="block text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">Vehicles</a></li>
            <li><a href="/about" class="block text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">About</a></li>
            <li><a href="/contact" class="block text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">Contact</a></li>
        </ul>
    </div>
</nav>
