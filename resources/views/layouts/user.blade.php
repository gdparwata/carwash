<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CuciCar')</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome untuk Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Custom hover effect */
        .nav-link {
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -8px;
            left: 50%;
            background-color: #0891b2;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }
    </style>
</head>
<body class="bg-gray-50">
    
    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('welcome') }}" class="flex items-center">
                        <span class="text-2xl font-bold">
                            <span class="text-gray-800">cuci</span><span class="text-cyan-600">car</span>
                        </span>
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex md:items-center md:space-x-8">
                    <a href="{{ route('welcome') }}" 
                       class="nav-link text-gray-700 hover:text-cyan-600 font-medium transition duration-200 {{ request()->is('/') ? 'active text-cyan-600' : '' }}">
                        Cuci Mobil
                    </a>
                    <a href="#" 
                       class="nav-link text-gray-700 hover:text-cyan-600 font-medium transition duration-200">
                        Paket Banjir
                    </a>
                    <a href="#" 
                       class="nav-link text-gray-700 hover:text-cyan-600 font-medium transition duration-200">
                        Salon Mobil
                    </a>
                    <a href="#" 
                       class="nav-link text-gray-700 hover:text-cyan-600 font-medium transition duration-200">
                        Paket Harga
                    </a>
                    <a href="#" 
                       class="nav-link text-gray-700 hover:text-cyan-600 font-medium transition duration-200">
                        History
                    </a>
                    <a href="{{ route('blogs.index') }}" 
                       class="nav-link text-gray-700 hover:text-cyan-600 font-medium transition duration-200 {{ request()->is('blog*') ? 'active text-cyan-600' : '' }}">
                        Blog
                    </a>
                    <a href="#" 
                       class="nav-link text-gray-700 hover:text-cyan-600 font-medium transition duration-200">
                        About us
                    </a>
                    
                    @auth
                    <a href="{{ route('profile.show') }}" 
                       class="nav-link text-gray-700 hover:text-cyan-600 font-medium transition duration-200 {{ request()->is('profile*') ? 'active text-cyan-600' : '' }}">
                        Profile
                    </a>
                    @endauth
                </div>
                
                <!-- Right Side (Button & Mobile Menu) -->
                <div class="flex items-center space-x-4">
                    @auth
                    <!-- Pesan Sekarang Button -->
                    <a href="{{ route('bookings.create') }}" 
                       class="hidden md:block bg-gradient-to-r from-cyan-600 to-blue-600 text-white px-6 py-2 rounded-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-300">
                        Pesan Sekarang
                    </a>
                    
                    <!-- User Avatar -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                            @if(Auth::user()->foto_profile)
                            <img src="{{ asset('storage/' . Auth::user()->foto_profile) }}" 
                                 class="w-10 h-10 rounded-full border-2 border-cyan-500 object-cover hover:scale-110 transition duration-200" 
                                 alt="avatar">
                            @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0891b2&color=fff" 
                                 class="w-10 h-10 rounded-full border-2 border-cyan-500 hover:scale-110 transition duration-200" 
                                 alt="avatar">
                            @endif
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 z-50">
                            <div class="px-4 py-2 border-b border-gray-200">
                                <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('dashboard') }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-cyan-50 transition duration-200">
                                <i class="fas fa-th-large mr-2"></i> Dashboard
                            </a>
                            <a href="{{ route('profile.show') }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-cyan-50 transition duration-200">
                                <i class="fas fa-user mr-2"></i> Profile
                            </a>
                            <a href="{{ route('bookings.create') }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-cyan-50 transition duration-200">
                                <i class="fas fa-calendar-plus mr-2"></i> Booking
                            </a>
                            <hr class="my-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition duration-200">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <!-- Login/Register Buttons -->
                    <a href="{{ route('login') }}" 
                       class="hidden md:block text-gray-700 hover:text-cyan-600 font-semibold transition duration-200">
                        Login
                    </a>
                    <a href="{{ route('register') }}" 
                       class="hidden md:block bg-gradient-to-r from-cyan-600 to-blue-600 text-white px-6 py-2 rounded-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-300">
                        Register
                    </a>
                    @endauth
                    
                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="md:hidden text-gray-700 hover:text-cyan-600 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform -translate-y-4"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             class="md:hidden bg-white border-t border-gray-200">
            <div class="px-4 pt-2 pb-4 space-y-2">
                <a href="{{ route('welcome') }}" 
                   class="block px-4 py-2 text-gray-700 hover:bg-cyan-50 rounded-lg transition duration-200">
                    Cuci Mobil
                </a>
                <a href="#" 
                   class="block px-4 py-2 text-gray-700 hover:bg-cyan-50 rounded-lg transition duration-200">
                    Paket Banjir
                </a>
                <a href="#" 
                   class="block px-4 py-2 text-gray-700 hover:bg-cyan-50 rounded-lg transition duration-200">
                    Salon Mobil
                </a>
                <a href="#" 
                   class="block px-4 py-2 text-gray-700 hover:bg-cyan-50 rounded-lg transition duration-200">
                    Paket Harga
                </a>
                <a href="#" 
                   class="block px-4 py-2 text-gray-700 hover:bg-cyan-50 rounded-lg transition duration-200">
                    History
                </a>
                <a href="{{ route('blogs.index') }}" 
                   class="block px-4 py-2 text-gray-700 hover:bg-cyan-50 rounded-lg transition duration-200">
                    Blog
                </a>
                <a href="#" 
                   class="block px-4 py-2 text-gray-700 hover:bg-cyan-50 rounded-lg transition duration-200">
                    About us
                </a>
                
                @auth
                <a href="{{ route('profile.show') }}" 
                   class="block px-4 py-2 text-gray-700 hover:bg-cyan-50 rounded-lg transition duration-200">
                    Profile
                </a>
                <a href="{{ route('bookings.create') }}" 
                   class="block px-4 py-2 bg-gradient-to-r from-cyan-600 to-blue-600 text-white rounded-lg text-center font-semibold">
                    Pesan Sekarang
                </a>
                @else
                <a href="{{ route('login') }}" 
                   class="block px-4 py-2 text-gray-700 hover:bg-cyan-50 rounded-lg transition duration-200 text-center">
                    Login
                </a>
                <a href="{{ route('register') }}" 
                   class="block px-4 py-2 bg-gradient-to-r from-cyan-600 to-blue-600 text-white rounded-lg text-center font-semibold">
                    Register
                </a>
                @endauth
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer (Optional) -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-xl font-bold mb-2">
                    <span class="text-white">cuci</span><span class="text-cyan-400">car</span>
                </p>
                <p class="text-gray-400 text-sm">© 2024 CuciCar. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- Alpine.js untuk Dropdown & Mobile Menu -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        // Initialize Alpine data
        document.addEventListener('alpine:init', () => {
            Alpine.data('navbar', () => ({
                mobileMenuOpen: false
            }))
        })
    </script>

</body>
</html>