<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
        <title>{{ $title ?? 'YuraiCars' }}</title>
        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @fluxAppearance
        @stack('styles')
    </head>
    <body class="bg-black text-white antialiased">
        <livewire:navbar />
        <main class="min-h-dvh">
            {{ $slot }}
        </main>
        <livewire:footer />
        <livewire:ui.toast />
        @livewireScripts
        @fluxScripts
        @stack('scripts')
    </body>
</html>
