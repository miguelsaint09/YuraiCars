<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
        <title>{{ $title ?? 'YuraiCars' }}</title>
        @livewireStyles
        
        {{-- Laravel Mix Assets --}}
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        
        @stack('styles')
    </head>
    <body class="min-h-screen bg-white text-gray-900 antialiased relative">
        <div class="flex min-h-screen flex-col">
            <livewire:navbar />
            <main class="flex-1">
                {{ $slot }}
            </main>
            <livewire:footer />
        </div>
        <livewire:ui.toast />
        
        @livewireScripts
        @fluxScripts
        
        {{-- Laravel Mix JavaScript --}}
        <script src="{{ mix('js/app.js') }}"></script>
        
        @stack('scripts')
    </body>
</html>
