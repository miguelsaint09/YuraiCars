<x-layouts.app title="Home">
    <!-- Hero Section -->
    <div class="relative w-full h-94 md:h-[calc(100vh-72px)] flex items-start justify-center bg-gradient-to-b from-white to-zinc-200 dark:from-zinc-900 dark:to-black text-zinc-900 dark:text-white">
        <div class="absolute inset-0 bg-contain bg-no-repeat bg-left opacity-60 dark:opacity-25 transition-opacity duration-300 " 
            style="background-image: url('{{ asset('images/sedan-black.png') }}'); background-size: 55%;">
        </div>
        <div class="absolute z-10 inset-0 bg-contain bg-no-repeat bg-right opacity-60 dark:opacity-25 transition-opacity duration-300 " 
            style="background-image: url('{{ asset('images/sedan.png') }}'); background-size: 55%;">
        </div>
        <div class="relative z-20 pt-32 text-center max-w-3xl mx-auto px-6">
            <flux:heading size="xl" class="font-extrabold uppercase md:text-4xl text-black dark:text-white drop-shadow-md">Drive Your Dream Car Today</flux:heading>
            <p class="text-lg text-zinc-700 dark:text-zinc-400 mt-4">
                Experience luxury and comfort with our premium car rental service. 
                Affordable rates, top-tier models, and seamless booking.
            </p>
            <div class="mt-6 flex flex-wrap justify-center gap-4">
                <flux:button href="/rent-a-car" variant="primary" class="px-6 py-3 text-lg">Book Now</flux:button>
                <flux:button href="/vehicles" variant="outline" class="px-6 py-3 text-lg text-white border-white dark:border-zinc-500 hover:bg-white dark:hover:bg-zinc-800 hover:text-black dark:hover:text-white transition-all">
                    Browse Cars
                </flux:button>
            </div>
        </div>
    </div>

    <!-- Why Choose Us -->
    <div class="py-16 bg-white dark:bg-zinc-900">
        <div class="container mx-auto px-6 text-center">
            <flux:heading size="xl" class="font-bold text-zinc-800 dark:text-white">Why Choose Us?</flux:heading>
            <p class="text-lg text-zinc-600 dark:text-zinc-300 mt-4">
                We offer the best car rental service with flexible plans and top-tier support.
            </p>

            <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-6 bg-zinc-100 dark:bg-zinc-800 rounded-lg shadow-md hover:shadow-lg transition">
                    <flux:icon.car-front class="text-primary size-10 mx-auto" />
                    <h3 class="text-xl font-semibold mt-4 text-zinc-800 dark:text-white">Wide Selection</h3>
                    <p class="text-zinc-600 dark:text-zinc-300 mt-2">Choose from luxury sedans, SUVs, and sports cars.</p>
                </div>

                <div class="p-6 bg-zinc-100 dark:bg-zinc-800 rounded-lg shadow-md hover:shadow-lg transition">
                    <flux:icon.clock class="text-primary size-10 mx-auto" />
                    <h3 class="text-xl font-semibold mt-4 text-zinc-800 dark:text-white">24/7 Support</h3>
                    <p class="text-zinc-600 dark:text-zinc-300 mt-2">We're here for you anytime, anywhere.</p>
                </div>

                <div class="p-6 bg-zinc-100 dark:bg-zinc-800 rounded-lg shadow-md hover:shadow-lg transition">
                    <flux:icon.circle-dollar-sign class="text-primary size-10 mx-auto" />
                    <h3 class="text-xl font-semibold mt-4 text-zinc-800 dark:text-white">Best Prices</h3>
                    <p class="text-zinc-600 dark:text-zinc-300 mt-2">Get the best deals on high-end vehicles.</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
