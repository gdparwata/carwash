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
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-6 sm:mb-8">
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
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
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
                        <input type="text" id="kategori_paket" required class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tingkatan</label>
                        <select id="id_Tingkatan" required class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Tingkatan</option>
                        </select>
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
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tingkatan</label>
                        <input type="text" id="Tingkatan" required class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                        <textarea id="deskripsi" required rows="3" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Harga</label>
                        <input type="number" id="harga" min="0" step="0.01" required class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
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

        const BASE_URL = window.location.origin;
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded, starting data fetch...');
            console.log('BASE_URL:', BASE_URL);
            console.log('CSRF_TOKEN:', CSRF_TOKEN ? 'Found' : 'Missing');
            loadAllData();
            setupEventListeners();
        });

        function setupEventListeners() {
            document.getElementById('searchPaket').addEventListener('input', function(e) {
                filterTable('paket', e.target.value);
            });
            
            document.getElementById('searchDiskon').addEventListener('input', function(e) {
                filterTable('diskon', e.target.value);
            });
        }

        async function apiCall(endpoint, method = 'GET', data = null) {
            console.log(`API Call: ${method} ${endpoint}`, data);
            
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
                
                console.log(`Response status: ${response.status}`);
                
                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('API Error:', errorText);
                    throw new Error(`HTTP ${response.status}: ${errorText}`);
                }
                
                const result = await response.json();
                console.log('API Success:', result);
                return result;
            } catch (error) {
                console.error('Fetch error:', error);
                throw error;
            }
        }

        async function loadAllData() {
            await loadTingkatanData();
            await loadPaketData();
            await loadDiskonData();
            updateStats();
        }

        async function loadTingkatanData() {
            try {
                console.log('Loading tingkatan data...');
                const response = await apiCall('/api/tingkatans');
                tingkatanData = Array.isArray(response) ? response : [];
                console.log('Tingkatan loaded:', tingkatanData.length);
                renderTingkatanTable();
                populateTingkatanSelect();
            } catch (error) {
                console.error('Error loading tingkatan:', error);
                tingkatanData = [];
                renderTingkatanTable();
                console.warn('Tingkatan API might not be available yet');
            }
        }

        async function loadPaketData() {
            try {
                console.log('Loading paket data...');
                const response = await apiCall('/api/pakets');
                paketData = Array.isArray(response) ? response : [];
                console.log('Paket loaded:', paketData.length);
                renderPaketTable();
            } catch (error) {
                console.error('Error loading paket:', error);
                paketData = [];
                renderPaketTable();
                console.warn('Paket API might not be available yet');
            }
        }

        async function loadDiskonData() {
            try {
                console.log('Loading diskon data...');
                const response = await apiCall('/api/diskons');
                diskonData = Array.isArray(response) ? response : [];
                console.log('Diskon loaded:', diskonData.length);
                renderDiskonTable();
            } catch (error) {
                console.error('Error loading diskon:', error);
                diskonData = [];
                renderDiskonTable();
                console.warn('Diskon API might not be available yet');
            }
        }

        function renderPaketTable() {
            const tbody = document.getElementById('paketTableBody');
            
            tbody.innerHTML = '<tr><td colspan="5" class="px-3 sm:px-6 py-4 text-center text-gray-500"><i class="fas fa-spinner fa-spin mr-2"></i>Memuat data...</td></tr>';

            setTimeout(() => {
                if (paketData.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="px-3 sm:px-6 py-4 text-center text-gray-500">Tidak ada data</td></tr>';
                    return;
                }

                tbody.innerHTML = '';
                paketData.forEach(paket => {
                    const tingkatan = paket.tingkatan || {};
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900">${paket.id_Paket}</td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">${paket.kategori_paket}</td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 hidden sm:table-cell">${tingkatan.Tingkatan || '-'}</td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">Rp ${tingkatan.harga ? parseFloat(tingkatan.harga).toLocaleString('id-ID') : '0'}</td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-right text-xs sm:text-sm font-medium">
                            <button onclick="editItem('paket', ${paket.id_Paket})" class="text-indigo-600 hover:text-indigo-900 mr-2 sm:mr-3">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteItem('paket', ${paket.id_Paket})" class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            }, 0);
        }

        function renderDiskonTable() {
            const tbody = document.getElementById('diskonTableBody');
            
            tbody.innerHTML = '<tr><td colspan="6" class="px-3 sm:px-6 py-4 text-center text-gray-500"><i class="fas fa-spinner fa-spin mr-2"></i>Memuat data...</td></tr>';

            setTimeout(() => {
                if (diskonData.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="6" class="px-3 sm:px-6 py-4 text-center text-gray-500">Tidak ada data</td></tr>';
                    return;
                }

                tbody.innerHTML = '';
                diskonData.forEach(diskon => {
                    console.log('Rendering diskon:', diskon.id_diskon, diskon);
                    
                    const now = new Date();
                    const berlakuDari = new Date(diskon.Berlaku_dari);
                    const berlakuSampai = new Date(diskon.Berlaku_sampai);
                    const isActive = now >= berlakuDari && now <= berlakuSampai;

                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm font-mono text-gray-900">${diskon.id_diskon}</td>
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
                            <button onclick="editItem('diskon', '${diskon.id_diskon}')" class="text-indigo-600 hover:text-indigo-900 mr-2 sm:mr-3">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteItem('diskon', '${diskon.id_diskon}')" class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            }, 0);
        }

        function renderTingkatanTable() {
            const tbody = document.getElementById('tingkatanTableBody');
            
            tbody.innerHTML = '<tr><td colspan="5" class="px-3 sm:px-6 py-4 text-center text-gray-500"><i class="fas fa-spinner fa-spin mr-2"></i>Memuat data...</td></tr>';

            setTimeout(() => {
                if (tingkatanData.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="px-3 sm:px-6 py-4 text-center text-gray-500">Tidak ada data</td></tr>';
                    return;
                }

                tbody.innerHTML = '';
                tingkatanData.forEach(tingkatan => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900">${tingkatan.id_Tingkatan}</td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">${tingkatan.Tingkatan}</td>
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
            }, 0);
        }

        function switchTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            document.querySelectorAll('.tab-button').forEach(tab => {
                tab.classList.remove('border-blue-500', 'text-blue-600');
                tab.classList.add('border-transparent', 'text-gray-500');
            });

            document.getElementById(`content-${tabName}`).classList.remove('hidden');

            const activeTab = document.getElementById(`tab-${tabName}`);
            activeTab.classList.remove('border-transparent', 'text-gray-500');
            activeTab.classList.add('border-blue-500', 'text-blue-600');
        }

        function openModal(type, mode, id = null) {
            currentEditType = type;
            currentEditId = id;

            const modal = document.getElementById(`modal${type.charAt(0).toUpperCase() + type.slice(1)}`);
            const title = document.getElementById(`modal${type.charAt(0).toUpperCase() + type.slice(1)}Title`);
            const form = document.getElementById(`form${type.charAt(0).toUpperCase() + type.slice(1)}`);

            if (mode === 'add') {
                title.textContent = `Tambah ${type.charAt(0).toUpperCase() + type.slice(1)}`;
                form.reset();
                if (type === 'diskon') {
                    const now = new Date();
                    const tomorrow = new Date(now.getTime() + 24 * 60 * 60 * 1000);
                    document.getElementById('Berlaku_dari').value = now.toISOString().slice(0, 16);
                    document.getElementById('Berlaku_sampai').value = tomorrow.toISOString().slice(0, 16);
                    document.getElementById('id_diskon').disabled = false;
                }
            } else {
                title.textContent = `Edit ${type.charAt(0).toUpperCase() + type.slice(1)}`;
                populateForm(type, id);
            }

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(type) {
            const modal = document.getElementById(`modal${type.charAt(0).toUpperCase() + type.slice(1)}`);
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            currentEditId = null;
            currentEditType = null;
        }

        function populateForm(type, id) {
            if (type === 'paket') {
                const data = paketData.find(item => item.id_Paket === id);
                if (data) {
                    document.getElementById('kategori_paket').value = data.kategori_paket;
                    document.getElementById('id_Tingkatan').value = data.id_Tingkatan;
                }
            } else if (type === 'diskon') {
                const data = diskonData.find(item => item.id_diskon === id);
                if (data) {
                    document.getElementById('id_diskon').value = data.id_diskon;
                    document.getElementById('id_diskon').disabled = true;
                    document.getElementById('nama').value = data.nama;
                    document.getElementById('persen').value = data.persen;
                    document.getElementById('Berlaku_dari').value = new Date(data.Berlaku_dari).toISOString().slice(0, 16);
                    document.getElementById('Berlaku_sampai').value = new Date(data.Berlaku_sampai).toISOString().slice(0, 16);
                    document.getElementById('dibuat_oleh').value = data.dibuat_oleh;
                }
            } else if (type === 'tingkatan') {
                const data = tingkatanData.find(item => item.id_Tingkatan === id);
                if (data) {
                    document.getElementById('Tingkatan').value = data.Tingkatan;
                    document.getElementById('deskripsi').value = data.deskripsi;
                    document.getElementById('harga').value = data.harga;
                }
            }
        }

        function populateTingkatanSelect() {
            const select = document.getElementById('id_Tingkatan');
            select.innerHTML = '<option value="">Pilih Tingkatan</option>';
            
            tingkatanData.forEach(tingkatan => {
                const option = document.createElement('option');
                option.value = tingkatan.id_Tingkatan;
                option.textContent = `${tingkatan.Tingkatan} - Rp ${parseFloat(tingkatan.harga).toLocaleString('id-ID')}`;
                select.appendChild(option);
            });
        }

        async function submitForm(event, type) {
            event.preventDefault();
            
            const data = {};

            if (type === 'paket') {
                data.kategori_paket = document.getElementById('kategori_paket').value;
                data.id_Tingkatan = document.getElementById('id_Tingkatan').value;
            } else if (type === 'diskon') {
                data.id_diskon = document.getElementById('id_diskon').value;
                data.nama = document.getElementById('nama').value;
                data.persen = document.getElementById('persen').value;
                data.Berlaku_dari = document.getElementById('Berlaku_dari').value;
                data.Berlaku_sampai = document.getElementById('Berlaku_sampai').value;
                data.dibuat_oleh = document.getElementById('dibuat_oleh').value;
            } else if (type === 'tingkatan') {
                data.Tingkatan = document.getElementById('Tingkatan').value;
                data.deskripsi = document.getElementById('deskripsi').value;
                data.harga = document.getElementById('harga').value;
            }
            
            if (currentEditId) {
                await updateItem(type, currentEditId, data);
            } else {
                await createItem(type, data);
            }
        }

        async function createItem(type, data) {
            showLoading();
            try {
                let endpoint = '';
                if (type === 'paket') endpoint = '/admin/pakets';
                else if (type === 'diskon') endpoint = '/admin/diskons';
                else if (type === 'tingkatan') endpoint = '/admin/tingkatans';

                await apiCall(endpoint, 'POST', data);
                
                await loadAllData();
                closeModal(type);
                showToast(`${type.charAt(0).toUpperCase() + type.slice(1)} berhasil ditambahkan!`);
            } catch (error) {
                console.error('Error creating item:', error);
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
                else if (type === 'diskon') endpoint = `/admin/diskons/${id}`;
                else if (type === 'tingkatan') endpoint = `/admin/tingkatans/${id}`;

                await apiCall(endpoint, 'PUT', data);
                
                await loadAllData();
                closeModal(type);
                showToast(`${type.charAt(0).toUpperCase() + type.slice(1)} berhasil diperbarui!`);
            } catch (error) {
                console.error('Error updating item:', error);
                showToast(error.message || 'Error saat memperbarui data', 'error');
            } finally {
                hideLoading();
            }
        }

        function editItem(type, id) {
            openModal(type, 'edit', id);
        }

        async function deleteItem(type, id) {
            console.log('Delete called:', type, id);
            
            if (!id || id === 'undefined') {
                showToast('ID tidak valid', 'error');
                console.error('Invalid ID:', id);
                return;
            }

            if (!confirm(`Apakah Anda yakin ingin menghapus ${type} ini?`)) {
                return;
            }

            showLoading();
            try {
                let endpoint = '';
                if (type === 'paket') endpoint = `/admin/pakets/${id}`;
                else if (type === 'diskon') endpoint = `/admin/diskons/${id}`;
                else if (type === 'tingkatan') endpoint = `/admin/tingkatans/${id}`;

                console.log('DELETE endpoint:', endpoint);
                await apiCall(endpoint, 'DELETE');
                
                await loadAllData();
                showToast(`${type.charAt(0).toUpperCase() + type.slice(1)} berhasil dihapus!`);
            } catch (error) {
                console.error('Error deleting item:', error);
                showToast(error.message || 'Error saat menghapus data', 'error');
            } finally {
                hideLoading();
            }
        }

        function updateStats() {
            document.getElementById('totalPaket').textContent = paketData.length;
            document.getElementById('totalDiskon').textContent = diskonData.length;
            document.getElementById('totalTingkatan').textContent = tingkatanData.length;
            
            const now = new Date();
            const activeDiscounts = diskonData.filter(d => {
                const start = new Date(d.Berlaku_dari);
                const end = new Date(d.Berlaku_sampai);
                return now >= start && now <= end;
            }).length;
            
            document.getElementById('diskonAktif').textContent = activeDiscounts;
        }

        function filterTable(type, searchTerm) {
            const tableBody = document.getElementById(`${type}TableBody`);
            const rows = tableBody.getElementsByTagName('tr');
            
            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const text = row.textContent.toLowerCase();
                
                if (text.includes(searchTerm.toLowerCase())) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        }

        function showLoading() {
            document.getElementById('loading').classList.remove('hidden');
        }

        function hideLoading() {
            document.getElementById('loading').classList.add('hidden');
        }

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            
            toastMessage.textContent = message;
            
            if (type === 'error') {
                toast.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 sm:px-6 py-3 sm:py-4 rounded-lg shadow-lg z-50 max-w-sm';
            } else {
                toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 sm:px-6 py-3 sm:py-4 rounded-lg shadow-lg z-50 max-w-sm';
            }
            
            toast.classList.remove('hidden');
            
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }
    </script>
</body>
@endsection