@extends('layouts.user')
@section('title','paketbanjir')
@section ('content')
    <!-- Hero Section -->
    <section class="relative bg-cover bg-center h-64 sm:h-80 md:h-96" style="background-image: url('{{ asset('storage/images/fotobanjir.png') }}');">
        <div class="absolute inset-0 bg-teal-600 bg-opacity-50"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
            <div class="text-white">
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-3 sm:mb-4 leading-tight">
                    PAKET<br>
                    BANJIR<br>
                    CUCICAR
                </h1>
                <p class="text-sm sm:text-base md:text-lg mb-4 sm:mb-6 max-w-2xl">
                    Kami bersertifikat dan siap melayani CuciCar untuk umum, Restoran dan perkantoran mobil dengan proses profesional.
                </p>
                <a href="{{ route('bookings.create') }}" class="inline-block bg-blue-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-md hover:bg-blue-700 transition-colors text-sm sm:text-base">
                    Pesan sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 sm:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12 items-center"> 
                <div class="text-center lg:text-left">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-6">
                        Bersihkan Kendaraan Anda dengan Sentuhan Profesional.
                    </h2>
                    <p class="text-sm sm:text-base text-gray-600">
                        Kami menyediakan layanan cuci mobil berkualitas untuk berbagai jenis kendaraan, dengan proses cepat, bersih, dan aman. Mobil Anda akan kembali mengkilap seperti baru!
                    </p>
                </div>
                <div class="text-center">
                    <div class="font-bold">
                       <h1 class="text-4xl sm:text-5xl md:text-6xl text-gray-500"> 300.000 </h1>
                    </div>
                    <p class="text-sm sm:text-base text-gray-600 mt-2">Pengguna yang sudah mencoba layani kami & Cucicar</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-12 sm:py-16 bg-teal-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12 items-center">
                <div class="relative order-2 lg:order-1">
                    <div class="w-64 h-64 sm:w-80 sm:h-80 rounded-full overflow-hidden mx-auto">
                        <img src="{{ asset('storage/images/fotolingkaranbanjir.png') }}" alt="Why Choose Cucicar" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="order-1 lg:order-2">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-6 text-center lg:text-left">
                        Kenapa harus pilih cucicar?
                    </h2>
                    <ul class="space-y-3 sm:space-y-4 text-sm sm:text-base text-gray-700">
                        <li class="flex items-start">
                            <span class="text-teal-600 mr-3 text-xl">•</span>
                            <span>Dikerjakan oleh profesional terlatih</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-teal-600 mr-3 text-xl">•</span>
                            <span>Produk cuci aman & berkualitas</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-teal-600 mr-3 text-xl">•</span>
                            <span>Proses cepat, hasil maksimal</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-teal-600 mr-3 text-xl">•</span>
                            <span>Booking online via Website</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-teal-600 mr-3 text-xl">•</span>
                            <span>Tersedia ruang tunggu nyaman</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Equipment Section -->
    <section class="py-12 sm:py-16 bg-teal-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-8 sm:mb-12">Alat Cuci Spesial Kami</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 sm:gap-8">
                <div class="bg-white rounded-lg p-4 sm:p-6">
                    <div class="h-40 sm:h-48 mb-4">
                        <img src="{{ asset('storage/images/highpreasurejet.png') }}" alt="High Pressure Jet" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <h3 class="font-semibold text-gray-800 text-sm sm:text-base">High Pressure Jet</h3>
                </div>
                <div class="bg-white rounded-lg p-4 sm:p-6">
                    <div class="h-40 sm:h-48 mb-4">
                        <img src="{{ asset('storage/images/vacuum cleaner.png') }}" alt="Vacuum Cleaner" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <h3 class="font-semibold text-gray-800 text-sm sm:text-base">Vacuum Cleaner</h3>
                </div>
                <div class="bg-white rounded-lg p-4 sm:p-6 sm:col-span-2 md:col-span-1">
                    <div class="h-40 sm:h-48 mb-4">
                        <img src="{{ asset('storage/images/kompresor.png') }}" alt="Air Compressor" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <h3 class="font-semibold text-gray-800 text-sm sm:text-base">Air Compressor</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-12 sm:py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-10 items-center">
                <div class="text-center lg:text-left">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-3 sm:mb-4">Tunggu Apalagi?</h2>
                    <p class="text-sm sm:text-base text-gray-600 mb-4 sm:mb-6">mau mobil anda bersih tapi ngga ribet ngantri?</p>
                    <a href="{{ route('bookings.create') }}" class="inline-block bg-blue-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-md hover:bg-blue-700 transition-colors text-sm sm:text-base">
                        Pesan Sekarang
                    </a>
                </div>
                <div class="flex justify-center lg:justify-end">
                   <img src="{{ asset('storage/images/lambobiru.png') }}" alt="Blue Car" class="w-full max-w-sm sm:max-w-md lg:w-80 h-auto object-cover rounded-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-12 sm:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800 mb-6 sm:mb-8 md:mb-12 px-4">
                Kata mereka yang sudah mencuci mobil di cucicar
            </h2>
            
            <!-- Grid 2 Columns -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8 max-w-6xl mx-auto">
                
                <!-- Testimonial 1 -->
                <div class="bg-teal-600 rounded-lg p-4 sm:p-6 md:p-8">
                    <div class="bg-white rounded-lg p-4 sm:p-6">
                        <img src="{{ asset('storage/images/highpreasurejet.png') }}" alt="Customer" class="w-12 h-12 rounded-full mx-auto mb-4 object-cover">
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-2 mb-4">
                            <h4 class="font-bold text-gray-800">Yassir Rizki</h4>
                            <div class="text-yellow-400 text-sm">★★★★★</div>
                        </div>
                        <p class="text-gray-700 text-xs sm:text-sm md:text-base leading-relaxed">
                            "layar cuci mobil yang sangat memuaskan, dengan harga terjangkau dan hasil yang bagus dan bersih, karyawan nya sangat ramah, lokasi mudah dijangkau, pokoknya recommended!"
                        </p>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-teal-600 rounded-lg p-4 sm:p-6 md:p-8">
                    <div class="bg-white rounded-lg p-4 sm:p-6">
                        <img src="{{ asset('storage/images/ppuseradmin.png') }}" alt="Customer" class="w-12 h-12 rounded-full mx-auto mb-4 object-cover">
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-2 mb-4">
                            <h4 class="font-bold text-gray-800">Moh Rafli</h4>
                            <div class="text-yellow-400 text-sm">★★★★★</div>
                        </div>
                        <p class="text-gray-700 text-xs sm:text-sm md:text-base leading-relaxed">
                            "tukang cucinya cepet banget, gilak"
                        </p>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Partners Section -->
    <section class="py-12 sm:py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-600 mb-8 sm:mb-12">Our Partner</h2>
            <div class="flex flex-wrap justify-center items-center gap-6 sm:gap-8 md:gap-12 opacity-60">
                <img src="{{ asset('storage/images/sambak.png') }}" alt="Partner 1" class="h-8 sm:h-10 md:h-12 object-contain">
                <img src="{{ asset('storage/images/iconnet.png') }}" alt="ICONNET" class="h-8 sm:h-10 md:h-12 object-contain">
                <img src="{{ asset('storage/images/aqua ril.png') }}" alt="Partner 3" class="h-8 sm:h-10 md:h-12 object-contain">
                <img src="{{ asset('storage/images/a.png') }}" alt="Unilever" class="h-8 sm:h-10 md:h-12 object-contain">
                <img src="{{ asset('storage/images/u.png') }}" alt="Partner 5" class="h-8 sm:h-10 md:h-12 object-contain">
            </div>
        </div>
    </section>

@endsection