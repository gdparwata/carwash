@extends('layouts.user')

@section('title', 'Paket Harga - CUCICAR')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-8 sm:mb-12">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-700 mb-4">Daftar Harga di CUCICAR</h1>
        </div>

        <!-- Tab Navigation - Grid Layout for Mobile -->
        <div class="mb-8 sm:mb-12">
            <div class="grid grid-cols-2 sm:flex sm:justify-center gap-2">
                <button onclick="showTab('cuci-mobil')" id="tab-cuci-mobil" class="tab-button px-4 sm:px-6 md:px-8 py-2 sm:py-3 rounded-lg font-medium transition-all duration-200 bg-white text-gray-900 shadow text-sm sm:text-base border-2 border-gray-200">
                    Cuci Mobil
                </button>
                <button onclick="showTab('paket-banjir')" id="tab-paket-banjir" class="tab-button px-4 sm:px-6 md:px-8 py-2 sm:py-3 rounded-lg font-medium transition-all duration-200 text-gray-700 hover:bg-gray-100 text-sm sm:text-base border-2 border-gray-200">
                    Paket Banjir
                </button>
                <button onclick="showTab('salon-mobil')" id="tab-salon-mobil" class="tab-button px-4 sm:px-6 md:px-8 py-2 sm:py-3 rounded-lg font-medium transition-all duration-200 text-gray-700 hover:bg-gray-100 text-sm sm:text-base border-2 border-gray-200">
                    Salon Mobil
                </button>
                <button onclick="showTab('jenis-mobil')" id="tab-jenis-mobil" class="tab-button px-4 sm:px-6 md:px-8 py-2 sm:py-3 rounded-lg font-medium transition-all duration-200 text-gray-700 hover:bg-gray-100 text-sm sm:text-base border-2 border-gray-200">
                    Jenis Mobil
                </button>
            </div>
        </div>

        <!-- Content Sections -->
        
        <!-- Cuci Mobil Section -->
        <div id="content-cuci-mobil" class="tab-content">
            <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-700 mb-6 sm:mb-8">Paket Cuci</h2>
            
            <!-- Paket Cuci Grid -->
            <div class="paket-container mb-8" data-section="paket-cuci" data-items-per-page="6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8 paket-grid">
                    @forelse($pakets->filter(fn($p) => stripos($p->kategori_paket, 'cuci') !== false) as $paket)
                    <div class="paket-item bg-white rounded-lg border-2 border-gray-200 p-4 sm:p-6 hover:shadow-lg transition-shadow duration-200">
                        <div class="flex items-center gap-2 mb-3">
                            @if($paket->tingkatan && str_contains(strtolower($paket->tingkatan->Tingkatan), 'basic'))
                            <span class="text-xl sm:text-2xl">⭐</span>
                            @elseif($paket->tingkatan && str_contains(strtolower($paket->tingkatan->Tingkatan), 'standard'))
                            <span class="text-xl sm:text-2xl">⭐⭐</span>
                            @elseif($paket->tingkatan && str_contains(strtolower($paket->tingkatan->Tingkatan), 'elite'))
                            <span class="text-xl sm:text-2xl">⭐⭐⭐</span>
                            @else
                            <span class="text-xl sm:text-2xl">⭐⭐⭐⭐</span>
                            @endif
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900">{{ $paket->tingkatan ? $paket->tingkatan->Tingkatan : 'Paket' }}</h3>
                        </div>
                        
                        <p class="text-xs sm:text-sm text-gray-600 mb-3 sm:mb-4">{{ $paket->kategori_paket }}</p>
                        
                        @if($paket->tingkatan)
                        <div class="text-xs sm:text-sm text-gray-600 mb-3 sm:mb-4 space-y-1">
                            {!! nl2br(e($paket->tingkatan->deskripsi)) !!}
                        </div>
                        @endif
                        
                        <div class="border-t pt-3 sm:pt-4">
                            <p class="text-xs text-gray-500 mb-1">Harga</p>
                            <p class="text-xl sm:text-2xl font-bold text-red-500">
                                {{ $paket->tingkatan ? 'Rp. ' . number_format($paket->tingkatan->harga, 0, ',', '.') : 'Hubungi Kami' }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-12 text-gray-500">
                        <p>Tidak ada paket cuci tersedia saat ini</p>
                    </div>
                    @endforelse
                </div>
                
                <!-- Pagination for Paket Cuci -->
                <div class="pagination flex flex-wrap justify-center items-center gap-2"></div>
            </div>

            <!-- Add Ons Section -->
            <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-700 mb-6 sm:mb-8 mt-8 sm:mt-12">Add Ons</h2>
            
            <!-- Add Ons Grid -->
            <div class="paket-container" data-section="addons" data-items-per-page="6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8 paket-grid">
                    @forelse($addons ?? [] as $addon)
                    <div class="paket-item bg-white rounded-lg border-2 border-gray-200 p-4 sm:p-6 hover:shadow-lg transition-shadow duration-200">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-xl sm:text-2xl">✨</span>
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900">{{ $addon->nama }}</h3>
                        </div>
                        
                        <div class="border-t pt-3 sm:pt-4">
                            <p class="text-xs text-gray-500 mb-1">Harga</p>
                            <p class="text-xl sm:text-2xl font-bold text-red-500">Rp. {{ number_format($addon->harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-12 text-gray-500">
                        <p>Tidak ada add-ons tersedia saat ini</p>
                    </div>
                    @endforelse
                </div>
                
                <!-- Pagination for Add Ons -->
                <div class="pagination flex flex-wrap justify-center items-center gap-2"></div>
            </div>
        </div>

        <!-- Paket Banjir Section -->
        <div id="content-paket-banjir" class="tab-content hidden">
            <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-700 mb-6 sm:mb-8">Paket Banjir</h2>
            
            <div class="paket-container" data-section="paket-banjir" data-items-per-page="6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8 paket-grid">
                    @forelse($pakets->filter(fn($p) => stripos($p->kategori_paket, 'banjir') !== false) as $paket)
                    <div class="paket-item bg-white rounded-lg border-2 border-gray-200 p-4 sm:p-6 hover:shadow-lg transition-shadow duration-200">
                        <div class="flex items-center gap-2 mb-3">
                            @if($paket->tingkatan && str_contains(strtolower($paket->tingkatan->Tingkatan), 'ringan'))
                            <span class="text-xl sm:text-2xl">⭐</span>
                            @elseif($paket->tingkatan && str_contains(strtolower($paket->tingkatan->Tingkatan), 'sedang'))
                            <span class="text-xl sm:text-2xl">⭐⭐</span>
                            @else
                            <span class="text-xl sm:text-2xl">⭐⭐⭐</span>
                            @endif
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900">{{ $paket->tingkatan ? $paket->tingkatan->Tingkatan : 'Paket Banjir' }}</h3>
                        </div>
                        
                        <p class="text-xs sm:text-sm text-gray-600 mb-3 sm:mb-4">{{ $paket->kategori_paket }}</p>
                        
                        @if($paket->tingkatan)
                        <div class="text-xs sm:text-sm text-gray-600 mb-3 sm:mb-4 space-y-1">
                            {!! nl2br(e($paket->tingkatan->deskripsi)) !!}
                        </div>
                        @endif
                        
                        <div class="border-t pt-3 sm:pt-4">
                            <p class="text-xs text-gray-500 mb-1">Harga</p>
                            <p class="text-xl sm:text-2xl font-bold text-red-500">
                                {{ $paket->tingkatan ? 'Rp. ' . number_format($paket->tingkatan->harga, 0, ',', '.') : 'Hubungi Kami' }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-12 text-gray-500">
                        <p>Tidak ada paket banjir tersedia saat ini</p>
                    </div>
                    @endforelse
                </div>
                
                <!-- Pagination -->
                <div class="pagination flex flex-wrap justify-center items-center gap-2"></div>
            </div>
        </div>

        <!-- Salon Mobil Section -->
        <div id="content-salon-mobil" class="tab-content hidden">
            <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-700 mb-6 sm:mb-8">Salon Mobil</h2>
            
            <div class="paket-container" data-section="salon-mobil" data-items-per-page="6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8 paket-grid">
                    @forelse($pakets->filter(fn($p) => stripos($p->kategori_paket, 'salon') !== false) as $paket)
                    <div class="paket-item bg-white rounded-lg border-2 border-gray-200 p-4 sm:p-6 hover:shadow-lg transition-shadow duration-200">
                        <div class="flex items-center gap-2 mb-3">
                            @if($paket->tingkatan && str_contains(strtolower($paket->tingkatan->Tingkatan), 'refresh'))
                            <span class="text-xl sm:text-2xl">⭐</span>
                            @elseif($paket->tingkatan && str_contains(strtolower($paket->tingkatan->Tingkatan), 'shine'))
                            <span class="text-xl sm:text-2xl">⭐⭐</span>
                            @else
                            <span class="text-xl sm:text-2xl">⭐⭐⭐</span>
                            @endif
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900">{{ $paket->tingkatan ? $paket->tingkatan->Tingkatan : 'Salon' }}</h3>
                        </div>
                        
                        <p class="text-xs sm:text-sm text-gray-600 mb-3 sm:mb-4">{{ $paket->kategori_paket }}</p>
                        
                        @if($paket->tingkatan)
                        <div class="text-xs sm:text-sm text-gray-600 mb-3 sm:mb-4 space-y-1">
                            {!! nl2br(e($paket->tingkatan->deskripsi)) !!}
                        </div>
                        @endif
                        
                        <div class="border-t pt-3 sm:pt-4">
                            <p class="text-xs text-gray-500 mb-1">Harga</p>
                            <p class="text-xl sm:text-2xl font-bold text-red-500">
                                {{ $paket->tingkatan ? 'Rp. ' . number_format($paket->tingkatan->harga, 0, ',', '.') : 'Hubungi Kami' }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-12 text-gray-500">
                        <p>Tidak ada paket salon tersedia saat ini</p>
                    </div>
                    @endforelse
                </div>
                
                <!-- Pagination -->
                <div class="pagination flex flex-wrap justify-center items-center gap-2"></div>
            </div>
        </div>

        <!-- Jenis Mobil Section -->
        <div id="content-jenis-mobil" class="tab-content hidden">
            <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-700 mb-6 sm:mb-8">Harga dari Jenis Mobil di CUCICAR</h2>
            
            <div class="paket-container" data-section="jenis-mobil" data-items-per-page="6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8 paket-grid">
                    @forelse($jenisKendaraans ?? [] as $jenis)
                    <div class="paket-item bg-white rounded-lg border-2 border-gray-200 p-4 sm:p-6 hover:shadow-lg transition-shadow duration-200">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">{{ $jenis->jenis_kendaraan }}</h3>
                        <p class="text-xs sm:text-sm text-gray-600 mb-3 sm:mb-4">{{ $jenis->nama_kendaraan }}</p>
                        
                        <div class="border-t pt-3 sm:pt-4">
                            <p class="text-xs text-gray-500 mb-1">Harga</p>
                            <p class="text-xl sm:text-2xl font-bold text-red-500">Rp. {{ number_format($jenis->harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-12 text-gray-500">
                        <p>Tidak ada jenis kendaraan tersedia saat ini</p>
                    </div>
                    @endforelse
                </div>
                
                <!-- Pagination -->
                <div class="pagination flex flex-wrap justify-center items-center gap-2"></div>
            </div>
        </div>

    </div>
</div>

<style>
/* Smooth transitions for tabs */
.tab-button {
    transition: all 0.3s ease;
}
</style>

<script>
// Pagination system dengan konfigurasi per section
function initializePagination() {
    document.querySelectorAll('.paket-container').forEach(container => {
        const items = container.querySelectorAll('.paket-item');
        const paginationDiv = container.querySelector('.pagination');
        const itemsPerPage = parseInt(container.dataset.itemsPerPage) || 6;
        
        if (items.length === 0) {
            return;
        }
        
        const totalPages = Math.ceil(items.length / itemsPerPage);
        let currentPage = 1;
        
        function showPage(page) {
            // Hide all items
            items.forEach((item, index) => {
                const startIndex = (page - 1) * itemsPerPage;
                const endIndex = startIndex + itemsPerPage;
                
                if (index >= startIndex && index < endIndex) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
            
            currentPage = page;
            updatePaginationButtons();
            
            // Scroll to top of section
            container.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        
        function updatePaginationButtons() {
            paginationDiv.innerHTML = '';
            
            if (totalPages <= 1) {
                return;
            }
            
            // Previous button
            const prevBtn = document.createElement('button');
            prevBtn.textContent = '←';
            prevBtn.className = `px-3 py-2 rounded-lg font-medium transition-all duration-200 text-sm sm:text-base ${
                currentPage === 1 
                    ? 'bg-gray-200 text-gray-400 cursor-not-allowed' 
                    : 'bg-white text-gray-700 hover:bg-gray-100 border-2 border-gray-200'
            }`;
            prevBtn.disabled = currentPage === 1;
            prevBtn.onclick = () => {
                if (currentPage > 1) {
                    showPage(currentPage - 1);
                }
            };
            paginationDiv.appendChild(prevBtn);
            
            // Page numbers with smart display
            const maxVisiblePages = window.innerWidth < 640 ? 3 : 5;
            let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
            let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
            
            if (endPage - startPage < maxVisiblePages - 1) {
                startPage = Math.max(1, endPage - maxVisiblePages + 1);
            }
            
            // First page button
            if (startPage > 1) {
                const firstBtn = document.createElement('button');
                firstBtn.textContent = '1';
                firstBtn.className = 'px-3 sm:px-4 py-2 rounded-lg font-medium transition-all duration-200 bg-white text-gray-700 hover:bg-gray-100 border-2 border-gray-200 text-sm sm:text-base';
                firstBtn.onclick = () => showPage(1);
                paginationDiv.appendChild(firstBtn);
                
                if (startPage > 2) {
                    const ellipsis = document.createElement('span');
                    ellipsis.textContent = '...';
                    ellipsis.className = 'px-2 py-2 text-gray-500 text-sm sm:text-base';
                    paginationDiv.appendChild(ellipsis);
                }
            }
            
            // Page numbers
            for (let i = startPage; i <= endPage; i++) {
                const pageBtn = document.createElement('button');
                pageBtn.textContent = i;
                pageBtn.className = `px-3 sm:px-4 py-2 rounded-lg font-medium transition-all duration-200 text-sm sm:text-base ${
                    currentPage === i 
                        ? 'bg-red-500 text-white shadow-lg' 
                        : 'bg-white text-gray-700 hover:bg-gray-100 border-2 border-gray-200'
                }`;
                pageBtn.onclick = () => showPage(i);
                paginationDiv.appendChild(pageBtn);
            }
            
            // Last page button
            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    const ellipsis = document.createElement('span');
                    ellipsis.textContent = '...';
                    ellipsis.className = 'px-2 py-2 text-gray-500 text-sm sm:text-base';
                    paginationDiv.appendChild(ellipsis);
                }
                
                const lastBtn = document.createElement('button');
                lastBtn.textContent = totalPages;
                lastBtn.className = 'px-3 sm:px-4 py-2 rounded-lg font-medium transition-all duration-200 bg-white text-gray-700 hover:bg-gray-100 border-2 border-gray-200 text-sm sm:text-base';
                lastBtn.onclick = () => showPage(totalPages);
                paginationDiv.appendChild(lastBtn);
            }
            
            // Next button
            const nextBtn = document.createElement('button');
            nextBtn.textContent = '→';
            nextBtn.className = `px-3 py-2 rounded-lg font-medium transition-all duration-200 text-sm sm:text-base ${
                currentPage === totalPages 
                    ? 'bg-gray-200 text-gray-400 cursor-not-allowed' 
                    : 'bg-white text-gray-700 hover:bg-gray-100 border-2 border-gray-200'
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
        showPage(1);
    });
}

function showTab(tabName) {
    // Hide all content
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active styles from all buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('bg-white', 'text-gray-900', 'shadow', 'border-red-500');
        button.classList.add('text-gray-700', 'hover:bg-gray-100', 'border-gray-200');
    });
    
    // Show selected content
    document.getElementById(`content-${tabName}`).classList.remove('hidden');
    
    // Add active styles to clicked button
    const activeButton = document.getElementById(`tab-${tabName}`);
    activeButton.classList.add('bg-white', 'text-gray-900', 'shadow', 'border-red-500');
    activeButton.classList.remove('text-gray-700', 'hover:bg-gray-100', 'border-gray-200');
}

// Initialize pagination on page load
document.addEventListener('DOMContentLoaded', function() {
    initializePagination();
});

// Re-initialize pagination on window resize
let resizeTimer;
window.addEventListener('resize', function() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
        initializePagination();
    }, 250);
});
</script>
@endsection