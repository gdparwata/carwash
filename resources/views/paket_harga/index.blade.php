@extends('layouts.user')

@section('title', 'Paket Harga - CUCICAR')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-700 mb-4">Daftar Harga di CUCICAR</h1>
        </div>

        <!-- Tab Navigation -->
        <div class="flex justify-center mb-12">
            <div class="inline-flex rounded-lg bg-gray-200 p-1 gap-1">
                <button onclick="showTab('cuci-mobil')" id="tab-cuci-mobil" class="tab-button px-8 py-3 rounded-lg font-medium transition-all duration-200 bg-white text-gray-900 shadow">
                    Cuci Mobil
                </button>
                <button onclick="showTab('paket-banjir')" id="tab-paket-banjir" class="tab-button px-8 py-3 rounded-lg font-medium transition-all duration-200 text-gray-700 hover:bg-gray-100">
                    Paket Banjir
                </button>
                <button onclick="showTab('salon-mobil')" id="tab-salon-mobil" class="tab-button px-8 py-3 rounded-lg font-medium transition-all duration-200 text-gray-700 hover:bg-gray-100">
                    Salon mobil
                </button>
                <button onclick="showTab('jenis-mobil')" id="tab-jenis-mobil" class="tab-button px-8 py-3 rounded-lg font-medium transition-all duration-200 text-gray-700 hover:bg-gray-100">
                    Jenis Mobil
                </button>
            </div>
        </div>

        <!-- Content Sections -->
        
        <!-- Cuci Mobil Section -->
        <div id="content-cuci-mobil" class="tab-content">
            <h2 class="text-3xl font-bold text-gray-700 mb-8">Paket Cuci</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                @forelse($pakets->filter(fn($p) => stripos($p->kategori_paket, 'cuci') !== false) as $paket)
                <div class="bg-white rounded-lg border-2 border-gray-200 p-6 hover:shadow-lg transition-shadow duration-200">
                    <div class="flex items-center gap-2 mb-3">
                        @if($paket->tingkatan && str_contains(strtolower($paket->tingkatan->Tingkatan), 'basic'))
                        <span class="text-2xl">⭐</span>
                        @elseif($paket->tingkatan && str_contains(strtolower($paket->tingkatan->Tingkatan), 'standard'))
                        <span class="text-2xl">⭐⭐</span>
                        @elseif($paket->tingkatan && str_contains(strtolower($paket->tingkatan->Tingkatan), 'elite'))
                        <span class="text-2xl">⭐⭐⭐</span>
                        @else
                        <span class="text-2xl">⭐⭐⭐⭐</span>
                        @endif
                        <h3 class="text-xl font-bold text-gray-900">{{ $paket->tingkatan ? $paket->tingkatan->Tingkatan : 'Paket' }}</h3>
                    </div>
                    
                    <p class="text-sm text-gray-600 mb-4">{{ $paket->kategori_paket }}</p>
                    
                    @if($paket->tingkatan)
                    <div class="text-sm text-gray-600 mb-4 space-y-1">
                        {!! nl2br(e($paket->tingkatan->deskripsi)) !!}
                    </div>
                    @endif
                    
                    <div class="border-t pt-4">
                        <p class="text-xs text-gray-500 mb-1">Harga</p>
                        <p class="text-2xl font-bold text-red-500">
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

            <!-- Add Ons Section -->
            <h2 class="text-3xl font-bold text-gray-700 mb-8">Add Ons</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($addons ?? [] as $addon)
                <div class="bg-white rounded-lg border-2 border-gray-200 p-6 hover:shadow-lg transition-shadow duration-200">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-2xl">✨</span>
                        <h3 class="text-xl font-bold text-gray-900">{{ $addon->nama }}</h3>
                    </div>
                    
                    <div class="border-t pt-4">
                        <p class="text-xs text-gray-500 mb-1">Harga</p>
                        <p class="text-2xl font-bold text-red-500">Rp. {{ number_format($addon->harga, 0, ',', '.') }}</p>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12 text-gray-500">
                    <p>Tidak ada add-ons tersedia saat ini</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Paket Banjir Section -->
        <div id="content-paket-banjir" class="tab-content hidden">
            <h2 class="text-3xl font-bold text-gray-700 mb-8">Paket Banjir</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($pakets->filter(fn($p) => stripos($p->kategori_paket, 'banjir') !== false) as $paket)
                <div class="bg-white rounded-lg border-2 border-gray-200 p-6 hover:shadow-lg transition-shadow duration-200">
                    <div class="flex items-center gap-2 mb-3">
                        @if($paket->tingkatan && str_contains(strtolower($paket->tingkatan->Tingkatan), 'ringan'))
                        <span class="text-2xl">⭐</span>
                        @elseif($paket->tingkatan && str_contains(strtolower($paket->tingkatan->Tingkatan), 'sedang'))
                        <span class="text-2xl">⭐⭐</span>
                        @else
                        <span class="text-2xl">⭐⭐⭐</span>
                        @endif
                        <h3 class="text-xl font-bold text-gray-900">{{ $paket->tingkatan ? $paket->tingkatan->Tingkatan : 'Paket Banjir' }}</h3>
                    </div>
                    
                    <p class="text-sm text-gray-600 mb-4">{{ $paket->kategori_paket }}</p>
                    
                    @if($paket->tingkatan)
                    <div class="text-sm text-gray-600 mb-4 space-y-1">
                        {!! nl2br(e($paket->tingkatan->deskripsi)) !!}
                    </div>
                    @endif
                    
                    <div class="border-t pt-4">
                        <p class="text-xs text-gray-500 mb-1">Harga</p>
                        <p class="text-2xl font-bold text-red-500">
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
        </div>

        <!-- Salon Mobil Section -->
        <div id="content-salon-mobil" class="tab-content hidden">
            <h2 class="text-3xl font-bold text-gray-700 mb-8">Salon Mobil</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($pakets->filter(fn($p) => stripos($p->kategori_paket, 'salon') !== false) as $paket)
                <div class="bg-white rounded-lg border-2 border-gray-200 p-6 hover:shadow-lg transition-shadow duration-200">
                    <div class="flex items-center gap-2 mb-3">
                        @if($paket->tingkatan && str_contains(strtolower($paket->tingkatan->Tingkatan), 'refresh'))
                        <span class="text-2xl">⭐</span>
                        @elseif($paket->tingkatan && str_contains(strtolower($paket->tingkatan->Tingkatan), 'shine'))
                        <span class="text-2xl">⭐⭐</span>
                        @else
                        <span class="text-2xl">⭐⭐⭐</span>
                        @endif
                        <h3 class="text-xl font-bold text-gray-900">{{ $paket->tingkatan ? $paket->tingkatan->Tingkatan : 'Salon' }}</h3>
                    </div>
                    
                    <p class="text-sm text-gray-600 mb-4">{{ $paket->kategori_paket }}</p>
                    
                    @if($paket->tingkatan)
                    <div class="text-sm text-gray-600 mb-4 space-y-1">
                        {!! nl2br(e($paket->tingkatan->deskripsi)) !!}
                    </div>
                    @endif
                    
                    <div class="border-t pt-4">
                        <p class="text-xs text-gray-500 mb-1">Harga</p>
                        <p class="text-2xl font-bold text-red-500">
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
        </div>

        <!-- Jenis Mobil Section -->
        <div id="content-jenis-mobil" class="tab-content hidden">
            <h2 class="text-3xl font-bold text-gray-700 mb-8">Harga dari Jenis Mobil di CUCICAR</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($jenisKendaraans ?? [] as $jenis)
                <div class="bg-white rounded-lg border-2 border-gray-200 p-6 hover:shadow-lg transition-shadow duration-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $jenis->jenis_kendaraan }}</h3>
                    <p class="text-sm text-gray-600 mb-4">{{ $jenis->nama_kendaraan }}</p>
                    
                    <div class="border-t pt-4">
                        <p class="text-xs text-gray-500 mb-1">Harga</p>
                        <p class="text-2xl font-bold text-red-500">Rp. {{ number_format($jenis->harga, 0, ',', '.') }}</p>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12 text-gray-500">
                    <p>Tidak ada jenis kendaraan tersedia saat ini</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all content
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active styles from all buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('bg-white', 'text-gray-900', 'shadow');
        button.classList.add('text-gray-700', 'hover:bg-gray-100');
    });
    
    // Show selected content
    document.getElementById(`content-${tabName}`).classList.remove('hidden');
    
    // Add active styles to clicked button
    const activeButton = document.getElementById(`tab-${tabName}`);
    activeButton.classList.add('bg-white', 'text-gray-900', 'shadow');
    activeButton.classList.remove('text-gray-700', 'hover:bg-gray-100');
}
</script>
@endsection