<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CuciCar')</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
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

        /* Hamburger animation */
        .hamburger-line {
            transition: all 0.3s ease;
        }
        .hamburger-active .line1 {
            transform: rotate(45deg) translate(5px, 5px);
        }
        .hamburger-active .line2 {
            opacity: 0;
        }
        .hamburger-active .line3 {
            transform: rotate(-45deg) translate(7px, -6px);
        }
    </style>
</head>
<body class="bg-gray-50">
    
    <header class="bg-white shadow-sm" x-data="{ mobileMenuOpen: false }">
        <div class="container mx-auto px-4 sm:px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-teal-600">cucicar</span>
                </div>
                
                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex space-x-6 xl:space-x-8">
                    <a href="{{ route('cucimobil') }}" class="nav-link text-gray-600 hover:text-teal-600 transition-colors">Cuci Mobil</a>
                    <a href="{{ route('paketbanjir') }}" class="nav-link text-gray-600 hover:text-teal-600 transition-colors">Paket Banjir</a>
                    <a href="{{ route('salonmobil') }}" class="nav-link text-gray-600 hover:text-teal-600 transition-colors">Salon Mobil</a>
                    <a href="{{ route('paket.public') }}" class="nav-link text-gray-600 hover:text-teal-600 transition-colors">Paket Harga</a>
                    <a href="{{ route('blogs.index') }}" class="nav-link text-gray-600 hover:text-teal-600 transition-colors">Blog</a>
                    <a href="{{ route('aboutus') }}" class="nav-link text-gray-600 hover:text-teal-600 transition-colors">About us</a>
                    <a href="{{ route('profile.show') }}" class="nav-link text-gray-600 hover:text-teal-600 transition-colors">Profile</a>
                </nav>
                
                <!-- Right Side -->
                <div class="flex items-center space-x-3">
                    <!-- Desktop CTA Button -->
                    <a href="{{ route('bookings.create') }}" 
                       class="hidden sm:inline-block bg-blue-600 text-white font-semibold px-4 sm:px-6 py-2 rounded-full shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 text-sm">
                        Pesan Sekarang
                    </a>

                    <!-- Hamburger Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors"
                            :class="{ 'hamburger-active': mobileMenuOpen }">
                        <div class="w-6 h-5 flex flex-col justify-between">
                            <span class="hamburger-line line1 w-full h-0.5 bg-gray-600 rounded"></span>
                            <span class="hamburger-line line2 w-full h-0.5 bg-gray-600 rounded"></span>
                            <span class="hamburger-line line3 w-full h-0.5 bg-gray-600 rounded"></span>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform -translate-y-4"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-4"
             @click.away="mobileMenuOpen = false"
             class="lg:hidden bg-white border-t border-gray-200 shadow-lg">
            <div class="px-4 pt-2 pb-4 space-y-1">
                <a href="{{ route('cucimobil') }}" 
                   class="block px-4 py-3 text-gray-700 hover:bg-teal-50 hover:text-teal-600 rounded-lg transition duration-200">
                    Cuci Mobil
                </a>
                <a href="{{ route('paketbanjir') }}" 
                   class="block px-4 py-3 text-gray-700 hover:bg-teal-50 hover:text-teal-600 rounded-lg transition duration-200">
                    Paket Banjir
                </a>
                <a href="{{ route('salonmobil') }}" 
                   class="block px-4 py-3 text-gray-700 hover:bg-teal-50 hover:text-teal-600 rounded-lg transition duration-200">
                    Salon Mobil
                </a>
                <a href="{{ route('paket.public') }}" 
                   class="block px-4 py-3 text-gray-700 hover:bg-teal-50 hover:text-teal-600 rounded-lg transition duration-200">
                    Paket Harga
                </a>
                <a href="{{ route('blogs.index') }}" 
                   class="block px-4 py-3 text-gray-700 hover:bg-teal-50 hover:text-teal-600 rounded-lg transition duration-200">
                    Blog
                </a>
                <a href="{{ route('aboutus') }}" 
                   class="block px-4 py-3 text-gray-700 hover:bg-teal-50 hover:text-teal-600 rounded-lg transition duration-200">
                    About us
                </a>
                
                @auth
                <a href="{{ route('profile.show') }}" 
                   class="block px-4 py-3 text-gray-700 hover:bg-teal-50 hover:text-teal-600 rounded-lg transition duration-200">
                    Profile
                </a>
                <a href="{{ route('bookings.create') }}" 
                   class="block px-4 py-3 bg-blue-600 text-white rounded-lg text-center font-semibold shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 mt-2">
                    Pesan Sekarang
                </a>
                @else
                <a href="{{ route('login') }}" 
                   class="block px-4 py-3 text-gray-700 hover:bg-teal-50 hover:text-teal-600 rounded-lg transition duration-200 text-center">
                    Login
                </a>
                <a href="{{ route('register') }}" 
                   class="block px-4 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg text-center font-semibold shadow-md mt-2">
                    Register
                </a>
                @endauth
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-100 py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-2xl font-bold text-teal-600 mb-4">cucicar</h3>
                    <p class="text-sm text-gray-600 mb-2">Jl. Akasia Gang rama 4 blok a.</p>
                    <p class="text-sm text-gray-600 mb-4">Denpasar timur, Denpasar, Bali, Indonesia.</p>
                    
                    <h4 class="font-bold text-gray-800 mb-2">Wilayah Operasional</h4>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• Denpasar</li>
                        <li>• Badung</li>
                        <li>• Karangasem</li>
                    </ul>
                </div>

                <!-- Services -->
                <div>
                    <h4 class="font-bold text-gray-800 mb-4">Layanan</h4>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li><a href="{{ route('cucimobil') }}" class="hover:text-teal-600">Cuci mobil</a></li>
                        <li><a href="{{ route('paketbanjir') }}" class="hover:text-teal-600">Paket banjir</a></li>
                        <li><a href="{{ route('salonmobil') }}" class="hover:text-teal-600">Salon mobil</a></li>
                    </ul>
                </div>

                <!-- Information -->
                <div>
                    <h4 class="font-bold text-gray-800 mb-4">Informasi</h4>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li><a href="{{ route('aboutus') }}" class="hover:text-teal-600">About Us</a></li>
                        <li><a href="{{ route('blogs.index') }}" class="hover:text-teal-600">Blog</a></li>
                    </ul>
                </div>

                <!-- Rating -->
                <div>
                    <h4 class="font-bold text-gray-800 mb-4">Google rating</h4>
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl font-bold text-gray-800">4.8</span>
                        <div class="flex text-yellow-400">
                            <span>⭐⭐⭐⭐⭐</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Alpine.js untuk Dropdown & Mobile Menu -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>
</html>