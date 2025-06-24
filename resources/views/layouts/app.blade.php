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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="shortcut icon" href="{{asset('images/logo.jpg')}}" type="image/x-icon">
    <style>
        /* Sembunyikan progress bar */
        .toastify-progress {
            display: none !important;
        }
    </style>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Toastify({
                text: @json(session('success')),
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#22c55e", // hijau (Tailwind green-500)
                style: {
                    color: "white",
                    boxShadow: "0 2px 8px rgba(0,0,0,0.2)",
                    borderRadius: "0.375rem" // rounded-md
                }
            }).showToast();
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Toastify({
                text: @json(session('error')),
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#ef4444", // merah (Tailwind red-500)
                style: {
                    color: "white",
                    boxShadow: "0 2px 8px rgba(0,0,0,0.2)",
                    borderRadius: "0.375rem" // rounded-md
                }
            }).showToast();
        });
    </script>
    @endif

</body>

</html>