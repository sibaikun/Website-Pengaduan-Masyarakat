<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased" style="background: linear-gradient(135deg, #f87171 0%, #ef4444 25%, #ec2e2e 50%, #b91c1c 75%, #d74a4a 100%); min-height: 100vh;">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
        <!-- Logo Container -->
        <div class="bg-white/20 backdrop-blur-md rounded-2xl p-6 mb-6 shadow-2xl border border-white/20">
            <a href="/">
                <x-application-logo class="w-18 h-18 fill-current text-white filter drop-shadow-xl" />
            </a>
        </div>
        
        <!-- Title -->
        <div class="text-center mb-8">
            <h1 class="text-white text-3xl font-bold drop-shadow-2xl mb-2">Kelurahan Sawah Besar</h1>
            <p class="text-white text-sm drop-shadow-lg">Sistem Pengaduan Penduduk</p>
        </div>

        <!-- Form card dengan jarak dalam yang lebih besar -->
        <div class="w-full sm:max-w-lg lg:max-w-xl mt-6 px-12 py-10 bg-white shadow-2xl overflow-hidden rounded-2xl border border-gray-200">
            <div class="px-6 py-4 space-y-8">
                {{ $slot }}
            </div>
        </div>
        
        <!-- Footer -->
        <p class="text-white text-xs mt-6 drop-shadow-lg">© 2025 Kelurahan Sawah Besar - Kota Semarang</p>
    </div>
</body>
</html>