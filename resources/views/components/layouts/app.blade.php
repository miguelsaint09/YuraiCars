<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
        <title>{{ $title ?? 'YuraiCars' }}</title>
        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @fluxAppearance
    </head>
    <body class="bg-white dark:bg-neutral-900">
        <livewire:navbar />
        <main class="container mx-auto min-h-dvh border-x border-neutral-200 dark:border-neutral-700 ">
            {{ $slot }}
        </main>
        <livewire:footer />
        <livewire:ui.toast />
        @livewireScripts
        @fluxScripts
    </body>
</html>
