{{-- resources/views/user/dashboard.blade.php --}}
@extends('layouts.user')

@section('title', 'User Dashboard')

@section('content')
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
        .service-icon {
            width: 24px;
            height: 24px;
            display: inline-block;
            margin-right: 8px;
        }
    </style>

    <!-- Hero Section -->
    <section class="hero-bg flex items-center relative overflow-hidden h-[400px] sm:h-[500px] lg:h-[600px] bg-cover bg-center"
         style="background-image: url('{{ asset('storage/images/bg.png') }}');">
        
        <div class="max-w-xl px-4 sm:px-6 lg:px-10 py-10 sm:py-16 lg:py-20 z-10 rounded-lg w-full">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-3 sm:mb-4">
                Cuci dan <br> Salon Mobil <br> Profesional
            </h1>
            <p class="text-sm sm:text-base text-white mb-4 sm:mb-6">
                Cukup Pesan lewat rumah, sudah tidak perlu antri lama
            </p>
            <a href="{{ route('bookings.create') }}"
               class="bg-blue-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg shadow hover:bg-blue-700 transition inline-block text-sm sm:text-base">
                Pelajari selengkapnya
            </a>
        </div>
    </section>

    <!-- Info Section -->
    <section class="py-8 sm:py-12 lg:py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 text-center">
            <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mb-3 sm:mb-4 px-2">
                Sekarang cuci mobil lebih mudah, karena sudah tidak perlu mengantri<br class="hidden md:block">
                panjang dan lama lagi
            </h2>
            <p class="text-sm sm:text-base text-gray-600 mb-8 sm:mb-12 px-2">Ribuan pelanggan dari Bali sudah menikmati web kami</p>
            
            <!-- Car Image -->
            <div class="mb-8 sm:mb-12 px-4">
                <img src="{{ asset('storage/images/mobillanding.png') }}" alt="BMW Car" class="mx-auto rounded-lg w-full max-w-4xl">
            </div>

            <!-- Features -->
            <div class="hero-bg py-8 sm:py-12 px-4">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-8 mb-6 sm:mb-8">
                    <div class="text-center">
                        <div class="text-teal-600 mb-2 text-xl sm:text-2xl">✓</div>
                        <p class="text-xs sm:text-sm text-gray-600 px-1">Cepat tanpa repot antri</p>
                    </div>
                    <div class="text-center">
                        <div class="text-teal-600 mb-2 text-xl sm:text-2xl">⚡</div>
                        <p class="text-xs sm:text-sm text-gray-600 px-1">Kemanan mobil terjaga</p>
                    </div>
                    <div class="text-center">
                        <div class="text-teal-600 mb-2 text-xl sm:text-2xl">👥</div>
                        <p class="text-xs sm:text-sm text-gray-600 px-1">Profesional dan cepat tanggap</p>
                    </div>
                    <div class="text-center">
                        <div class="text-teal-600 mb-2 text-xl sm:text-2xl">✨</div>
                        <p class="text-xs sm:text-sm text-gray-600 px-1">Terpercaya dan Terbaik</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 lg:gap-8 max-w-2xl mx-auto">
                    <div class="text-center">
                        <div class="text-teal-600 mb-2 text-xl sm:text-2xl">🛡️</div>
                        <p class="text-xs sm:text-sm text-gray-600 px-1">Sabun atau Shampoo premium</p>
                    </div>
                    <div class="text-center">
                        <div class="text-teal-600 mb-2 text-xl sm:text-2xl">⭐</div>
                        <p class="text-xs sm:text-sm text-gray-600 px-1">Sabun atau Shampoo premium</p>
                    </div>
                </div>
            </div>
 <!-- #region -->  <div class="mt-5">
     <a href="{{ route('bookings.create') }}" class="mt-6 sm:mt-8 px-6 sm:px-8 py-2 sm:py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors text-sm sm:text-base">
         Pesan Sekarang
     </a>
             </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-8 sm:py-12 lg:py-16 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6">
            <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-center text-gray-800 mb-3 sm:mb-4 px-2">
                Pilihan paket lengkap. Atur jadwal dan cuci<br class="hidden md:block">
                mobil anda sekarang.
            </h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 mt-8 sm:mt-12">
                <!-- Cuci Mobil -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="h-40 sm:h-48 bg-gray-300">
                        <img src="{{ asset('storage/images/paketcuci.png') }}" alt="Cuci Mobil" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4 sm:p-6 hero-bg text-white">
                        <h3 class="text-base sm:text-lg font-bold mb-1">Cuci Mobil</h3>
                        <a href="{{ route('cucimobil') }}" class="text-sm sm:text-base text-blue-400 hover:text-blue-300">pelajari selengkapnya</a>
                    </div>
                </div>

                <!-- Salon Mobil -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="h-40 sm:h-48 bg-gray-300">
                        <img src="{{  asset('storage/images/salonmobil.png') }}" alt="Salon Mobil" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4 sm:p-6 hero-bg text-white">
                        <h3 class="text-base sm:text-lg font-bold mb-1">Salon Mobil</h3>
                        <a href="{{ route('salonmobil') }}" class="text-sm sm:text-base text-blue-400 hover:text-blue-300">pelajari selengkapnya</a>
                    </div>
                </div>

                <!-- Paket Banjir -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="h-40 sm:h-48 bg-gray-300">
                        <img src="{{ asset('storage/images/paketbanjir.png') }}" alt="Paket Banjir" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4 sm:p-6 hero-bg text-white">
                        <h3 class="text-base sm:text-lg font-bold mb-1">Paket Banjir</h3>
                        <a href="{{ route('paketbanjir') }}" class="text-sm sm:text-base text-blue-400 hover:text-blue-300">pelajari selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-8 sm:py-12 lg:py-16 hero-bg text-white">
        <div class="container mx-auto px-4 sm:px-6">
            <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-center mb-8 sm:mb-12 px-2">
                Kata mereka yang telah menggunakan cucicar
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8 max-w-4xl mx-auto">
                <!-- Testimonial 1 -->
                <div class="bg-white text-gray-800 p-4 sm:p-6 rounded-lg shadow-lg">
                    <p class="text-xs sm:text-sm mb-3 sm:mb-4 leading-relaxed">
                        cucicar hebat, web yang sangat fngional, saya punya 100 mobil, dan jika saya mengantri mungkin bisa sampai zaman sunda atau saya mungkin akan meninggal sebelum selesai semua mobil saya tercuci dengan baik, hingga tinggal dirumah
                    </p>
                    <div class="border-t pt-3 sm:pt-4">
                        <p class="font-bold text-teal-600 text-sm sm:text-base">Made Bagus Genjing</p>
                        <p class="text-xs text-gray-500">Bali Indonesia</p>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white text-gray-800 p-4 sm:p-6 rounded-lg shadow-lg">
                    <p class="text-xs sm:text-sm mb-3 sm:mb-4 leading-relaxed">
                        cucicar hebat, web yang sangat fngional, saya punya 1000 mobil, dan jika saya mengantri mungkin bisa sampai zaman sunda atau saya mungkin akan meninggal sebelum selesai semua mobil saya tercuci dengan baik, hingga tinggal dirumah
                    </p>
                    <div class="border-t pt-3 sm:pt-4">
                        <p class="font-bold text-teal-600 text-sm sm:text-base">Suci Santi</p>
                        <p class="text-xs text-gray-500">Bali Indonesia</p>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

    <!-- Partners Section -->
    <section class="py-8 sm:py-12 lg:py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6">
            <h2 class="text-xl sm:text-2xl font-bold text-center text-gray-600 mb-8 sm:mb-12">Our Partner</h2>
            
            <div class="flex flex-wrap justify-center items-center gap-6 sm:gap-8 lg:gap-12 opacity-60">
                <img src="{{ asset('storage/images/sambak.png') }}" alt="Partner 1" class="h-8 sm:h-10 lg:h-12">
                <img src="{{ asset('storage/images/iconnet.png') }}" alt="ICONNET" class="h-8 sm:h-10 lg:h-12">
                <img src="{{ asset('storage/images/aqua ril.png') }}" alt="Partner 3" class="h-8 sm:h-10 lg:h-12">
                <img src="{{ asset('storage/images/a.png') }}" alt="Unilever" class="h-8 sm:h-10 lg:h-12">
                <img src="{{ asset('storage/images/u.png') }}" alt="Partner 5" class="h-8 sm:h-10 lg:h-12">
            </div>
        </div>
    </section>

    <script>
        // Simple testimonial dots interaction
        const dots = document.querySelectorAll('.testimonial-dot');
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                dots.forEach(d => d.classList.remove('active'));
                dot.classList.add('active');
            });
        });
    </script>
@endsection