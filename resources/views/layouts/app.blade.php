<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Reservas Autocaravanas') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Styles -->
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <x-banner />
    
    <div class="min-h-screen">
        @livewire('navigation-menu')
        
        <!-- Page Content -->
        <main class="container mx-auto px-4 py-8">
            {{ $slot }}
        </main>
    </div>
    
    @stack('modals')
    @livewireScripts
</body>
</html>
