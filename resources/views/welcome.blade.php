<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cucicar - Cuci dan Salon Mobil Profesional</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hero-bg {
            background: linear-gradient(135deg, #4a90a4 0%, #5ba3b8 100%);
        }
        .testimonial-dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 2rem;
        }
        .testimonial-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.4);
            cursor: pointer;
        }
        .testimonial-dot.active {
            background-color: white;
        }
        .mobile-menu {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }
        .mobile-menu.active {
            transform: translateX(0);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm fixed w-full top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center">
                    <span class="text-xl sm:text-2xl font-bold text-teal-600">cucicar</span>
                </div>
                
                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex space-x-8">
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-teal-600">Cuci Mobil</a>
                    <a href="{{ route(name: 'login') }}" class="text-gray-600 hover:text-teal-600">Paket Banjir</a>
                    <a href="{{ route(name: 'login') }}" class="text-gray-600 hover:text-teal-600">Salon Mobil</a>
                    <a href="{{ route(name: 'login') }}" class="text-gray-600 hover:text-teal-600">Paket Harga</a>
                    <a href="{{ route(name: 'login') }}" class="text-gray-600 hover:text-teal-600">Blog</a>
                    <a href="{{ route(name: 'login') }}" class="text-gray-600 hover:text-teal-600">About us</a>
                </nav>
                
                <!-- Desktop Auth Buttons -->
                <div class="hidden lg:flex space-x-3">
                    <a href="{{ route(name: 'login') }}" class="bg-blue-500 text-white font-semibold px-6 py-2 rounded-full shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                        Login
                    </a>
                    <a href="{{ route(name: 'register') }}" class="bg-blue-500 text-white font-semibold px-6 py-2 rounded-full shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                        Register
                    </a>
                </div>

                <!-- Hamburger Button -->
                <button id="hamburger" class="lg:hidden p-2 rounded-md hover:bg-gray-100 focus:outline-none">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="mobile-menu fixed top-0 left-0 w-64 h-full bg-white shadow-xl lg:hidden z-50">
            <div class="p-6">
                <div class="flex items-center justify-between mb-8">
                    <span class="text-2xl font-bold text-teal-600">cucicar</span>
                    <button id="closeMenu" class="p-2 rounded-md hover:bg-gray-100">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <nav class="flex flex-col space-y-4 mb-8">
                    <a href="{{ route(name: 'login') }}" class="text-gray-600 hover:text-teal-600 py-2">Cuci Mobil</a>
                    <a href="{{ route(name: 'login') }}" class="text-gray-600 hover:text-teal-600 py-2">Paket Banjir</a>
                    <a href="{{ route(name: 'login') }}" class="text-gray-600 hover:text-teal-600 py-2">Salon Mobil</a>
                    <a href="{{ route(name: 'login') }}" class="text-gray-600 hover:text-teal-600 py-2">Paket Harga</a>
                    <a href="{{ route(name: 'login') }}" class="text-gray-600 hover:text-teal-600 py-2">Blog</a>
                    <a href="{{ route(name: 'login') }}" class="text-gray-600 hover:text-teal-600 py-2">About us</a>
                </nav>

                <div class="flex flex-col space-y-3">
                    <a href="{{ route(name: 'login') }}" class="bg-blue-500 text-white font-semibold px-6 py-2 rounded-full shadow-md hover:shadow-lg text-center">
                        Login
                    </a>
                    <a href="{{ route(name: 'register') }}" class="bg-blue-500 text-white font-semibold px-6 py-2 rounded-full shadow-md hover:shadow-lg text-center">
                        Register
                    </a>
                </div>
            </div>
        </div>

        <!-- Overlay -->
        <div id="overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"></div>
    </header>

    <!-- Spacer for fixed header -->
    <div class="h-16 sm:h-20"></div>

    <!-- Hero Section -->
    <section class="hero-bg flex items-center relative overflow-hidden min-h-[400px] sm:min-h-[500px] lg:h-[600px] bg-cover bg-center"
         style="background-image: url('/storage/images/bg.png');">
        <div class="container mx-auto px-4 sm:px-6 lg:px-10 py-12 sm:py-16 lg:py-20 z-10">
            <div class="max-w-xl">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4 leading-tight">
                    Cuci dan <br> Salon Mobil <br> Profesional
                </h1>
                <p class="text-white mb-6 text-sm sm:text-base">
                    Cukup Pesan lewat rumah, sudah tidak perlu antri lama
                </p>
                <a href="{{ route(name: 'login') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-700 transition inline-block text-sm sm:text-base">
                    Pelajari selengkapnya
                </a>
            </div>
        </div>
    </section>

    <!-- Info Section -->
    <section class="py-12 sm:py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 text-center">
            <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mb-4 px-2">
                Sekarang cuci mobil lebih mudah, karena sudah tidak perlu mengantri panjang dan lama lagi
            </h2>
            <p class="text-gray-600 mb-8 sm:mb-12 text-sm sm:text-base">Ribuan pelanggan dari Bali sudah menikmati web kami</p>
            
            <!-- Car Image -->
            <div class="mb-8 sm:mb-12 px-4">
                <img src="/storage/images/mobillanding.png" alt="BMW Car" class="mx-auto rounded-lg max-w-full h-auto">
            </div>

            <!-- Features -->
            <div class="hero-bg py-8 sm:py-12 rounded-lg mx-4">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-8 mb-6 sm:mb-8 px-4">
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl mb-2">✓</div>
                        <p class="text-xs sm:text-sm text-white">Cepat tanpa repot antri</p>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl mb-2">⚡</div>
                        <p class="text-xs sm:text-sm text-white">Kemanan mobil terjaga</p>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl mb-2">👥</div>
                        <p class="text-xs sm:text-sm text-white">Profesional dan cepat tanggap</p>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl mb-2">✨</div>
                        <p class="text-xs sm:text-sm text-white">Terpercaya dan Terbaik</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 lg:gap-8 px-4 max-w-2xl mx-auto">
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl mb-2">🛡️</div>
                        <p class="text-xs sm:text-sm text-white">Sabun atau Shampoo premium</p>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl mb-2">⭐</div>
                        <p class="text-xs sm:text-sm text-white">Sabun atau Shampoo premium</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 sm:mt-8">
                <a href="{{ route(name: 'login') }}" class="inline-block px-6 sm:px-8 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors text-sm sm:text-base">
                    Pesan Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-12 sm:py-16 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6">
            <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-center text-gray-800 mb-4 px-2">
                Pilihan paket lengkap. Atur jadwal dan cuci mobil anda sekarang.
            </h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 mt-8 sm:mt-12">
                <!-- Cuci Mobil -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="h-48 bg-gray-300">
                        <img src="/storage/images/paketcuci.png" alt="Cuci Mobil" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 hero-bg text-white">
                        <h3 class="text-lg font-bold mb-2">Cuci Mobil</h3>
                        <a href="{{ route(name: 'login') }}" class="text-blue-200 hover:text-blue-100 text-sm">pelajari selengkapnya</a>
                    </div>
                </div>

                <!-- Salon Mobil -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="h-48 bg-gray-300">
                        <img src="/storage/images/salonmobil.png" alt="Salon Mobil" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 hero-bg text-white">
                        <h3 class="text-lg font-bold mb-2">Salon Mobil</h3>
                        <a href="{{ route(name: 'login') }}" class="text-blue-200 hover:text-blue-100 text-sm">pelajari selengkapnya</a>
                    </div>
                </div>

                <!-- Paket Banjir -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden sm:col-span-2 lg:col-span-1">
                    <div class="h-48 bg-gray-300">
                        <img src="/storage/images/paketbanjir.png" alt="Paket Banjir" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 hero-bg text-white">
                        <h3 class="text-lg font-bold mb-2">Paket Banjir</h3>
                        <a href="{{ route(name: 'login') }}" class="text-blue-200 hover:text-blue-100 text-sm">pelajari selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-12 sm:py-16 hero-bg text-white">
        <div class="container mx-auto px-4 sm:px-6">
            <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-center mb-8 sm:mb-12">
                Kata mereka yang telah menggunakan cucicar
            </h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 max-w-5xl mx-auto">
                <!-- Testimonial 1 -->
                <div class="bg-white text-gray-800 p-5 sm:p-6 rounded-lg shadow-lg">
                    <p class="text-sm mb-4">
                        cucicar hebat, web yang sangat fungsional, saya punya 100 mobil, dan jika saya mengantri mungkin bisa sampai zaman sunda atau saya mungkin akan meninggal sebelum selesai semua mobil saya tercuci dengan baik, hingga tinggal dirumah
                    </p>
                    <div class="border-t pt-4">
                        <p class="font-bold text-teal-600">Made Bagus Genjing</p>
                        <p class="text-xs text-gray-500">Bali Indonesia</p>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white text-gray-800 p-5 sm:p-6 rounded-lg shadow-lg">
                    <p class="text-sm mb-4">
                        cucicar hebat, web yang sangat fungsional, saya punya 1000 mobil, dan jika saya mengantri mungkin bisa sampai zaman sunda atau saya mungkin akan meninggal sebelum selesai semua mobil saya tercuci dengan baik, hingga tinggal dirumah
                    </p>
                    <div class="border-t pt-4">
                        <p class="font-bold text-teal-600">Suci Santi</p>
                        <p class="text-xs text-gray-500">Bali Indonesia</p>
                    </div>
                </div>
            </div>
            
           
        </div>
    </section>

    <!-- Partners Section -->
    <section class="py-12 sm:py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6">
            <h2 class="text-xl sm:text-2xl font-bold text-center text-gray-600 mb-8 sm:mb-12">Our Partner</h2>
            
            <div class="flex flex-wrap justify-center items-center gap-6 sm:gap-8 lg:gap-12 opacity-60">
                <img src="/storage/images/sambak.png" alt="Partner 1" class="h-10 sm:h-12">
                <img src="/storage/images/iconnet.png" alt="ICONNET" class="h-10 sm:h-12">
                <img src="/storage/images/aqua ril.png" alt="Partner 3" class="h-10 sm:h-12">
                <img src="/storage/images/a.png" alt="Unilever" class="h-10 sm:h-12">
                <img src="/storage/images/u.png" alt="Partner 5" class="h-10 sm:h-12">
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-100 py-8 sm:py-12">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-xl sm:text-2xl font-bold text-teal-600 mb-4">cucicar</h3>
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
                        <li><a href="{{ route(name: 'login') }}" class="hover:text-teal-600">Cuci mobil</a></li>
                        <li><a href="{{ route(name: 'login') }}" class="hover:text-teal-600">Paket banjir</a></li>
                        <li><a href="{{ route(name: 'login') }}" class="hover:text-teal-600">Salon mobil</a></li>
                    </ul>
                </div>

                <!-- Information -->
                <div>
                    <h4 class="font-bold text-gray-800 mb-4">Informasi</h4>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li><a href="{{ route(name: 'login') }}" class="hover:text-teal-600">About Us</a></li>
                        <li><a href="{{ route(name: 'login') }}" class="hover:text-teal-600">Blog</a></li>
                        <li><a href="{{ route(name: 'login') }}" class="hover:text-teal-600">Contact Us</a></li>
                        <li><a href="{{ route(name: 'login') }}" class="hover:text-teal-600">FAQ</a></li>
                    </ul>
                </div>

                <!-- Rating -->
                <div>
                    <h4 class="font-bold text-gray-800 mb-4">Google rating</h4>
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl font-bold text-gray-800">4.8</span>
                        <div class="flex text-yellow-400 text-sm sm:text-base">
                            <span>⭐⭐⭐⭐⭐</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Hamburger menu
        const hamburger = document.getElementById('hamburger');
        const mobileMenu = document.getElementById('mobileMenu');
        const closeMenu = document.getElementById('closeMenu');
        const overlay = document.getElementById('overlay');

        function openMenu() {
            mobileMenu.classList.add('active');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeMenuFunc() {
            mobileMenu.classList.remove('active');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        hamburger.addEventListener('click', openMenu);
        closeMenu.addEventListener('click', closeMenuFunc);
        overlay.addEventListener('click', closeMenuFunc);

        // Testimonial dots
        const dots = document.querySelectorAll('.testimonial-dot');
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                dots.forEach(d => d.classList.remove('active'));
                dot.classList.add('active');
            });
        });
    </script>
</body>
</html>