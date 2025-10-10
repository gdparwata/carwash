<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CuciCar') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-teal-400 text-white">
            <div class="p-6">
                <h1 class="text-2xl font-bold">cucicar</h1>
            </div>
            <nav class="mt-8">
                <div class="px-4 space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-teal-500 {{ request()->routeIs('dashboard') ? 'bg-teal-500' : '' }}">
                        <i class="w-5 h-5 mr-3">📊</i>
                        Dashboard
                    </a>
                    <a href="{{ route('bookings.index') }}" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-teal-500 {{ request()->routeIs('bookings.*') ? 'bg-teal-500' : '' }}">
                        <i class="w-5 h-5 mr-3">📋</i>
                        Booking
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-teal-500">
                        <i class="w-5 h-5 mr-3">👥</i>
                        Data User
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-teal-500">
                        <i class="w-5 h-5 mr-3">✏️</i>
                        Edit Data
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-teal-500">
                        <i class="w-5 h-5 mr-3">📄</i>
                        Artikel
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-sm rounded-lg hover:bg-teal-500">
                        <i class="w-5 h-5 mr-3">👤</i>
                        Profile
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            @yield('content')
        </div>
    </div>
</body>
</html>
