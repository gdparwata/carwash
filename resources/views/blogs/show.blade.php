{{-- resources/views/blogs/show.blade.php --}}
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
            {{-- Article Content --}}
            <div class="lg:col-span-2">
                <article class="bg-white rounded-lg shadow-md overflow-hidden">
                    {{-- Article Header --}}
                    <div class="p-8">
                        <h1 class="text-4xl font-bold text-gray-900 mb-4">
                            {{ $blog->title }}
                        </h1>
                        
                        <div class="flex items-center text-sm text-gray-600 mb-6 pb-6 border-b">
                            <span class="mr-4">By <strong>{{ $blog->user->name ?? $blog->penulis ?? 'Unknown' }}</strong></span>
                            @if($blog->tanggal_upload)
                            <span>| {{ $blog->tanggal_upload->format('M d, Y') }}</span>
                            @endif
                        </div>

                        {{-- Featured Image --}}
                        @if($blog->gambar)
                        <div class="mb-8">
                            <img src="{{ asset('storage/' . $blog->gambar) }}" 
                                 alt="{{ $blog->title }}" 
                                 class="w-full h-auto rounded-lg shadow-lg">
                        </div>
                        @endif

                        {{-- Article Body --}}
                        <div class="prose prose-lg max-w-none">
                            <p class="text-xl text-gray-700 mb-6 leading-relaxed">
                                {{ $blog->deskripsi_singkat }}
                            </p>
                            
                            <div class="text-gray-800 leading-relaxed space-y-4">
                                {!! nl2br(e($blog->isi)) !!}
                            </div>
                        </div>
                    </div>

                    {{-- Share Section --}}
                    <div class="px-8 py-6 bg-gray-50 border-t">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Bagikan artikel ini:</span>
                            <div class="flex space-x-3">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" 
                                   target="_blank"
                                   class="w-10 h-10 bg-blue-600 hover:bg-blue-700 text-white rounded-full flex items-center justify-center transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $blog->title }}" 
                                   target="_blank"
                                   class="w-10 h-10 bg-sky-500 hover:bg-sky-600 text-white rounded-full flex items-center justify-center transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($blog->title . ' - ' . url()->current()) }}" 
                                   target="_blank"
                                   class="w-10 h-10 bg-green-500 hover:bg-green-600 text-white rounded-full flex items-center justify-center transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>

                {{-- Back Button --}}
                <div class="mt-6">
                    <a href="{{ route('blogs.index') }}" 
                       class="inline-flex items-center text-teal-600 hover:text-teal-700 font-semibold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Blog
                    </a>
                </div>
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
</div>
@endsection