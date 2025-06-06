@props(['vehicle'])

<div class="relative group" wire:key="vehicle-{{ $vehicle->id }}">
    <div class="relative rounded-2xl overflow-hidden border border-white/10 bg-black/20">
        @if($vehicle->image_url && is_array($vehicle->image_url) && !empty($vehicle->image_url))
            <img 
                src="{{ Storage::url($vehicle->image_url[0]) }}" 
                class="w-full aspect-[16/9] object-cover"
                alt="{{ $vehicle->name }}"
            />
        @else
            <img 
                src="{{ asset('images/sedan.png') }}" 
                class="w-full aspect-[16/9] object-cover"
                alt="{{ $vehicle->name }}"
            />
        @endif

        <!-- Info Button -->
        <button 
            type="button"
            wire:click="$emitUp('openModal', {{ $vehicle->id }})"
            class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center text-white hover:bg-white/20 transition-colors"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </button>
    </div>

    <div class="mt-4 space-y-3">
        <div>
            <h3 class="text-xl font-bold text-white">{{ $vehicle->name }}</h3>
            <p class="text-zinc-400">{{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }}</p>
        </div>

        <div class="flex flex-wrap gap-2">
            <div class="flex items-center gap-1 px-3 py-1 rounded-lg bg-white/5 border border-white/10">
                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 4H5a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 14v4a2 2 0 002 2h6a2 2 0 002-2v-4"></path>
                </svg>
                <span class="text-sm text-white">{{ $vehicle->seats }} Asientos</span>
            </div>

            <div class="flex items-center gap-1 px-3 py-1 rounded-lg bg-white/5 border border-white/10">
                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <span class="text-sm text-white">{{ $vehicle->luggage }} Maletas</span>
            </div>

            <div class="flex items-center gap-1 px-3 py-1 rounded-lg bg-white/5 border border-white/10">
                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                </svg>
                <span class="text-sm text-white">{{ $vehicle->transmission === 'automatic' ? 'Auto' : 'Manual' }}</span>
            </div>

            <div class="flex items-center gap-1 px-3 py-1 rounded-lg bg-white/5 border border-white/10">
                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                <span class="text-sm text-white">{{ $vehicle->fuel_type === 'gasoline' ? 'Gasolina' : 'Diésel' }}</span>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div>
                <span class="block text-sm text-zinc-400">Tarifa por día</span>
                <span class="text-2xl font-bold bg-gradient-to-r from-purple-400 to-indigo-400 bg-clip-text text-transparent">
                    ${{ number_format($vehicle->price_per_day, 2) }} DOP
                </span>
            </div>
            <button 
                type="button"
                wire:click="$emitUp('selectVehicle', {{ $vehicle->id }})"
                class="h-12 px-6 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] flex items-center gap-2"
            >
                <span>Seleccionar</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </div>
</div> 