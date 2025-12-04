@extends('layouts.user')
@section('title','aboutus')
@section ('content')
    <!-- Hero Section -->
   
       
    <!-- Dynamic Content from Database -->
    @foreach($profils as $index => $profil)
        @if($index % 2 == 0)
            <!-- Even index - Image on right -->
            <section class="py-8 sm:py-12 md:py-16 {{ $index % 4 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 items-center">
                        <div>
                            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-6">{{ $profil->judul }}</h2>
                            <div class="space-y-3 sm:space-y-4">
                                <div class="text-sm sm:text-base text-gray-700" style="white-space: pre-line;">
                                    {{ $profil->isi }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="rounded-lg p-4 sm:p-8">
                            <div class="w-full h-48 sm:h-56 md:h-64 bg-white rounded-lg flex items-center justify-center overflow-hidden shadow">
                                @if($profil->foto)
                                    <img src="{{ asset('storage/' . $profil->foto) }}" alt="{{ $profil->judul }}" class="w-full h-full object-cover">
                                @else
                                    <div class="bg-gray-200 w-full h-full flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-5xl"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @else
            <!-- Odd index - Image on left -->
            <section class="py-8 sm:py-12 md:py-16 {{ $index % 4 == 1 ? 'bg-white' : 'bg-teal-50' }}">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 items-center">
                        <div class="rounded-lg p-4 sm:p-8 order-2 lg:order-1">
                            <div class="w-full h-48 sm:h-56 md:h-64 {{ $index % 4 == 3 ? 'bg-white rounded-lg shadow-lg' : 'bg-white rounded-lg' }} flex items-center justify-center overflow-hidden">
                                @if($profil->foto)
                                    <img src="{{ asset('storage/' . $profil->foto) }}" alt="{{ $profil->judul }}" class="w-full h-full object-cover">
                                @else
                                    <div class="bg-gray-200 w-full h-full flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-5xl"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="order-1 lg:order-2">
                            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-6">{{ $profil->judul }}</h2>
                            <div class="text-sm sm:text-base text-gray-700" style="white-space: pre-line;">
                                {{ $profil->isi }}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endforeach
@endsection