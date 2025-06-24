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
    <link rel="shortcut icon" href="{{asset('images/logo.jpg')}}" type="image/x-icon">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <!-- Background dengan gambar -->
    <div class="fixed inset-0 -z-10">
        <img
            src="/images/back.jpg"
            alt="Background"
            class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/30 backdrop-blur-sm"></div>
    </div>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="relative w-full sm:max-w-md px-6 py-10">
            <!-- Logo dengan white glow -->
            <div class="flex justify-center mb-8">
                <a href="/" class="flex items-center space-x-3">
                    <x-application-logo />
                </a>
            </div>

            <!-- Card dengan glass effect -->
            <div class="backdrop-blur-md bg-white/20 rounded-2xl shadow-xl overflow-hidden border border-white/20">
                <div class="px-8 py-10">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer links -->
            <div class="mt-6 text-center text-white/80 text-sm drop-shadow-sm">
                <a href="#" class="hover:text-white transition">Terms of Service</a>
                <span class="mx-2">•</span>
                <a href="#" class="hover:text-white transition">Privacy Policy</a>
            </div>
        </div>
    </div>
</body>

</html>