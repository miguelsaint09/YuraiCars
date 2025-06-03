<x-layouts.app title="YuraiCars">
    <!-- Hero Section -->
    <div class="relative h-[600px] bg-gradient-to-r from-black to-zinc-800 dark:from-black dark:to-zinc-900">
        <!-- Hero Image -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/hero-car.jpg') }}" alt="YuraiCars" class="w-full h-full object-cover opacity-50">
        </div>

        <!-- Content -->
        <div class="relative z-20 pt-32 text-center max-w-3xl mx-auto px-6">
            <flux:heading size="xl" class="font-extrabold uppercase md:text-4xl text-black dark:text-white drop-shadow-md">Conduce el Auto de tus Sueños Hoy</flux:heading>
            <p class="text-lg text-zinc-700 dark:text-zinc-400 mt-4">
                Experimenta el lujo y el confort con nuestro servicio premium de alquiler de autos.
                Tarifas asequibles, modelos de alta gama y reservas sin complicaciones.
            </p>
            <div class="mt-6 flex flex-wrap justify-center gap-4">
                <flux:button href="/rent-a-car" variant="primary" class="px-6 py-3 text-lg">Reservar Ahora</flux:button>
                <flux:button href="/vehicles" variant="outline" class="px-6 py-3 text-lg text-white border-white dark:border-zinc-500 hover:bg-white dark:hover:bg-zinc-800 hover:text-black dark:hover:text-white transition-all">
                    Ver Autos
                </flux:button>
            </div>
        </div>
    </div>

    <!-- Why Choose Us -->
    <div class="py-16 bg-white dark:bg-zinc-900">
        <div class="container mx-auto px-6 text-center">
            <flux:heading size="xl" class="font-bold text-zinc-800 dark:text-white">¿Por qué elegirnos?</flux:heading>
            <p class="text-lg text-zinc-600 dark:text-zinc-300 mt-4">
                Ofrecemos el mejor servicio de alquiler de autos con planes flexibles y soporte de primera.
            </p>

            <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-6 bg-zinc-100 dark:bg-zinc-800 rounded-lg shadow-md hover:shadow-lg transition">
                    <flux:icon.car-front class="text-primary size-10 mx-auto" />
                    <h3 class="text-xl font-semibold mt-4 text-zinc-800 dark:text-white">Amplia Selección</h3>
                    <p class="text-zinc-600 dark:text-zinc-300 mt-2">Elige entre sedanes de lujo, SUVs y autos deportivos.</p>
                </div>

                <div class="p-6 bg-zinc-100 dark:bg-zinc-800 rounded-lg shadow-md hover:shadow-lg transition">
                    <flux:icon.clock class="text-primary size-10 mx-auto" />
                    <h3 class="text-xl font-semibold mt-4 text-zinc-800 dark:text-white">Soporte 24/7</h3>
                    <p class="text-zinc-600 dark:text-zinc-300 mt-2">Estamos aquí para ti en cualquier momento y lugar.</p>
                </div>

                <div class="p-6 bg-zinc-100 dark:bg-zinc-800 rounded-lg shadow-md hover:shadow-lg transition">
                    <flux:icon.circle-dollar-sign class="text-primary size-10 mx-auto" />
                    <h3 class="text-xl font-semibold mt-4 text-zinc-800 dark:text-white">Mejores Precios</h3>
                    <p class="text-zinc-600 dark:text-zinc-300 mt-2">Obtén las mejores ofertas en vehículos de alta gama.</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
