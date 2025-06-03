<x-layouts.app title="Sobre Nosotros">
    <div class="relative py-16 bg-zinc-50 dark:bg-zinc-900 overflow-hidden">
        <!-- Background Animation -->
        <div class="absolute inset-0 opacity-30">
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-full max-w-6xl h-80 bg-gradient-to-r from-emerald-500 to-blue-500 rounded-full blur-3xl opacity-50"></div>
        </div>
    
        <div class="container mx-auto px-6 relative">
            <!-- Title Section -->
            <div class="text-center">
                <flux:heading size="xl" class="font-bold text-zinc-800 dark:text-white">Sobre Nosotros</flux:heading>
                <p class="mt-4 text-zinc-600 dark:text-zinc-300 max-w-2xl mx-auto">
                    En <span class="font-semibold text-emerald-500">YuraiCars</span>, ofrecemos la mejor experiencia de alquiler de vehículos, 
                    con una amplia selección de autos premium a tarifas inmejorables. Garantizamos 
                    seguridad, confiabilidad y comodidad en tus viajes.
                </p>
            </div>
    
            <!-- Feature Sections -->
            <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="flex items-center space-x-4 p-6 bg-white dark:bg-black rounded-lg shadow-md transition hover:scale-105">
                    <flux:icon.rocket class="text-emerald-500 size-10" />
                    <div>
                        <flux:heading>Reserva Rápida y Fácil</flux:heading>
                        <p class="text-zinc-600 dark:text-zinc-400 text-sm">
                            Reserva tu viaje en solo unos clics con nuestro proceso en línea sin complicaciones.
                        </p>
                    </div>
                </div>
    
                <!-- Feature 2 -->
                <div class="flex items-center space-x-4 p-6 bg-white dark:bg-black rounded-lg shadow-md transition hover:scale-105">
                    <flux:icon.shield-check class="text-blue-500 size-10" />
                    <div>
                        <flux:heading>Seguro y Protegido</flux:heading>
                        <p class="text-zinc-600 dark:text-zinc-400 text-sm">
                            Tu seguridad es nuestra prioridad. Nuestros vehículos están bien mantenidos y asegurados.
                        </p>
                    </div>
                </div>
    
                <!-- Feature 3 -->
                <div class="flex items-center space-x-4 p-6 bg-white dark:bg-black rounded-lg shadow-md transition hover:scale-105">
                    <flux:icon.globe class="text-orange-500 size-10" />
                    <div>
                        <flux:heading>Cobertura Nacional</flux:heading>
                        <p class="text-zinc-600 dark:text-zinc-400 text-sm">
                            Conduce a cualquier parte con confianza, sabiendo que tenemos cobertura para ti.
                        </p>
                    </div>
                </div>
            </div>
    
        </div>
    </div>
</x-layouts.app>