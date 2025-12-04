@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<body class="bg-gray-50">
    <!-- Header -->
    <div class="pt-3 sm:pt-5"></div>
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 py-3 sm:py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-7 h-7 sm:w-8 sm:h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-2 sm:mr-3">
                        <i class="fas fa-car text-white text-sm sm:text-base"></i>
                    </div>
                    <h1 class="text-base sm:text-xl font-bold text-gray-900">Car Wash Management</h1>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <span class="hidden sm:inline text-sm text-gray-600">Admin Dashboard</span>
                    <div class="relative group">
                        @auth
                            @if(Auth::user()->profile_photo)
                                <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" 
                                     alt="{{ Auth::user()->name }}" 
                                     class="w-7 h-7 sm:w-8 sm:h-8 rounded-full object-cover border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition-colors">
                            @else
                                <div class="w-7 h-7 sm:w-8 sm:h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center cursor-pointer hover:shadow-lg transition-shadow">
                                    <span class="text-white text-xs sm:text-sm font-semibold">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                            <!-- Tooltip -->
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 p-3">
                                <div class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                        @else
                            <div class="w-7 h-7 sm:w-8 sm:h-8 bg-gray-300 rounded-full"></div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 py-4 sm:py-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-3 sm:gap-4 lg:gap-6 mb-6 sm:mb-8">
            <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
                <div class="flex flex-col sm:flex-row items-start sm:items-center">
                    <div class="p-2 sm:p-3 rounded-full bg-blue-100 mb-2 sm:mb-0 sm:mr-4">
                        <i class="fas fa-box text-blue-600 text-sm sm:text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm text-gray-600">Total Paket</p>
                        <p class="text-xl sm:text-2xl font-semibold text-gray-900" id="totalPaket">0</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
                <div class="flex flex-col sm:flex-row items-start sm:items-center">
                    <div class="p-2 sm:p-3 rounded-full bg-green-100 mb-2 sm:mb-0 sm:mr-4">
                        <i class="fas fa-percent text-green-600 text-sm sm:text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm text-gray-600">Total Diskon</p>
                        <p class="text-xl sm:text-2xl font-semibold text-gray-900" id="totalDiskon">0</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
                <div class="flex flex-col sm:flex-row items-start sm:items-center">
                    <div class="p-2 sm:p-3 rounded-full bg-purple-100 mb-2 sm:mb-0 sm:mr-4">
                        <i class="fas fa-tags text-purple-600 text-sm sm:text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm text-gray-600">Diskon Aktif</p>
                        <p class="text-xl sm:text-2xl font-semibold text-gray-900" id="diskonAktif">0</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
                <div class="flex flex-col sm:flex-row items-start sm:items-center">
                    <div class="p-2 sm:p-3 rounded-full bg-orange-100 mb-2 sm:mb-0 sm:mr-4">
                        <i class="fas fa-layer-group text-orange-600 text-sm sm:text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm text-gray-600">Tingkatan</p>
                        <p class="text-xl sm:text-2xl font-semibold text-gray-900" id="totalTingkatan">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
                <div class="flex flex-col sm:flex-row items-start sm:items-center">
                    <div class="p-2 sm:p-3 rounded-full bg-pink-100 mb-2 sm:mb-0 sm:mr-4">
                        <i class="fas fa-puzzle-piece text-pink-600 text-sm sm:text-base"></i>
                    </div>
                    <div>
                        <p class="text-xs sm:text-sm text-gray-600">Addons</p>
                        <p class="text-xl sm:text-2xl font-semibold text-gray-900" id="totalAddons">0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="border-b border-gray-200 overflow-x-auto">
                <nav class="flex space-x-4 sm:space-x-8 px-3 sm:px-6" aria-label="Tabs">
                    <button onclick="switchTab('paket')" id="tab-paket" class="tab-button py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap border-blue-500 text-blue-600">
                        <i class="fas fa-box mr-1 sm:mr-2"></i>Paket
                    </button>
                    <button onclick="switchTab('diskon')" id="tab-diskon" class="tab-button py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        <i class="fas fa-percent mr-1 sm:mr-2"></i>Diskon
                    </button>
                    <button onclick="switchTab('tingkatan')" id="tab-tingkatan" class="tab-button py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        <i class="fas fa-layer-group mr-1 sm:mr-2"></i>Tingkatan
                    </button>
                    <button onclick="switchTab('addons')" id="tab-addons" class="tab-button py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        <i class="fas fa-puzzle-piece mr-1 sm:mr-2"></i>Addons
                    </button>
                </nav>
            </div>

            <!-- Paket Content -->
            <div id="content-paket" class="tab-content">
                <div class="px-3 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-4">
                        <h2 class="text-base sm:text-lg font-medium text-gray-900">Manajemen Paket</h2>
                        <div class="flex flex-col sm:flex-row w-full sm:w-auto space-y-2 sm:space-y-0 sm:space-x-3">
                            <input type="text" id="searchPaket" placeholder="Cari paket..." class="w-full sm:w-auto px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            <button onclick="openModal('paket', 'add')" class="w-full sm:w-auto bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">
                                <i class="fas fa-plus mr-2"></i>Tambah
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori Paket</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase hidden sm:table-cell">Tingkatan</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="paketTableBody" class="bg-white divide-y divide-gray-200">
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Diskon Content -->
            <div id="content-diskon" class="tab-content hidden">
                <div class="px-3 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-4">
                        <h2 class="text-base sm:text-lg font-medium text-gray-900">Manajemen Diskon</h2>
                        <div class="flex flex-col sm:flex-row w-full sm:w-auto space-y-2 sm:space-y-0 sm:space-x-3">
                            <input type="text" id="searchDiskon" placeholder="Cari diskon..." class="w-full sm:w-auto px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500">
                            <button onclick="openModal('diskon', 'add')" class="w-full sm:w-auto bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-green-700">
                                <i class="fas fa-plus mr-2"></i>Tambah
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">%</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase hidden lg:table-cell">Periode</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase hidden md:table-cell">Status</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="diskonTableBody" class="bg-white divide-y divide-gray-200">
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tingkatan Content -->
            <div id="content-tingkatan" class="tab-content hidden">
                <div class="px-3 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-4">
                        <h2 class="text-base sm:text-lg font-medium text-gray-900">Manajemen Tingkatan</h2>
                        <button onclick="openModal('tingkatan', 'add')" class="w-full sm:w-auto bg-purple-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-purple-700">
                            <i class="fas fa-plus mr-2"></i>Tambah
                        </button>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tingkatan</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase hidden md:table-cell">Deskripsi</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tingkatanTableBody" class="bg-white divide-y divide-gray-200">
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Addons Content -->
            <div id="content-addons" class="tab-content hidden">
                <div class="px-3 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-4">
                        <h2 class="text-base sm:text-lg font-medium text-gray-900">Manajemen Addons</h2>
                        <div class="flex flex-col sm:flex-row w-full sm:w-auto space-y-2 sm:space-y-0 sm:space-x-3">
                            <input type="text" id="searchAddons" placeholder="Cari addons..." class="w-full sm:w-auto px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-pink-500 focus:border-pink-500">
                            <button onclick="openModal('addons', 'add')" class="w-full sm:w-auto bg-pink-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-pink-700">
                                <i class="fas fa-plus mr-2"></i>Tambah
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Addon</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase hidden md:table-cell">Paket Terkait</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="addonsTableBody" class="bg-white divide-y divide-gray-200">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Paket -->
    <div id="modalPaket" class="fixed inset-0 bg-black/30 backdrop-blur-[2px] flex items-center justify-center hidden z-50 p-4">
        <div class="p-4 sm:p-5 border w-full max-w-md shadow-lg rounded-md bg-white max-h-[90vh] overflow-y-auto">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900" id="modalPaketTitle">Tambah Paket</h3>
                    <button onclick="closeModal('paket')" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="formPaket" onsubmit="submitForm(event, 'paket')">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Kategori Paket</label>
                        <input type="text" id="kategori_paket" placeholder="Contoh: Paket Banjir, Paket Express" required class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Nama kategori layanan utama</p>
                    </div>
                    
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-500 mt-1 mr-2"></i>
                            <div class="text-xs text-blue-700">
                                <strong>Setelah membuat paket,</strong> Anda dapat menambahkan tingkatan-tingkatan (Bronze/Silver/Gold) untuk paket ini
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3 mt-6">
                        <button type="button" onclick="closeModal('paket')" class="w-full sm:w-auto bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Batal
                        </button>
                        <button type="submit" class="w-full sm:w-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Diskon -->
    <div id="modalDiskon" class="fixed inset-0 bg-black/30 backdrop-blur-[2px] flex items-center justify-center hidden z-50 p-4">
        <div class="p-4 sm:p-5 border w-full max-w-md shadow-lg rounded-md bg-white max-h-[90vh] overflow-y-auto">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900" id="modalDiskonTitle">Tambah Diskon</h3>
                    <button onclick="closeModal('diskon')" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="formDiskon" onsubmit="submitForm(event, 'diskon')">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Kode Diskon</label>
                        <input type="text" id="id_diskon" required class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Diskon</label>
                        <input type="text" id="nama" required class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Persentase (%)</label>
                        <input type="number" id="persen" min="0" max="100" step="0.01" required class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Berlaku Dari</label>
                        <input type="datetime-local" id="Berlaku_dari" required class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Berlaku Sampai</label>
                        <input type="datetime-local" id="Berlaku_sampai" required class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Dibuat Oleh</label>
                        <input type="text" id="dibuat_oleh" required class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    
                    <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3 mt-6">
                        <button type="button" onclick="closeModal('diskon')" class="w-full sm:w-auto bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Batal
                        </button>
                        <button type="submit" class="w-full sm:w-auto bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tingkatan -->
    <div id="modalTingkatan" class="fixed inset-0 bg-black/30 backdrop-blur-[2px] flex items-center justify-center hidden z-50 p-4">
        <div class="p-4 sm:p-5 border w-full max-w-md shadow-lg rounded-md bg-white max-h-[90vh] overflow-y-auto">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900" id="modalTingkatanTitle">Tambah Tingkatan</h3>
                    <button onclick="closeModal('tingkatan')" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="formTingkatan" onsubmit="submitForm(event, 'tingkatan')">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Paket</label>
                        <select id="id_paket" required class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="">Pilih Paket Dulu</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Paket mana yang akan memiliki tingkatan ini</p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Tingkatan</label>
                        <input type="text" id="Tingkatan" placeholder="Bronze / Silver / Gold" required class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <p class="text-xs text-gray-500 mt-1">Level layanan (Bronze/Silver/Gold/Platinum)</p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                        <textarea id="deskripsi" placeholder="Detail layanan yang termasuk..." required rows="3" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp)</label>
                        <input type="number" id="harga" placeholder="50000" min="0" step="1000" required class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    
                    <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-4">
                        <div class="flex items-start">
                            <i class="fas fa-lightbulb text-green-500 mt-1 mr-2"></i>
                            <div class="text-xs text-green-700">
                                <strong>Contoh:</strong> Paket Banjir → Bronze (Rp 50.000), Silver (Rp 75.000), Gold (Rp 100.000)
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3 mt-6">
                        <button type="button" onclick="closeModal('tingkatan')" class="w-full sm:w-auto bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Batal
                        </button>
                        <button type="submit" class="w-full sm:w-auto bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Addons -->
    <div id="modalAddons" class="fixed inset-0 bg-black/30 backdrop-blur-[2px] flex items-center justify-center hidden z-50 p-4">
        <div class="p-4 sm:p-5 border w-full max-w-md shadow-lg rounded-md bg-white max-h-[90vh] overflow-y-auto">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900" id="modalAddonsTitle">Tambah Addon</h3>
                    <button onclick="closeModal('addons')" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form id="formAddons" onsubmit="submitForm(event, 'addons')">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Addon</label>
                        <input type="text" id="addon_nama" placeholder="Contoh: Wax Premium, Coating, Engine Wash" required class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-500">
                        <p class="text-xs text-gray-500 mt-1">Nama layanan tambahan</p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp)</label>
                        <input type="number" id="addon_harga" placeholder="25000" min="0" step="1000" required class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-500">
                        <p class="text-xs text-gray-500 mt-1">Harga tambahan untuk addon ini</p>
                    </div>
                    
                    <div class="bg-pink-50 border border-pink-200 rounded-lg p-3 mb-4">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-pink-500 mt-1 mr-2"></i>
                            <div class="text-xs text-pink-700">
                                <strong>Info:</strong> Addon dapat ditambahkan ke paket mana saja setelah pembuatan
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3 mt-6">
                        <button type="button" onclick="closeModal('addons')" class="w-full sm:w-auto bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Batal
                        </button>
                        <button type="submit" class="w-full sm:w-auto bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Kelola Paket Addons -->
<div id="modalKelolaAddonsPaket" class="fixed inset-0 bg-black/30 backdrop-blur-[2px] flex items-center justify-center hidden z-50 p-4">
    <div class="p-4 sm:p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white max-h-[90vh] overflow-y-auto">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-base sm:text-lg font-medium text-gray-900">Kelola Paket untuk Addon: <span id="addonNameTitle"></span></h3>
                <button onclick="closeModalKelolaAddonsPaket()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Paket untuk Ditambahkan</label>
                <div class="flex gap-2">
                    <select id="selectPaketForAddon" class="flex-1 shadow border rounded py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-500">
                        <option value="">-- Pilih Paket --</option>
                    </select>
                    <button onclick="attachPaketToAddon()" class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-plus mr-2"></i>Tambah
                    </button>
                </div>
            </div>

            <div class="border-t pt-4">
                <h4 class="text-sm font-semibold mb-3 text-gray-700">Paket yang Sudah Terkait:</h4>
                <div id="listPaketAddon" class="space-y-2">
                    <!-- List paket akan dimuat di sini -->
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button onclick="closeModalKelolaAddonsPaket()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

    <!-- Loading -->
    <div id="loading" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 shadow-xl">
            <div class="flex items-center space-x-3">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                <span class="text-gray-700 font-medium">Loading...</span>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div id="toast" class="fixed top-4 right-4 bg-green-500 text-white px-4 sm:px-6 py-3 sm:py-4 rounded-lg shadow-lg hidden z-50 max-w-sm">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span id="toastMessage" class="text-sm sm:text-base">Success!</span>
        </div>
    </div>
    

<script>
let currentEditId = null;
let currentEditType = null;
let paketData = [];
let diskonData = [];
let tingkatanData = [];
let addonsData = [];

const BASE_URL = window.location.origin;
const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

document.addEventListener('DOMContentLoaded', function() {
    console.log('=== 🚀 PAGE LOADED ===');
    console.log('BASE_URL:', BASE_URL);
    console.log('CSRF_TOKEN:', CSRF_TOKEN ? '✅ Found' : '❌ Missing');
    
    testConnection();
    setupEventListeners();
});

async function testConnection() {
    console.log('=== 🔌 TESTING API CONNECTION ===');
    
    try {
        const response = await fetch(`${BASE_URL}/api/pakets`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });
        
        console.log('Response status:', response.status);
        
        if (!response.ok) {
            console.error('❌ API Error:', response.status, response.statusText);
            const text = await response.text();
            console.error('Error details:', text);
            showToast('Gagal koneksi ke API: ' + response.status, 'error');
            return;
        }
        
        const data = await response.json();
        console.log('✅ API Response:', data);
        
        loadAllData();
        
    } catch (error) {
        console.error('❌ Connection Error:', error);
        showToast('Error: ' + error.message, 'error');
    }
}

function setupEventListeners() {
    const searchPaket = document.getElementById('searchPaket');
    const searchDiskon = document.getElementById('searchDiskon');
    const searchAddons = document.getElementById('searchAddons');
    
    if (searchPaket) {
        searchPaket.addEventListener('input', function(e) {
            filterTable('paket', e.target.value);
        });
    }
    
    if (searchDiskon) {
        searchDiskon.addEventListener('input', function(e) {
            filterTable('diskon', e.target.value);
        });
    }

    if (searchAddons) {
        searchAddons.addEventListener('input', function(e) {
            filterTable('addons', e.target.value);
        });
    }
}

async function apiCall(endpoint, method = 'GET', data = null) {
    console.log(`📡 API Call: ${method} ${endpoint}`);
    if (data) console.log('📦 Data:', data);
    
    const options = {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        }
    };
    
    if (CSRF_TOKEN) {
        options.headers['X-CSRF-TOKEN'] = CSRF_TOKEN;
    }
    
    if (data && method !== 'GET') {
        options.body = JSON.stringify(data);
    }
    
    try {
        const response = await fetch(`${BASE_URL}${endpoint}`, options);
        
        console.log(`📨 Response status: ${response.status}`);
        
        if (!response.ok) {
            const errorText = await response.text();
            console.error('❌ API Error:', errorText);
            throw new Error(`HTTP ${response.status}: ${errorText}`);
        }
        
        const result = await response.json();
        console.log('✅ API Success:', result);
        return result;
    } catch (error) {
        console.error('❌ Fetch error:', error);
        throw error;
    }
}

async function loadAllData() {
    console.log('=== 🔄 LOADING ALL DATA ===');
    showLoading();
    
    try {
        await loadPaketData();
        await loadTingkatanData();
        await loadDiskonData();
        await loadAddonsData();
        populatePaketSelect();
        updateStats();
        console.log('✅ All data loaded successfully');
    } catch (error) {
        console.error('❌ Error loading data:', error);
        showToast('Error loading data: ' + error.message, 'error');
    } finally {
        hideLoading();
    }
}

async function loadPaketData() {
    try {
        console.log('📥 Loading paket data...');
        const response = await apiCall('/api/pakets');
        paketData = Array.isArray(response) ? response : [];
        console.log(`✅ Paket loaded: ${paketData.length} items`);
        renderPaketTable();
    } catch (error) {
        console.error('❌ Error loading paket:', error);
        paketData = [];
        renderPaketTable();
        throw error;
    }
}

async function loadTingkatanData() {
    try {
        console.log('📥 Loading tingkatan data...');
        const response = await apiCall('/api/tingkatans');
        tingkatanData = Array.isArray(response) ? response : [];
        console.log(`✅ Tingkatan loaded: ${tingkatanData.length} items`);
        renderTingkatanTable();
    } catch (error) {
        console.error('❌ Error loading tingkatan:', error);
        tingkatanData = [];
        renderTingkatanTable();
    }
}

async function loadDiskonData() {
    try {
        console.log('📥 Loading diskon data...');
        const response = await apiCall('/api/diskons');
        diskonData = Array.isArray(response) ? response : [];
        console.log(`✅ Diskon loaded: ${diskonData.length} items`);
        renderDiskonTable();
    } catch (error) {
        console.error('❌ Error loading diskon:', error);
        diskonData = [];
        renderDiskonTable();
    }
}

async function loadAddonsData() {
    try {
        console.log('📥 Loading addons data...');
        const response = await apiCall('/api/addons');
        
        // Pastikan response adalah array
        addonsData = Array.isArray(response) ? response : [];
        
        console.log(`✅ Addons loaded: ${addonsData.length} items`, addonsData);
        renderAddonsTable();
    } catch (error) {
        console.error('❌ Error loading addons:', error);
        addonsData = [];
        renderAddonsTable();
    }
}

function renderPaketTable() {
    const tbody = document.getElementById('paketTableBody');
    
    if (!tbody) {
        console.error('❌ Table body not found: paketTableBody');
        return;
    }
    
    console.log('🎨 Rendering paket table...');
    
    if (paketData.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" class="px-3 sm:px-6 py-4 text-center text-gray-500">Tidak ada data paket</td></tr>';
        return;
    }

    tbody.innerHTML = '';
    paketData.forEach(paket => {
        const paketId = paket.id_Paket || paket.id_paket;
        const tingkatanCount = paket.tingkatans ? paket.tingkatans.length : 0;
        
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900">${paketId}</td>
            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">${paket.kategori_paket}</td>
            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 hidden sm:table-cell">
                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                    ${tingkatanCount} Tingkatan
                </span>
            </td>
            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-right text-xs sm:text-sm font-medium">
                <button onclick="editItem('paket', ${paketId})" class="text-indigo-600 hover:text-indigo-900 mr-2 sm:mr-3">
                    <i class="fas fa-edit"></i>
                </button>
                <button onclick="deleteItem('paket', ${paketId})" class="text-red-600 hover:text-red-900">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });
    
    console.log('✅ Paket table rendered');
}

function renderTingkatanTable() {
    const tbody = document.getElementById('tingkatanTableBody');
    
    if (!tbody) {
        console.error('❌ Table body not found: tingkatanTableBody');
        return;
    }
    
    console.log('🎨 Rendering tingkatan table...');
    
    if (tingkatanData.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="px-3 sm:px-6 py-4 text-center text-gray-500">Tidak ada data tingkatan</td></tr>';
        return;
    }

    tbody.innerHTML = '';
    tingkatanData.forEach(tingkatan => {
        const paket = tingkatan.paket || {};
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900">${tingkatan.id_Tingkatan}</td>
            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                <div class="font-semibold">${tingkatan.Tingkatan}</div>
                <div class="text-xs text-gray-500">${paket.kategori_paket || '-'}</div>
            </td>
            <td class="px-3 sm:px-6 py-4 text-xs sm:text-sm text-gray-900 hidden md:table-cell">${tingkatan.deskripsi}</td>
            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">Rp ${parseFloat(tingkatan.harga).toLocaleString('id-ID')}</td>
            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-right text-xs sm:text-sm font-medium">
                <button onclick="editItem('tingkatan', ${tingkatan.id_Tingkatan})" class="text-indigo-600 hover:text-indigo-900 mr-2 sm:mr-3">
                    <i class="fas fa-edit"></i>
                </button>
                <button onclick="deleteItem('tingkatan', ${tingkatan.id_Tingkatan})" class="text-red-600 hover:text-red-900">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });
    
    console.log('✅ Tingkatan table rendered');
}

function renderDiskonTable() {
    const tbody = document.getElementById('diskonTableBody');
    
    if (!tbody) {
        console.error('❌ Table body not found: diskonTableBody');
        return;
    }
    
    console.log('🎨 Rendering diskon table...');
    
    if (diskonData.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="px-3 sm:px-6 py-4 text-center text-gray-500">Tidak ada data diskon</td></tr>';
        return;
    }

    tbody.innerHTML = '';
    diskonData.forEach(diskon => {
        // 🔥 Ambil ID dengan fallback
        const diskonId = diskon.id_Diskon || diskon.id_diskon;
        
        const now = new Date();
        const berlakuDari = new Date(diskon.Berlaku_dari);
        const berlakuSampai = new Date(diskon.Berlaku_sampai);
        const isActive = now >= berlakuDari && now <= berlakuSampai;

        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm font-mono text-gray-900">${diskonId}</td>
            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">${diskon.nama}</td>
            <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                    ${diskon.persen}%
                </span>
            </td>
            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 hidden lg:table-cell">
                <div>${berlakuDari.toLocaleDateString('id-ID')}</div>
                <div class="text-gray-500">s/d ${berlakuSampai.toLocaleDateString('id-ID')}</div>
            </td>
            <td class="px-3 sm:px-6 py-4 whitespace-nowrap hidden md:table-cell">
                <span class="px-2 py-1 text-xs font-semibold rounded-full ${isActive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                    ${isActive ? 'Aktif' : 'Tidak Aktif'}
                </span>
            </td>
            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-right text-xs sm:text-sm font-medium">
                <button onclick="editItem('diskon', ${diskonId})" class="text-indigo-600 hover:text-indigo-900 mr-2 sm:mr-3">
                    <i class="fas fa-edit"></i>
                </button>
                <button onclick="deleteItem('diskon', ${diskonId})" class="text-red-600 hover:text-red-900">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });
    
    console.log('✅ Diskon table rendered');
}

function renderAddonsTable() {
    const tbody = document.getElementById('addonsTableBody');
    
    if (!tbody) {
        console.error('❌ Table body not found: addonsTableBody');
        return;
    }
    
    console.log('🎨 Rendering addons table...');
    
    if (addonsData.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="px-3 sm:px-6 py-4 text-center text-gray-500">Tidak ada data addons</td></tr>';
        return;
    }

    tbody.innerHTML = '';
    addonsData.forEach(addon => {
        const addonId = addon.id_addons || addon.id;
        const paketCount = addon.pakets ? addon.pakets.length : 0;
        const paketNames = addon.pakets ? addon.pakets.map(p => p.kategori_paket).join(', ') : '-';
        
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900">${addonId}</td>
            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">${addon.nama}</td>
            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">Rp ${parseFloat(addon.harga).toLocaleString('id-ID')}</td>
            <td class="px-3 sm:px-6 py-4 text-xs sm:text-sm text-gray-900 hidden md:table-cell">
                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-pink-100 text-pink-800">
                    ${paketCount} Paket
                </span>
                ${paketCount > 0 ? `<div class="text-xs text-gray-500 mt-1">${paketNames}</div>` : ''}
            </td>
            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm">
                <button onclick="managePaketAddons(${addonId})" class="text-blue-600 hover:text-blue-900 mr-2" title="Kelola Paket">
                    <i class="fas fa-link"></i>
                </button>
            </td>
            <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-right text-xs sm:text-sm font-medium">
                <button onclick="editItem('addons', ${addonId})" class="text-indigo-600 hover:text-indigo-900 mr-2 sm:mr-3">
                    <i class="fas fa-edit"></i>
                </button>
                <button onclick="deleteItem('addons', ${addonId})" class="text-red-600 hover:text-red-900">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });
    
    console.log('✅ Addons table rendered');
}

function populatePaketSelect() {
    const select = document.getElementById('id_paket');
    if (!select) {
        console.error('❌ Dropdown id_paket tidak ditemukan!');
        return;
    }
    
    console.log('📦 Populating paket dropdown...');
    
    select.innerHTML = '<option value="">Pilih Paket Dulu</option>';
    
    if (paketData.length === 0) {
        console.warn('⚠️ paketData kosong!');
        select.innerHTML += '<option value="" disabled>Tidak ada paket tersedia</option>';
        return;
    }
    
    paketData.forEach(paket => {
        const option = document.createElement('option');
        const paketId = paket.id_Paket || paket.id_paket;
        
        option.value = paketId;
        option.textContent = `${paket.kategori_paket} (ID: ${paketId})`;
        select.appendChild(option);
    });
    
    console.log('✅ Dropdown berhasil diisi dengan', select.options.length - 1, 'paket');
}

function populateForm(type, id) {
    console.log(`📝 Populating form for ${type} with ID:`, id);
    
    if (type === 'paket') {
        const data = paketData.find(item => 
            (item.id_Paket || item.id_paket) === id
        );
        if (data) {
            document.getElementById('kategori_paket').value = data.kategori_paket;
        }
    } 
    else if (type === 'diskon') {
        // 🔥 FIX: Cari dengan kedua kemungkinan field name
        const data = diskonData.find(item => {
            const itemId = item.id_Diskon || item.id_diskon;
            return itemId === id;
        });
        
        console.log('🔍 Searching for ID:', id);
        console.log('📋 Found diskon data:', data);
        console.log('📦 All diskon data:', diskonData);
        
        if (data) {
            // Set values
            const diskonId = data.id_Diskon || data.id_diskon;
            document.getElementById('id_diskon').value = diskonId;
            document.getElementById('id_diskon').disabled = true;
            document.getElementById('nama').value = data.nama;
            document.getElementById('persen').value = data.persen;
            
            // Format datetime untuk input datetime-local
            const formatDateTime = (dateString) => {
                const date = new Date(dateString);
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                return `${year}-${month}-${day}T${hours}:${minutes}`;
            };
            
            document.getElementById('Berlaku_dari').value = formatDateTime(data.Berlaku_dari);
            document.getElementById('Berlaku_sampai').value = formatDateTime(data.Berlaku_sampai);
            document.getElementById('dibuat_oleh').value = data.dibuat_oleh;
            
            console.log('✅ Form populated successfully');
        } else {
            console.error('❌ Diskon data not found for ID:', id);
            showToast('Data diskon tidak ditemukan', 'error');
        }
    } 
    else if (type === 'tingkatan') {
        const data = tingkatanData.find(item => item.id_Tingkatan === id);
        if (data) {
            document.getElementById('id_paket').value = data.id_paket || data.id_Paket;
            document.getElementById('Tingkatan').value = data.Tingkatan;
            document.getElementById('deskripsi').value = data.deskripsi;
            document.getElementById('harga').value = data.harga;
        }
    }
    else if (type === 'addons') {
        const data = addonsData.find(item => (item.id_addons || item.id) === id);
        if (data) {
            document.getElementById('addon_nama').value = data.nama;
            document.getElementById('addon_harga').value = data.harga;
        }
    }
}

async function submitForm(event, type) {
    event.preventDefault();
    console.log(`📤 Submitting form for type: ${type}`);
    
    const data = {};

    if (type === 'paket') {
        data.kategori_paket = document.getElementById('kategori_paket').value;
    } 
    else if (type === 'diskon') {
        data.id_diskon = document.getElementById('id_diskon').value;
        data.nama = document.getElementById('nama').value;
        data.persen = document.getElementById('persen').value;
        data.Berlaku_dari = document.getElementById('Berlaku_dari').value;
        data.Berlaku_sampai = document.getElementById('Berlaku_sampai').value;
        data.dibuat_oleh = document.getElementById('dibuat_oleh').value;
    } 
    else if (type === 'tingkatan') {
        const idPaket = document.getElementById('id_paket').value;
        
        if (!idPaket) {
            showToast('Silakan pilih paket terlebih dahulu!', 'error');
            return;
        }
        
        data.id_paket = parseInt(idPaket);
        data.Tingkatan = document.getElementById('Tingkatan').value.trim();
        data.deskripsi = document.getElementById('deskripsi').value.trim();
        data.harga = parseFloat(document.getElementById('harga').value);
    }
    else if (type === 'addons') {
        data.nama = document.getElementById('addon_nama').value.trim();
        data.harga = parseFloat(document.getElementById('addon_harga').value);
    }
    
    try {
        if (currentEditId) {
            await updateItem(type, currentEditId, data);
        } else {
            await createItem(type, data);
        }
    } catch (error) {
        console.error('❌ Error during submit:', error);
    }
}

async function createItem(type, data) {
    showLoading();
    try {
        let endpoint = '';
        if (type === 'paket') endpoint = '/admin/pakets';
        else if (type === 'diskon') endpoint = '/admin/diskons';
        else if (type === 'tingkatan') endpoint = '/admin/tingkatans';
        else if (type === 'addons') endpoint = '/api/addons';

        console.log(`📤 Creating ${type} at ${endpoint}`, data);
        await apiCall(endpoint, 'POST', data);
        
        await loadAllData();
        closeModal(type);
        showToast(`${type.charAt(0).toUpperCase() + type.slice(1)} berhasil ditambahkan!`);
    } catch (error) {
        console.error('❌ Error creating item:', error);
        showToast(error.message || 'Error saat menambahkan data', 'error');
    } finally {
        hideLoading();
    }
}

async function updateItem(type, id, data) {
    showLoading();
    try {
        let endpoint = '';
        if (type === 'paket') endpoint = `/admin/pakets/${id}`;
        else if (type === 'diskon') endpoint = `/admin/diskons/${id}`; // Gunakan ID asli
        else if (type === 'tingkatan') endpoint = `/admin/tingkatans/${id}`;
        else if (type === 'addons') endpoint = `/api/addons/${id}`;

        console.log(`📤 Updating ${type} at ${endpoint}`, data);
        await apiCall(endpoint, 'PUT', data);
        
        await loadAllData();
        closeModal(type);
        showToast(`${type.charAt(0).toUpperCase() + type.slice(1)} berhasil diupdate!`);
    } catch (error) {
        console.error('❌ Error updating item:', error);
        showToast(error.message || 'Error saat mengupdate data', 'error');
    } finally {
        hideLoading();
    }
}
async function deleteItem(type, id) {
    console.log(`🗑️ Deleting ${type} with ID:`, id);
    
    const confirmMessage = `Apakah Anda yakin ingin menghapus ${type} ini?`;
    
    if (!confirm(confirmMessage)) {
        console.log('❌ Delete cancelled by user');
        return;
    }
    
    showLoading();
    try {
        let endpoint = '';
        if (type === 'paket') endpoint = `/admin/pakets/${id}`;
        else if (type === 'diskon') endpoint = `/admin/diskons/${id}`;
        else if (type === 'tingkatan') endpoint = `/admin/tingkatans/${id}`;
        else if (type === 'addons') endpoint = `/api/addons/${id}`;

        console.log(`📤 Deleting at ${endpoint}`);
        await apiCall(endpoint, 'DELETE');
        
        await loadAllData();
        showToast(`${type.charAt(0).toUpperCase() + type.slice(1)} berhasil dihapus!`);
    } catch (error) {
        console.error('❌ Error deleting item:', error);
        showToast(error.message || 'Error saat menghapus data', 'error');
    } finally {
        hideLoading();
    }
}

function editItem(type, id) {
    console.log(`✏️ Editing ${type} with ID:`, id);
    currentEditId = id;
    currentEditType = type;
    openModal(type, 'edit');
    populateForm(type, id);
}

function openModal(type, mode = 'add') {
    console.log(`🔓 Opening modal for ${type} in ${mode} mode`);
    
    const modal = document.getElementById(`modal${type.charAt(0).toUpperCase() + type.slice(1)}`);
    const title = document.getElementById(`modal${type.charAt(0).toUpperCase() + type.slice(1)}Title`);
    
    if (!modal) {
        console.error(`❌ Modal not found: modal${type.charAt(0).toUpperCase() + type.slice(1)}`);
        return;
    }
    
    if (mode === 'add') {
        currentEditId = null;
        currentEditType = null;
        
        if (title) {
            title.textContent = `Tambah ${type.charAt(0).toUpperCase() + type.slice(1)}`;
        }
        
        // Reset form
        const form = document.getElementById(`form${type.charAt(0).toUpperCase() + type.slice(1)}`);
        if (form) form.reset();
        
        // Enable id_diskon field jika mode add untuk diskon
        if (type === 'diskon') {
            const idDiskonField = document.getElementById('id_diskon');
            if (idDiskonField) idDiskonField.disabled = false;
        }
    } else {
        if (title) {
            title.textContent = `Edit ${type.charAt(0).toUpperCase() + type.slice(1)}`;
        }
    }
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal(type) {
    console.log(`🔒 Closing modal for ${type}`);
    
    const modal = document.getElementById(`modal${type.charAt(0).toUpperCase() + type.slice(1)}`);
    
    if (!modal) {
        console.error(`❌ Modal not found: modal${type.charAt(0).toUpperCase() + type.slice(1)}`);
        return;
    }
    
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
    
    // Reset form
    const form = document.getElementById(`form${type.charAt(0).toUpperCase() + type.slice(1)}`);
    if (form) form.reset();
    
    currentEditId = null;
    currentEditType = null;
}

function switchTab(tab) {
    console.log(`🔄 Switching to tab: ${tab}`);
    
    // Hide all contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active state from all tabs
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected content
    const content = document.getElementById(`content-${tab}`);
    if (content) {
        content.classList.remove('hidden');
    }
    
    // Add active state to selected tab
    const tabButton = document.getElementById(`tab-${tab}`);
    if (tabButton) {
        tabButton.classList.add('border-blue-500', 'text-blue-600');
        tabButton.classList.remove('border-transparent', 'text-gray-500');
    }
}

function filterTable(type, searchTerm) {
    console.log(`🔍 Filtering ${type} table with term: "${searchTerm}"`);
    
    const tbody = document.getElementById(`${type}TableBody`);
    if (!tbody) return;
    
    const rows = tbody.getElementsByTagName('tr');
    const lowerSearchTerm = searchTerm.toLowerCase();
    
    let visibleCount = 0;
    
    for (let row of rows) {
        const text = row.textContent.toLowerCase();
        
        if (text.includes(lowerSearchTerm)) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    }
    
    console.log(`✅ Filtered: ${visibleCount} rows visible`);
}

function updateStats() {
    console.log('📊 Updating statistics...');
    
    // Total Paket
    const totalPaket = paketData.length;
    document.getElementById('totalPaket').textContent = totalPaket;
    
    // Total Diskon
    const totalDiskon = diskonData.length;
    document.getElementById('totalDiskon').textContent = totalDiskon;
    
    // Diskon Aktif
    const now = new Date();
    const diskonAktif = diskonData.filter(diskon => {
        const dari = new Date(diskon.Berlaku_dari);
        const sampai = new Date(diskon.Berlaku_sampai);
        return now >= dari && now <= sampai;
    }).length;
    document.getElementById('diskonAktif').textContent = diskonAktif;
    
    // Total Tingkatan
    const totalTingkatan = tingkatanData.length;
    document.getElementById('totalTingkatan').textContent = totalTingkatan;
    
    // Total Addons
    const totalAddons = addonsData.length;
    document.getElementById('totalAddons').textContent = totalAddons;
    
    console.log('✅ Stats updated:', {
        totalPaket,
        totalDiskon,
        diskonAktif,
        totalTingkatan,
        totalAddons
    });
}

function showLoading() {
    const loading = document.getElementById('loading');
    if (loading) {
        loading.classList.remove('hidden');
    }
}

function hideLoading() {
    const loading = document.getElementById('loading');
    if (loading) {
        loading.classList.add('hidden');
    }
}

function showToast(message, type = 'success') {
    console.log(`🔔 Toast: [${type}] ${message}`);
    
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toastMessage');
    
    if (!toast || !toastMessage) return;
    
    toastMessage.textContent = message;
    
    // Change color based on type
    toast.classList.remove('bg-green-500', 'bg-red-500', 'bg-blue-500');
    
    if (type === 'error') {
        toast.classList.add('bg-red-500');
    } else if (type === 'info') {
        toast.classList.add('bg-blue-500');
    } else {
        toast.classList.add('bg-green-500');
    }
    
    toast.classList.remove('hidden');
    
    // Auto hide after 3 seconds
    setTimeout(() => {
        toast.classList.add('hidden');
    }, 3000);
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modals = ['modalPaket', 'modalDiskon', 'modalTingkatan', 'modalAddons'];
    
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (modal && event.target === modal) {
            const type = modalId.replace('modal', '').toLowerCase();
            closeModal(type);
        }
    });
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modals = ['modalPaket', 'modalDiskon', 'modalTingkatan', 'modalAddons'];
        
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (modal && !modal.classList.contains('hidden')) {
                const type = modalId.replace('modal', '').toLowerCase();
                closeModal(type);
            }
        });
    }
});

console.log('✅ All functions loaded successfully');

let currentAddonId = null;

// Buka modal kelola paket untuk addon
async function managePaketAddons(addonId) {
    console.log('🔗 Managing paket for addon:', addonId);
    currentAddonId = addonId;
    
    const addon = addonsData.find(a => (a.id_addons || a.id) === addonId);
    if (!addon) {
        showToast('Addon tidak ditemukan', 'error');
        return;
    }
    
    // Set addon name di title
    document.getElementById('addonNameTitle').textContent = addon.nama;
    
    // Populate select paket
    populateSelectPaketForAddon(addon);
    
    // Load list paket yang sudah terkait
    renderPaketListForAddon(addon);
    
    // Show modal
    document.getElementById('modalKelolaAddonsPaket').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

// Close modal kelola paket addons
function closeModalKelolaAddonsPaket() {
    document.getElementById('modalKelolaAddonsPaket').classList.add('hidden');
    document.body.style.overflow = 'auto';
    currentAddonId = null;
}

// Populate dropdown paket (yang belum terkait)
function populateSelectPaketForAddon(addon) {
    const select = document.getElementById('selectPaketForAddon');
    select.innerHTML = '<option value="">-- Pilih Paket --</option>';
    
    const linkedPaketIds = addon.pakets ? addon.pakets.map(p => p.id_Paket || p.id_paket) : [];
    
    paketData.forEach(paket => {
        const paketId = paket.id_Paket || paket.id_paket;
        
        // Hanya tampilkan paket yang belum terkait
        if (!linkedPaketIds.includes(paketId)) {
            const option = document.createElement('option');
            option.value = paketId;
            option.textContent = paket.kategori_paket;
            select.appendChild(option);
        }
    });
}

// Render list paket yang sudah terkait
function renderPaketListForAddon(addon) {
    const container = document.getElementById('listPaketAddon');
    
    if (!addon.pakets || addon.pakets.length === 0) {
        container.innerHTML = '<p class="text-sm text-gray-500 italic">Belum ada paket terkait</p>';
        return;
    }
    
    container.innerHTML = '';
    addon.pakets.forEach(paket => {
        const paketId = paket.id_Paket || paket.id_paket;
        const div = document.createElement('div');
        div.className = 'flex items-center justify-between bg-gray-50 p-3 rounded-lg';
        div.innerHTML = `
            <span class="text-sm font-medium text-gray-800">${paket.kategori_paket}</span>
            <button onclick="detachPaketFromAddon(${paketId})" class="text-red-600 hover:text-red-800">
                <i class="fas fa-unlink"></i> Lepas
            </button>
        `;
        container.appendChild(div);
    });
}

// Attach paket ke addon
async function attachPaketToAddon() {
    const paketId = document.getElementById('selectPaketForAddon').value;
    
    if (!paketId) {
        showToast('Pilih paket terlebih dahulu', 'error');
        return;
    }
    
    showLoading();
    try {
        await apiCall(`/api/addons/${currentAddonId}/attach-paket`, 'POST', {
            id_paket: parseInt(paketId)
        });
        
        await loadAddonsData();
        
        const addon = addonsData.find(a => (a.id_addons || a.id) === currentAddonId);
        populateSelectPaketForAddon(addon);
        renderPaketListForAddon(addon);
        
        showToast('Paket berhasil ditambahkan ke addon!');
    } catch (error) {
        console.error('❌ Error attaching paket:', error);
        showToast(error.message || 'Error menambahkan paket', 'error');
    } finally {
        hideLoading();
    }
}

// Detach paket dari addon
async function detachPaketFromAddon(paketId) {
    if (!confirm('Lepaskan paket ini dari addon?')) {
        return;
    }
    
    showLoading();
    try {
        await apiCall(`/api/addons/${currentAddonId}/detach-paket`, 'POST', {
            id_paket: parseInt(paketId)
        });
        
        await loadAddonsData();
        
        const addon = addonsData.find(a => (a.id_addons || a.id) === currentAddonId);
        populateSelectPaketForAddon(addon);
        renderPaketListForAddon(addon);
        
        showToast('Paket berhasil dilepas dari addon!');
    } catch (error) {
        console.error('❌ Error detaching paket:', error);
        showToast(error.message || 'Error melepas paket', 'error');
    } finally {
        hideLoading();
    }
}

</script>
</body>
@endsection