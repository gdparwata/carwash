{{-- resources/views/blogs/index.blade.php --}}
@extends('layouts.user')

@section('content')
<div class="min-h-screen bg-gray-50">
    {{-- Hero Section --}}
    <div class="relative bg-gradient-to-r from-gray-900 to-gray-800 py-20 overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=1200" 
                 alt="Car Background" 
                 class="w-full h-full object-cover">
        </div>
        <div class="relative container mx-auto px-4">
            <h1 class="text-5xl font-bold text-white mb-2">Blog Cucicar</h1>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Blog Posts Column --}}
            <div class="lg:col-span-2">
                @forelse($blogs as $blog)
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="grid md:grid-cols-3">
                        {{-- Image --}}
                        <div class="md:col-span-1">
                            @if($blog->gambar)
                                <img src="{{ asset('storage/' . $blog->gambar) }}" 
                                     alt="{{ $blog->title }}" 
                                     class="w-full h-48 md:h-full object-cover">
                            @else
                                <div class="w-full h-48 md:h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="md:col-span-2 p-6">
                            <h2 class="text-2xl font-bold text-gray-800 mb-3 hover:text-blue-600 transition-colors">
                                <a href="{{ route('blogs.show', $blog->id_blog) }}">
                                    {{ $blog->title }}
                                </a>
                            </h2>
                            
                            <p class="text-gray-600 mb-4 leading-relaxed">
                                {{ Str::limit($blog->deskripsi_singkat, 150) }}
                            </p>

                            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                <span>By <strong>{{ $blog->user->name ?? $blog->penulis ?? 'Unknown' }}</strong></span>
                                @if($blog->tanggal_upload)
                                <span>| {{ $blog->tanggal_upload->format('M d, Y') }}</span>
                                @endif
                            </div>

                            <a href="{{ route('blogs.show', $blog->id_blog) }}" 
                               class="inline-block text-teal-600 hover:text-teal-700 font-semibold">
                                Read more...
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-gray-500 text-lg">Belum ada artikel tersedia</p>
                </div>
                @endforelse

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $blogs->links() }}
                </div>

                {{-- Pagination Navigation --}}
                @if($blogs->hasPages())
                <div class="flex justify-center mt-6">
                    <a href="{{ $blogs->previousPageUrl() }}" 
                       class="px-4 py-2 text-sm text-teal-600 hover:text-teal-700 disabled:opacity-50 {{ !$blogs->onFirstPage() ?: 'pointer-events-none opacity-50' }}">
                        << Older Entries
                    </a>
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 pb-3 border-b-2 border-teal-500">
                        Layanan CUCICAR
                    </h3>
                    
                    <ul class="space-y-4 mb-8">
                        <li>
                            <a href="{{ route('pakets.index.public') }}" 
                               class="text-gray-700 hover:text-teal-600 flex items-center transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                Paket Cuci
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('bookings.create') }}" 
                               class="text-gray-700 hover:text-teal-600 flex items-center transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                Paket Banjir
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pakets.index.public') }}" 
                               class="text-gray-700 hover:text-teal-600 flex items-center transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                Salon mobil
                            </a>
                        </li>
                    </ul>

                    {{-- Google Rating --}}
                    <div class="border-t pt-6">
                        <div class="flex items-center mb-2">
                            <img src="https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_92x30dp.png" 
                                 alt="Google" 
                                 class="h-5 mr-2">
                            <span class="text-sm text-gray-600">rating</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-3xl font-bold text-gray-800 mr-2">4.8</span>
                            <div class="flex text-yellow-400">
                                @for($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer Section --}}
    <footer class="bg-gray-900 text-white mt-16">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Company Info --}}
                <div>
                    <h3 class="text-2xl font-bold mb-4">cucicar</h3>
                    <p class="text-gray-400 mb-4">
                        Jl. Akasia Gang rama 4 blok g.<br>
                        Denpasar timur, Denpasar, Bali, Indonesia.
                    </p>
                    <div>
                        <h4 class="font-semibold mb-2">Wilayah Operasional</h4>
                        <ul class="text-gray-400 space-y-1">
                            <li>• Denpasar</li>
                            <li>• Badung</li>
                            <li>• Karangasem</li>
                        </ul>
                    </div>
                </div>

                {{-- Services --}}
                <div>
                    <h4 class="font-semibold mb-4 text-lg">Layanan</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('pakets.index.public') }}" class="text-gray-400 hover:text-teal-400">Cuci mobil</a></li>
                        <li><a href="{{ route('bookings.create') }}" class="text-gray-400 hover:text-teal-400">Paket banjir</a></li>
                        <li><a href="{{ route('pakets.index.public') }}" class="text-gray-400 hover:text-teal-400">Salon mobil</a></li>
                    </ul>
                </div>

                {{-- Information --}}
                <div>
                    <h4 class="font-semibold mb-4 text-lg">Informasi</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-teal-400">About Us</a></li>
                        <li><a href="{{ route('blogs.index') }}" class="text-gray-400 hover:text-teal-400">Blog</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-teal-400">Contact Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-teal-400">FAQ</a></li>
                    </ul>
                </div>
            </div>

            {{-- Google Rating in Footer --}}
            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <div class="inline-flex items-center">
                    <img src="https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_92x30dp.png" 
                         alt="Google" 
                         class="h-5 mr-3">
                    <span class="text-sm text-gray-400 mr-2">rating</span>
                    <span class="text-2xl font-bold mr-2">4.8</span>
                    <div class="flex text-yellow-400">
                        @for($i = 0; $i < 5; $i++)
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
@endsection