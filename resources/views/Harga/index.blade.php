<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Car Wash Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-car text-white"></i>
                    </div>
                    <h1 class="text-xl font-bold text-gray-900">Car Wash Management</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">Admin Dashboard</span>
                    <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 mr-4">
                        <i class="fas fa-box text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Paket</p>
                        <p class="text-2xl font-semibold text-gray-900" id="totalPaket">0</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 mr-4">
                        <i class="fas fa-percent text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Diskon</p>
                        <p class="text-2xl font-semibold text-gray-900" id="totalDiskon">0</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 mr-4">
                        <i class="fas fa-tags text-purple-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Diskon Aktif</p>
                        <p class="text-2xl font-semibold text-gray-900" id="diskonAktif">0</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-orange-100 mr-4">
                        <i class="fas fa-layer-group text-orange-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tingkatan</p>
                        <p class="text-2xl font-semibold text-gray-900" id="totalTingkatan">0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 px-6" aria-label="Tabs">
                    <button onclick="switchTab('paket')" id="tab-paket" class="tab-button py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap border-blue-500 text-blue-600">
                        <i class="fas fa-box mr-2"></i>Paket
                    </button>
                    <button onclick="switchTab('diskon')" id="tab-diskon" class="tab-button py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        <i class="fas fa-percent mr-2"></i>Diskon
                    </button>
                    <button onclick="switchTab('tingkatan')" id="tab-tingkatan" class="tab-button py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        <i class="fas fa-layer-group mr-2"></i>Tingkatan
                    </button>
                </nav>
            </div>

            <!-- Paket Content -->
            <div id="content-paket" class="tab-content">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <h2 class="text-lg font-medium text-gray-900">Manajemen Paket</h2>
                        <div class="flex space-x-3">
                            <input type="text" id="searchPaket" placeholder="Cari paket..." class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            <button onclick="openModal('paket', 'add')" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">
                                <i class="fas fa-plus mr-2"></i>Tambah
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori Paket</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tingkatan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="paketTableBody" class="bg-white divide-y divide-gray-200">
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Diskon Content -->
            <div id="content-diskon" class="tab-content hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <h2 class="text-lg font-medium text-gray-900">Manajemen Diskon</h2>
                        <div class="flex space-x-3">
                            <input type="text" id="searchDiskon" placeholder="Cari diskon..." class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500">
                            <button onclick="openModal('diskon', 'add')" class="bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-green-700">
                                <i class="fas fa-plus mr-2"></i>Tambah
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Persentase</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="diskonTableBody" class="bg-white divide-y divide-gray-200">
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tingkatan Content -->
            <div id="content-tingkatan" class="tab-content hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <h2 class="text-lg font-medium text-gray-900">Manajemen Tingkatan</h2>
                        <button onclick="openModal('tingkatan', 'add')" class="bg-purple-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-purple-700">
                            <i class="fas fa-plus mr-2"></i>Tambah
                        </button>
                    </div>
                </div>
                
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tingkatan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deskripsi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
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
    <div id="modalPaket" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900" id="modalPaketTitle">Tambah Paket</h3>
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
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeModal('paket')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Batal
                        </button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Diskon -->
    <div id="modalDiskon" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900" id="modalDiskonTitle">Tambah Diskon</h3>
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
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeModal('diskon')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Batal
                        </button>
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tingkatan -->
    <div id="modalTingkatan" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900" id="modalTingkatanTitle">Tambah Tingkatan</h3>
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
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeModal('tingkatan')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Batal
                        </button>
                        <button type="submit" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Loading -->
    <div id="loading" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-4 rounded-lg">
            <div class="flex items-center">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-500 mr-3"></div>
                <span>Loading...</span>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div id="toast" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg hidden z-50">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span id="toastMessage">Success!</span>
        </div>
    </div>

    <script>
        let currentEditId = null;
        let currentEditType = null;
        let paketData = [];
        let diskonData = [];
        let tingkatanData = [];

        const BASE_URL = window.location.origin;
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        document.addEventListener('DOMContentLoaded', function() {
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
            const options = {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            };
            
            if (data && method !== 'GET') {
                options.body = JSON.stringify(data);
            }
            
            const response = await fetch(`${BASE_URL}${endpoint}`, options);
            
            if (!response.ok) {
                const error = await response.json();
                throw error;
            }
            
            return await response.json();
        }

        async function loadAllData() {
            showLoading();
            try {
                await Promise.all([
                    loadTingkatanData(),
                    loadPaketData(),
                    loadDiskonData()
                ]);
                updateStats();
            } catch (error) {
                console.error('Error loading data:', error);
                showToast('Error loading data: ' + error.message, 'error');
            } finally {
                hideLoading();
            }
        }

        async function loadTingkatanData() {
            try {
                const response = await apiCall('/api/tingkatans');
                tingkatanData = response;
                renderTingkatanTable();
                populateTingkatanSelect();
            } catch (error) {
                console.error('Error loading tingkatan:', error);
                showToast('Error loading tingkatan', 'error');
            }
        }

        async function loadPaketData() {
            try {
                const response = await apiCall('/api/pakets');
                paketData = response;
                renderPaketTable();
            } catch (error) {
                console.error('Error loading paket:', error);
                showToast('Error loading paket', 'error');
            }
        }

        async function loadDiskonData() {
            try {
                const response = await apiCall('/api/diskons');
                diskonData = response;
                renderDiskonTable();
            } catch (error) {
                console.error('Error loading diskon:', error);
                showToast('Error loading diskon', 'error');
            }
        }

        function renderPaketTable() {
            const tbody = document.getElementById('paketTableBody');
            tbody.innerHTML = '';

            if (paketData.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data</td></tr>';
                return;
            }

            paketData.forEach(paket => {
                const tingkatan = paket.tingkatan || {};
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${paket.id_Paket}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${paket.kategori_paket}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${tingkatan.Tingkatan || '-'}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp ${tingkatan.harga ? parseFloat(tingkatan.harga).toLocaleString('id-ID') : '0'}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button onclick="editItem('paket', ${paket.id_Paket})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="deleteItem('paket', ${paket.id_Paket})" class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }

        function renderDiskonTable() {
            const tbody = document.getElementById('diskonTableBody');
            tbody.innerHTML = '';

            if (diskonData.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data</td></tr>';
                return;
            }

            diskonData.forEach(diskon => {
                const now = new Date();
                const berlakuDari = new Date(diskon.Berlaku_dari);
                const berlakuSampai = new Date(diskon.Berlaku_sampai);
                const isActive = now >= berlakuDari && now <= berlakuSampai;

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">${diskon.id_diskon}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${diskon.nama}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            ${diskon.persen}%
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div>${berlakuDari.toLocaleDateString('id-ID')}</div>
                        <div class="text-gray-500">s/d ${berlakuSampai.toLocaleDateString('id-ID')}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full ${isActive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                            ${isActive ? 'Aktif' : 'Tidak Aktif'}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button onclick="editItem('diskon', '${diskon.id_diskon}')" class="text-indigo-600 hover:text-indigo-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="deleteItem('diskon', '${diskon.id_diskon}')" class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }

        function renderTingkatanTable() {
            const tbody = document.getElementById('tingkatanTableBody');
            tbody.innerHTML = '';

            if (tingkatanData.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data</td></tr>';
                return;
            }

            tingkatanData.forEach(tingkatan => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${tingkatan.id_Tingkatan}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${tingkatan.Tingkatan}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">${tingkatan.deskripsi}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp ${parseFloat(tingkatan.harga).toLocaleString('id-ID')}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button onclick="editItem('tingkatan', ${tingkatan.id_Tingkatan})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="deleteItem('tingkatan', ${tingkatan.id_Tingkatan})" class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            });
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
                }
                if (type === 'diskon') {
                    document.getElementById('id_diskon').disabled = false;
                }
            } else {
                title.textContent = `Edit ${type.charAt(0).toUpperCase() + type.slice(1)}`;
                populateForm(type, id);
            }

            modal.classList.remove('hidden');
        }

        function closeModal(type) {
            const modal = document.getElementById(`modal${type.charAt(0).toUpperCase() + type.slice(1)}`);
            modal.classList.add('hidden');
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
            
            const formData = new FormData(event.target);
            const data = {};
            
            formData.forEach((value, key) => {
                data[key] = value;
            });

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
            if (!confirm(`Apakah Anda yakin ingin menghapus ${type} ini?`)) {
                return;
            }

            showLoading();
            try {
                let endpoint = '';
                if (type === 'paket') endpoint = `/admin/pakets/${id}`;
                else if (type === 'diskon') endpoint = `/admin/diskons/${id}`;
                else if (type === 'tingkatan') endpoint = `/admin/tingkatans/${id}`;

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
                toast.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg z-50';
            } else {
                toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50';
            }
            
            toast.classList.remove('hidden');
            
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }
    </script>
</body>
</html>