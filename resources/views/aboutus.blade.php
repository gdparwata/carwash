@extends('layouts.user')
@section('title','aboutus')
@section('content')
    
    <!-- Dynamic Content from Database -->
    @forelse($profils as $index => $profil)
        @if($index % 2 == 0)
            <!-- Even index - Image on right (mobile: image first) -->
            <section class="py-8 sm:py-12 lg:py-16 {{ $index % 4 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 lg:gap-12 items-center">
                        <!-- Content -->
                        <div class="order-2 lg:order-1" data-aos="fade-right">
                            <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mb-3 sm:mb-4 lg:mb-6">
                                {{ $profil->judul }}
                            </h2>
                            <div class="space-y-2 sm:space-y-3 lg:space-y-4">
                                <div class="text-sm sm:text-base lg:text-lg text-gray-700 leading-relaxed" style="white-space: pre-line;">
                                    {{ $profil->isi }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Image -->
                        <div class="order-1 lg:order-2" data-aos="fade-left">
                            <div class="rounded-lg p-2 sm:p-4 lg:p-8">
                                <div class="w-full h-56 sm:h-64 lg:h-80 bg-white rounded-lg flex items-center justify-center overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                                    @if($profil->foto)
                                        <img src="{{ asset('storage/' . $profil->foto) }}" 
                                             alt="{{ $profil->judul }}" 
                                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="bg-gray-200 w-full h-full flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400 text-4xl sm:text-5xl lg:text-6xl"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @else
            <!-- Odd index - Image on left (mobile: image first) -->
            <section class="py-8 sm:py-12 lg:py-16 {{ $index % 4 == 1 ? 'bg-white' : 'bg-teal-50' }}">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 lg:gap-12 items-center">
                        <!-- Image -->
                        <div class="order-1" data-aos="fade-right">
                            <div class="rounded-lg p-2 sm:p-4 lg:p-8">
                                <div class="w-full h-56 sm:h-64 lg:h-80 {{ $index % 4 == 3 ? 'bg-white rounded-lg shadow-lg' : 'bg-white rounded-lg shadow-md' }} flex items-center justify-center overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                    @if($profil->foto)
                                        <img src="{{ asset('storage/' . $profil->foto) }}" 
                                             alt="{{ $profil->judul }}" 
                                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="bg-gray-200 w-full h-full flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400 text-4xl sm:text-5xl lg:text-6xl"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="order-2" data-aos="fade-left">
                            <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mb-3 sm:mb-4 lg:mb-6">
                                {{ $profil->judul }}
                            </h2>
                            <div class="text-sm sm:text-base lg:text-lg text-gray-700 leading-relaxed" style="white-space: pre-line;">
                                {{ $profil->isi }}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @empty
        <!-- Empty State -->
        <section class="py-12 sm:py-16 lg:py-24 bg-gray-50">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <i class="fas fa-info-circle text-5xl sm:text-6xl lg:text-7xl text-gray-300 mb-4 sm:mb-6"></i>
                <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-700 mb-2 sm:mb-3">
                    Belum Ada Informasi
                </h2>
                <p class="text-sm sm:text-base lg:text-lg text-gray-500">
                    Konten sedang dalam proses. Silakan kembali lagi nanti.
                </p>
            </div>
        </section>
    @endforelse

    <!-- Optional: Add AOS Animation (Add this to your layout if not already included) -->
    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });
    </script>
    @endpush

    @push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    @endpush
@endsection
