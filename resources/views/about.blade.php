<x-layouts.app title="About us">
    <div class="relative py-16 bg-zinc-50 dark:bg-zinc-900 overflow-hidden">
        <!-- Background Animation -->
        <div class="absolute inset-0 opacity-30">
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-full max-w-6xl h-80 bg-gradient-to-r from-emerald-500 to-blue-500 rounded-full blur-3xl opacity-50"></div>
        </div>
    
        <div class="container mx-auto px-6 relative">
            <!-- Title Section -->
            <div class="text-center">
                <flux:heading size="xl" class="font-bold text-zinc-800 dark:text-white">About Us</flux:heading>
                <p class="mt-4 text-zinc-600 dark:text-zinc-300 max-w-2xl mx-auto">
                    At <span class="font-semibold text-emerald-500">MyCarRental</span>, we provide the best vehicle rental experience, 
                    offering a wide selection of premium cars at unbeatable rates. We ensure 
                    safety, reliability, and convenience for your journeys.
                </p>
            </div>
    
            <!-- Feature Sections -->
            <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="flex items-center space-x-4 p-6 bg-white dark:bg-black rounded-lg shadow-md transition hover:scale-105">
                    <flux:icon.rocket class="text-emerald-500 size-10" />
                    <div>
                        <flux:heading>Fast & Easy Booking</flux:heading>
                        <p class="text-zinc-600 dark:text-zinc-400 text-sm">
                            Book your ride in just a few clicks with our seamless online process.
                        </p>
                    </div>
                </div>
    
                <!-- Feature 2 -->
                <div class="flex items-center space-x-4 p-6 bg-white dark:bg-black rounded-lg shadow-md transition hover:scale-105">
                    <flux:icon.shield-check class="text-blue-500 size-10" />
                    <div>
                        <flux:heading>Safe & Insured</flux:heading>
                        <p class="text-zinc-600 dark:text-zinc-400 text-sm">
                            Your safety is our priority. Our vehicles are well-maintained and insured.
                        </p>
                    </div>
                </div>
    
                <!-- Feature 3 -->
                <div class="flex items-center space-x-4 p-6 bg-white dark:bg-black rounded-lg shadow-md transition hover:scale-105">
                    <flux:icon.globe class="text-orange-500 size-10" />
                    <div>
                        <flux:heading>Nationwide Coverage</flux:heading>
                        <p class="text-zinc-600 dark:text-zinc-400 text-sm">
                            Drive anywhere with confidence, knowing we have you covered.
                        </p>
                    </div>
                </div>
            </div>
    
        </div>
    </div>
</x-layouts.app>