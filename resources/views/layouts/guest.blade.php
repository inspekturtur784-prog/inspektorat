<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Inspektorat Kota Mojokerto') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>

        <style>
            .login-bg {
                background-image: url("{{ asset('images/alun-alun.jpg') }}");
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                position: relative;
            }
            .login-bg::before {
                content: "";
                position: absolute;
                inset: 0;
                background: rgba(7, 26, 51, 0.25); /* Transparansi diturunkan agar foto terang */
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col justify-center items-center py-6 px-4 login-bg">
            
            <!-- Logo & Judul -->
            <div class="z-10 text-center mb-4">
                <a href="{{ url('/') }}" class="inline-flex flex-col items-center">
                    <img src="{{ asset('images/logo-mojokerto.png') }}" alt="Logo Kota Mojokerto" class="h-20 w-auto drop-shadow-md">
                    <h1 class="text-white text-xl font-bold mt-3 drop-shadow">Inspektorat Kota Mojokerto</h1>
                    <p class="text-gray-200 text-xs mt-1 drop-shadow">Login Panel Admin</p>
                </a>
            </div>

            <!-- Form Card -->
            <div class="w-full sm:max-w-md px-6 py-6 bg-white/95 backdrop-blur-md shadow-2xl rounded-2xl z-10 border border-white/20">
                {{ $slot }}
            </div>

            <!-- Tombol Kembali -->
            <div class="z-10 mt-6">
                <a href="{{ url('/') }}" class="text-sm font-medium text-white hover:text-amber-300 transition-colors drop-shadow">
                    &larr; Kembali ke Website
                </a>
            </div>

        </div>
    </body>
</html>