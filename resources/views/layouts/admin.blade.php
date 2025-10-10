<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title', 'Dashboard')</title>
    
    <!-- CSRF Token untuk AJAX/fetch -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome untuk Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="flex bg-gray-100 min-h-screen">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-slate-800 text-white flex flex-col shadow-2xl">
        <div class="p-6 text-2xl font-bold border-b border-slate-700 bg-gradient-to-r from-cyan-600 to-blue-600">
            <div class="flex items-center">
                <i class="fas fa-car-wash mr-3"></i>
                CuciCar
            </div>
        </div>
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" 
                class="flex items-center px-4 py-3 rounded-lg hover:bg-slate-700 transition duration-200 {{ request()->is('dashboard') ? 'bg-slate-700 border-l-4 border-cyan-400' : '' }}">
                <i class="fas fa-chart-line w-5 mr-3"></i>
                <span>Dashboard</span>
            </a>
            
            <!-- Booking -->
            <a href="{{ route('admin.bookings.index') }}" 
                class="flex items-center px-4 py-3 rounded-lg hover:bg-slate-700 transition duration-200 {{ request()->is('admin/bookings*') ? 'bg-slate-700 border-l-4 border-cyan-400' : '' }}">
                <i class="fas fa-calendar-check w-5 mr-3"></i>
                <span>Booking</span>
            </a>
            
            <!-- Data User -->
            <a href="{{ route('admin.users.index') }}" 
                class="flex items-center px-4 py-3 rounded-lg hover:bg-slate-700 transition duration-200 {{ request()->is('admin/users*') ? 'bg-slate-700 border-l-4 border-cyan-400' : '' }}">
                <i class="fas fa-users w-5 mr-3"></i>
                <span>Data User</span>
            </a>
            
            <!-- Artikel -->
            <a href="{{ route('admin.blogs.index') }}" 
                class="flex items-center px-4 py-3 rounded-lg hover:bg-slate-700 transition duration-200 {{ request()->is('admin/blogs*') ? 'bg-slate-700 border-l-4 border-cyan-400' : '' }}">
                <i class="fas fa-newspaper w-5 mr-3"></i>
                <span>Artikel</span>
            </a>
            
            <!-- Divider -->
            <div class="border-t border-slate-700 my-4"></div>
            
            <!-- Profile -->
            <a href="{{ route('admin.profile.show') }}" 
                class="flex items-center px-4 py-3 rounded-lg hover:bg-slate-700 transition duration-200 {{ request()->is('admin/profile*') || request()->is('profile*') ? 'bg-slate-700 border-l-4 border-cyan-400' : '' }}">
                <i class="fas fa-user-circle w-5 mr-3"></i>
                <span>Profile</span>
            </a>
        </nav>
        
        <!-- Logout Button -->
        <div class="p-4 border-t border-slate-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 px-4 py-3 rounded-lg font-semibold shadow-lg transform hover:scale-105 transition duration-200 flex items-center justify-center">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    Logout
                </button>
            </form>
        </div>
    </aside>
    
    <!-- Main content -->
    <main class="flex-1 flex flex-col overflow-hidden">
        <!-- Topbar -->
        <header class="bg-white shadow-lg rounded-b-2xl p-4 mb-6 flex justify-between items-center sticky top-0 z-10">
            <h1 class="text-2xl font-bold text-slate-800">
                @yield('title', 'Dashboard')
            </h1>
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <p class="text-sm text-gray-500">Welcome,</p>
                    <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                </div>
                <a href="{{ route('admin.profile.show') }}">
                    @if(Auth::user()->foto_profile)
                    <img src="{{ asset('storage/' . Auth::user()->foto_profile) }}" 
                         class="w-12 h-12 rounded-full border-2 border-cyan-500 shadow-lg hover:scale-110 transition duration-200 cursor-pointer object-cover" 
                         alt="avatar">
                    @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=667eea&color=fff" 
                         class="w-12 h-12 rounded-full border-2 border-cyan-500 shadow-lg hover:scale-110 transition duration-200 cursor-pointer" 
                         alt="avatar">
                    @endif
                </a>
            </div>
        </header>
        
        <!-- Page content -->
        <div class="flex-1 overflow-y-auto px-6 pb-6">
            @yield('content')
        </div>
    </main>

</body>
</html>