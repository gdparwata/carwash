{{-- resources/views/blogs/index.blade.php --}}
@extends('layouts.user')

@section('content')
<div class="min-h-screen bg-gray-50">
    {{-- Hero Section --}}
    <div class="relative bg-gradient-to-r from-gray-900 to-gray-800 py-12 sm:py-16 md:py-20 overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=1200" 
                 alt="Car Background" 
                 class="w-full h-full object-cover">
        </div>
        <div class="relative container mx-auto px-4 sm:px-6">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-2">Blog Cucicar</h1>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="container mx-auto px-4 sm:px-6 py-8 sm:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            {{-- Blog Posts Column --}}
            <div class="lg:col-span-2">
                <div id="blog-container">
                    @forelse($blogs as $blog)
                    <div class="blog-item bg-white rounded-lg shadow-md overflow-hidden mb-6 hover:shadow-xl transition-shadow duration-300">
                        <div class="grid grid-cols-1 md:grid-cols-3">
                            {{-- Image --}}
                            <div class="md:col-span-1">
                                @if($blog->gambar)
                                    <img src="{{ asset('storage/' . $blog->gambar) }}" 
                                         alt="{{ $blog->title }}" 
                                         class="w-full h-48 md:h-full object-cover">
                                @else
                                    <div class="w-full h-48 md:h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                        <svg class="w-12 h-12 sm:w-16 sm:h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="md:col-span-2 p-4 sm:p-6">
                                <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-2 sm:mb-3 hover:text-blue-600 transition-colors break-words">
                                    <a href="{{ route('blogs.show', $blog->id_blog) }}" class="block">
                                        {{ $blog->title }}
                                    </a>
                                </h2>
                                
                                <p class="text-sm sm:text-base text-gray-600 mb-3 sm:mb-4 leading-relaxed">
                                    {{ Str::limit($blog->deskripsi_singkat, 150) }}
                                </p>

                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-xs sm:text-sm text-gray-500 mb-3 sm:mb-4 gap-1 sm:gap-0">
                                    <span>By <strong>{{ $blog->user->name ?? $blog->penulis ?? 'Unknown' }}</strong></span>
                                    @if($blog->tanggal_upload)
                                    <span class="sm:ml-2">{{ $blog->tanggal_upload->format('M d, Y') }}</span>
                                    @endif
                                </div>

                                <a href="{{ route('blogs.show', $blog->id_blog) }}" 
                                   class="inline-block text-sm sm:text-base text-teal-600 hover:text-teal-700 font-semibold">
                                    Read more...
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="bg-white rounded-lg shadow-md p-8 sm:p-12 text-center">
                        <svg class="w-12 h-12 sm:w-16 sm:h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-gray-500 text-base sm:text-lg">Belum ada artikel tersedia</p>
                    </div>
                    @endforelse
                </div>

                {{-- Custom Pagination --}}
                <div id="blog-pagination" class="flex flex-wrap justify-center items-center gap-2 mt-8"></div>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1 order-first lg:order-last mb-6 lg:mb-0">
                <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 lg:sticky lg:top-6">
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 sm:mb-6 pb-3 border-b-2 border-teal-500">
                        Layanan CUCICAR
                    </h3>
                    
                    <ul class="space-y-3 sm:space-y-4 mb-6 sm:mb-8">
                        <li>
                            <a href="{{ route('cucimobil') }}" 
                               class="text-sm sm:text-base text-gray-700 hover:text-teal-600 flex items-center transition-colors">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                Paket Cuci
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('salonmobil') }}" 
                               class="text-sm sm:text-base text-gray-700 hover:text-teal-600 flex items-center transition-colors">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                Paket Banjir
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pakets.index.public') }}" 
                               class="text-sm sm:text-base text-gray-700 hover:text-teal-600 flex items-center transition-colors">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                Salon mobil
                            </a>
                        </li>
                    </ul>

                    {{-- Google Rating --}}
                    <div class="border-t pt-4 sm:pt-6">
                        <div class="flex items-center mb-2">
                            <img src="https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_92x30dp.png" 
                                 alt="Google" 
                                 class="h-4 sm:h-5 mr-2">
                            <span class="text-xs sm:text-sm text-gray-600">rating</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-2xl sm:text-3xl font-bold text-gray-800 mr-2">4.8</span>
                            <div class="flex text-yellow-400">
                                @for($i = 0; $i < 5; $i++)
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ITEMS_PER_PAGE = 6;
    const blogItems = document.querySelectorAll('.blog-item');
    const paginationDiv = document.getElementById('blog-pagination');
    const totalItems = blogItems.length;
    const totalPages = Math.ceil(totalItems / ITEMS_PER_PAGE);
    let currentPage = 1;

    function showPage(page) {
        // Hide all items
        blogItems.forEach((item, index) => {
            const startIndex = (page - 1) * ITEMS_PER_PAGE;
            const endIndex = startIndex + ITEMS_PER_PAGE;
            
            if (index >= startIndex && index < endIndex) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });

        // Scroll to top of blog container smoothly
        document.getElementById('blog-container').scrollIntoView({ 
            behavior: 'smooth', 
            block: 'start' 
        });

        currentPage = page;
        updatePaginationButtons();
    }

    function updatePaginationButtons() {
        paginationDiv.innerHTML = '';

        if (totalPages <= 1 || totalItems === 0) {
            return;
        }

        // Previous button
        const prevBtn = document.createElement('button');
        prevBtn.innerHTML = '←';
        prevBtn.className = `px-3 sm:px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm sm:text-base ${
            currentPage === 1 
                ? 'bg-gray-200 text-gray-400 cursor-not-allowed' 
                : 'bg-white text-gray-700 hover:bg-teal-50 hover:text-teal-600 border-2 border-gray-200 hover:border-teal-500 shadow-sm'
        }`;
        prevBtn.disabled = currentPage === 1;
        prevBtn.onclick = () => {
            if (currentPage > 1) {
                showPage(currentPage - 1);
            }
        };
        paginationDiv.appendChild(prevBtn);

        // Page numbers - show fewer on mobile
        const isMobile = window.innerWidth < 640;
        let pagesToShow = [];
        
        if (isMobile && totalPages > 5) {
            // On mobile, show: 1 ... current-1 current current+1 ... last
            if (currentPage <= 3) {
                pagesToShow = [1, 2, 3, '...', totalPages];
            } else if (currentPage >= totalPages - 2) {
                pagesToShow = [1, '...', totalPages - 2, totalPages - 1, totalPages];
            } else {
                pagesToShow = [1, '...', currentPage - 1, currentPage, currentPage + 1, '...', totalPages];
            }
        } else {
            // Desktop or few pages: show all
            pagesToShow = Array.from({length: totalPages}, (_, i) => i + 1);
        }

        pagesToShow.forEach(pageNum => {
            if (pageNum === '...') {
                const ellipsis = document.createElement('span');
                ellipsis.textContent = '...';
                ellipsis.className = 'px-2 sm:px-3 py-2 text-gray-500';
                paginationDiv.appendChild(ellipsis);
            } else {
                const pageBtn = document.createElement('button');
                pageBtn.textContent = pageNum;
                pageBtn.className = `px-3 sm:px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm sm:text-base ${
                    currentPage === pageNum 
                        ? 'bg-teal-600 text-white shadow-lg transform scale-105' 
                        : 'bg-white text-gray-700 hover:bg-teal-50 hover:text-teal-600 border-2 border-gray-200 hover:border-teal-500 shadow-sm'
                }`;
                pageBtn.onclick = () => showPage(pageNum);
                paginationDiv.appendChild(pageBtn);
            }
        });

        // Next button
        const nextBtn = document.createElement('button');
        nextBtn.innerHTML = '→';
        nextBtn.className = `px-3 sm:px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm sm:text-base ${
            currentPage === totalPages 
                ? 'bg-gray-200 text-gray-400 cursor-not-allowed' 
                : 'bg-white text-gray-700 hover:bg-teal-50 hover:text-teal-600 border-2 border-gray-200 hover:border-teal-500 shadow-sm'
        }`;
        nextBtn.disabled = currentPage === totalPages;
        nextBtn.onclick = () => {
            if (currentPage < totalPages) {
                showPage(currentPage + 1);
            }
        };
        paginationDiv.appendChild(nextBtn);
    }

    // Initialize first page
    if (totalItems > 0) {
        showPage(1);
    }

    // Update pagination on resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            updatePaginationButtons();
        }, 250);
    });
});
</script>
@endsection