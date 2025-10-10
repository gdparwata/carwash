<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuciCar - Data Pegawai</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div id="app">
        <div class="min-h-screen bg-gray-100">
            <!-- Header -->
            <div class="bg-white shadow-sm border-b">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center py-4">
                        <div class="flex items-center space-x-4">
                            <div class="text-2xl font-bold text-teal-600">cucicar</div>
                        </div>
                        <!-- Breadcrumb -->
                        <nav class="flex" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                <li>
                                    <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Dashboard Admin</a>
                                </li>
                                <li aria-current="page">
                                    <div class="flex items-center">
                                        <span class="text-gray-400 mx-2">/</span>
                                        <span class="text-gray-900 font-medium">Data Pegawai</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-8">Data Pegawai</h1>
                
                <!-- Tabs -->
                <div class="bg-white rounded-lg shadow-sm mb-6">
                    <div class="flex border-b">
                        <button onclick="showTab('employees')" id="tab-employees" class="px-6 py-4 text-sm font-medium bg-teal-500 text-white">
                            Data Pegawai
                        </button>
                        <button onclick="showTab('admins')" id="tab-admins" class="px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                            Data Admin
                        </button>
                        <button onclick="showTab('libur')" id="tab-libur" class="px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                            Data Libur
                        </button>
                        <button onclick="showTab('statistics')" id="tab-statistics" class="px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                            Statistik
                        </button>
                    </div>
                </div>

                <!-- Content Area -->
                <div id="content-area">
                    <!-- Employee Management -->
                    <div id="employees-content" class="bg-white rounded-lg shadow-sm">
                        <div class="flex justify-between items-center p-6 border-b">
                            <div class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm font-medium">
                                Total Pegawai: <span id="total-employees">{{ count($pegawais) }}</span>
                            </div>
                            <button onclick="openModal('add', 'employee')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                Tambah Pegawai
                            </button>
                        </div>
                        
                        <div class="p-6 space-y-4" id="employees-list">
                            @forelse($pegawais as $pegawai)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow" data-id="{{ $pegawai->id_Pegawai }}">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                                                <span class="text-gray-600 font-medium">{{ substr($pegawai->nama, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-gray-900">{{ $pegawai->nama }}</h3>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-teal-100 text-teal-800">
                                                    Karyawan
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <div class="text-right">
                                                <p class="text-sm text-gray-600">Cuti Hari: <span class="text-red-500">{{ $pegawai->hari_cuti }}</span></p>
                                                <p class="text-sm text-gray-600">Dihasilkan: <span class="font-semibold">RP. 3.500.000</span></p>
                                            </div>
                                            <div class="flex items-center space-x-8">
                                                <div class="text-center">
                                                    <div class="flex items-center space-x-2">
                                                        <svg class="w-8 h-8 text-teal-500" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                                                        </svg>
                                                        <span class="text-2xl font-bold text-gray-700">{{ $pegawai->jumlah_mobil }}</span>
                                                    </div>
                                                    <p class="text-xs text-gray-500 mt-1">Jumlah Mobil Dicuci</p>
                                                </div>
                                                <div class="flex space-x-2">
                                                    <button onclick="editEmployee({{ $pegawai->id_Pegawai }})" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                                        Edit
                                                    </button>
                                                    <button onclick="confirmDelete({{ $pegawai->id_Pegawai }}, 'employee')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-500">Email</span>
                                            <p class="font-medium">{{ $pegawai->email }}</p>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">No Telepon</span>
                                            <p class="font-medium">{{ $pegawai->nomor_telepon }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <p class="text-gray-500">Belum ada data pegawai</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Admin Management -->
                    <div id="admins-content" class="bg-white rounded-lg shadow-sm" style="display: none;">
                        <div class="flex justify-between items-center p-6 border-b">
                            <div class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm font-medium">
                                Total Admin: <span id="total-admins">{{ count($admins) }}</span>
                            </div>
                            <button onclick="openModal('add', 'admin')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                Tambah Admin
                            </button>
                        </div>
                        
                        <div class="p-6 space-y-4" id="admins-list">
                            @forelse($admins as $admin)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow" data-id="{{ $admin->id_User }}">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                                                <span class="text-gray-600 font-medium">{{ substr($admin->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-gray-900">{{ $admin->name }}</h3>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ ucfirst($admin->role) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <div class="text-right">
                                                <p class="text-sm text-gray-600">Dihasilkan: <span class="font-semibold">RP. 3.500.000</span></p>
                                            </div>
                                            <div class="flex items-center space-x-8">
                                                <div class="text-center">
                                                    <div class="flex items-center space-x-2">
                                                        <svg class="w-8 h-8 text-teal-500" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                                                        </svg>
                                                        <span class="text-2xl font-bold text-gray-700">{{ $admin->jumlah_mobil }}</span>
                                                    </div>
                                                    <p class="text-xs text-gray-500 mt-1">Jumlah Mobil Dicuci</p>
                                                </div>
                                                <div class="flex space-x-2">
                                                    <button onclick="editAdmin({{ $admin->id_User }})" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                                        Edit
                                                    </button>
                                                    <button onclick="confirmDelete({{ $admin->id_User }}, 'admin')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <span class="text-gray-500">Email</span>
                                        <p class="font-medium">{{ $admin->email }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <p class="text-gray-500">Belum ada data admin</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Libur Management -->
                    <div id="libur-content" class="bg-white rounded-lg shadow-sm" style="display: none;">
                        <div class="flex justify-between items-center p-6 border-b">
                            <div class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium">
                                Total Data Libur: <span id="total-libur">{{ count($liburs ?? []) }}</span>
                            </div>
                            <button onclick="openModal('add', 'libur')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                Tambah Data Libur
                            </button>
                        </div>
                        
                        <div class="p-6 space-y-4" id="libur-list">
                            @forelse($liburs ?? [] as $libur)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow" data-id="{{ $libur->id_libur }}">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 bg-orange-300 rounded-full flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-gray-900">
                                                    @if($libur->id_pegawai)
                                                        {{ $libur->pegawai->nama ?? 'Pegawai tidak ditemukan' }}
                                                    @else
                                                        {{ $libur->user->name ?? 'Admin tidak ditemukan' }}
                                                    @endif
                                                </h3>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    {{ $libur->id_pegawai ? 'bg-teal-100 text-teal-800' : 'bg-blue-100 text-blue-800' }}">
                                                    {{ $libur->id_pegawai ? 'Pegawai' : 'Admin' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <div class="text-right">
                                                <p class="text-sm text-gray-600">Tanggal: <span class="font-semibold">{{ $libur->hari }}</span></p>
                                                <p class="text-sm text-gray-600">Status: 
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                                        {{ strtotime($libur->hari) < time() ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                        {{ strtotime($libur->hari) < time() ? 'Selesai' : 'Akan Datang' }}
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="flex space-x-2">
                                                <button onclick="editLibur({{ $libur->id_libur }})" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                                    Edit
                                                </button>
                                                <button onclick="confirmDelete({{ $libur->id_libur }}, 'libur')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                                    Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <p class="text-gray-500">Belum ada data libur</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div id="statistics-content" style="display: none;">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div class="bg-blue-500 text-white rounded-lg p-6">
                                <div class="flex items-center">
                                    <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div>
                                        <p class="text-lg font-medium">Total Pegawai</p>
                                        <p class="text-3xl font-bold">{{ count($pegawais) }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-blue-500 text-white rounded-lg p-6">
                                <div class="flex items-center">
                                    <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div>
                                        <p class="text-lg font-medium">Total Admin</p>
                                        <p class="text-3xl font-bold">{{ count($admins) }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-orange-500 text-white rounded-lg p-6">
                                <div class="flex items-center">
                                    <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>
                                    <div>
                                        <p class="text-lg font-medium">Total Libur</p>
                                        <p class="text-3xl font-bold">{{ count($liburs ?? []) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Performance Section -->
                        <div class="bg-white rounded-lg shadow-sm">
                            <div class="p-6 border-b">
                                <h2 class="text-xl font-semibold text-gray-900">Performa Pegawai</h2>
                            </div>
                            <div class="p-6 space-y-4">
                                @foreach($pegawais as $pegawai)
                                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                                                <span class="text-gray-600 font-medium">{{ substr($pegawai->nama, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-gray-900">{{ $pegawai->nama }}</h3>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-teal-100 text-teal-800">
                                                    Karyawan
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <div class="text-right">
                                                <p class="font-semibold text-gray-900">{{ $pegawai->jumlah_mobil }} Mobil</p>
                                            </div>
                                            <div class="w-32 bg-gray-200 rounded-full h-2">
                                                <div class="bg-teal-500 h-2 rounded-full" style="width: {{ min(($pegawai->jumlah_mobil / 1000) * 100, 100) }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                @foreach($admins as $admin)
                                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                                                <span class="text-gray-600 font-medium">{{ substr($admin->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-gray-900">{{ $admin->name }}</h3>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Admin
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <div class="text-right">
                                                <p class="font-semibold text-gray-900">{{ $admin->jumlah_mobil }} Mobil</p>
                                            </div>
                                            <div class="w-32 bg-gray-200 rounded-full h-2">
                                                <div class="bg-teal-500 h-2 rounded-full" style="width: {{ min(($admin->jumlah_mobil / 1000) * 100, 100) }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div id="modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50" style="display: none;">
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                    <form id="modal-form">
                        <div class="px-6 py-4 border-b">
                            <h2 class="text-lg font-semibold text-gray-900" id="modal-title">
                                Tambah Pegawai
                            </h2>
                        </div>
                        
                        <div class="px-6 py-4 space-y-4" id="modal-fields">
                            <!-- Dynamic fields will be inserted here -->
                        </div>
                        
                        <div class="px-6 py-4 border-t flex space-x-3">
                            <button type="submit" class="flex-1 bg-teal-500 hover:bg-teal-600 text-white py-2 px-4 rounded-md font-medium">
                                Confirm
                            </button>
                            <button type="button" onclick="closeModal()" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-md font-medium">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Confirm Delete Modal -->
            <div id="confirm-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50" style="display: none;">
                <div class="bg-white rounded-lg shadow-xl max-w-sm w-full mx-4">
                    <div class="px-6 py-4">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Pemberitahuan</h2>
                        <p class="text-gray-600 mb-6">Yakin Ingin Menghapus Data Ini?</p>
                        <div class="flex space-x-3">
                            <button onclick="deleteItem()" class="flex-1 bg-teal-500 hover:bg-teal-600 text-white py-2 px-4 rounded-md font-medium">
                                Confirm
                            </button>
                            <button onclick="closeConfirmModal()" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-md font-medium">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Set up CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let currentView = 'employees';
        let modalType = 'add';
        let currentDataType = 'employee';
        let editingId = null;
        let deleteId = null;
        let deleteType = null;

        function showTab(tab) {
            currentView = tab;
            
            // Update tab styling
            $('.px-6.py-4').removeClass('bg-teal-500 text-white').addClass('text-gray-500 hover:text-gray-700');
            $('#tab-' + tab).removeClass('text-gray-500 hover:text-gray-700').addClass('bg-teal-500 text-white');
            
            // Show/hide content
            $('#employees-content, #admins-content, #libur-content, #statistics-content').hide();
            $('#' + tab + '-content').show();
        }

        function openModal(type, dataType) {
            modalType = type;
            currentDataType = dataType;
            editingId = null;
            
            let title = '';
            if (dataType === 'employee') {
                title = (type === 'add' ? 'Tambah ' : 'Edit ') + 'Pegawai';
            } else if (dataType === 'admin') {
                title = (type === 'add' ? 'Tambah ' : 'Edit ') + 'Admin';
            } else if (dataType === 'libur') {
                title = (type === 'add' ? 'Tambah ' : 'Edit ') + 'Data Libur';
            }
            
            $('#modal-title').text(title);
            generateModalFields(dataType, null);
            $('#modal').show();
        }

        function generateModalFields(dataType, data) {
            let fieldsHtml = '';
            
            if (dataType === 'employee') {
                fieldsHtml = `
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Pegawai</label>
                        <input type="file" name="foto" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Panjang Pegawai</label>
                        <input type="text" name="nama" value="${data?.nama || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Pribadi Pegawai</label>
                        <input type="email" name="email" value="${data?.email || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon Pegawai</label>
                        <input type="text" name="nomor_telepon" value="${data?.nomor_telepon || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                    </div>
                `;
            } else if (dataType === 'admin') {
                fieldsHtml = `
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Admin</label>
                        <input type="file" name="foto" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Panjang Admin</label>
                        <input type="text" name="name" value="${data?.name || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Login Admin</label>
                        <input type="email" name="email" value="${data?.email || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Login Admin</label>
                        <input type="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" ${modalType === 'add' ? 'required' : ''}>
                        ${modalType === 'edit' ? '<small class="text-gray-500">Kosongkan jika tidak ingin mengubah password</small>' : ''}
                    </div>
                `;
            } else if (dataType === 'libur') {
                fieldsHtml = `
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Karyawan/Admin</label>
                        <select name="person_type" id="person_type" onchange="updatePersonSelect()" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                            <option value="">Pilih Tipe</option>
                            <option value="pegawai" ${data?.id_pegawai ? 'selected' : ''}>Pegawai</option>
                            <option value="admin" ${data?.id_user ? 'selected' : ''}>Admin</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Nama</label>
                        <select name="person_id" id="person_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                            <option value="">Pilih nama terlebih dahulu</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hari Libur</label>
                        <select name="hari" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                            <option value="">Pilih Hari</option>
                            <option value="Senin" ${data?.hari === 'Senin' ? 'selected' : ''}>Senin</option>
                            <option value="Selasa" ${data?.hari === 'Selasa' ? 'selected' : ''}>Selasa</option>
                            <option value="Rabu" ${data?.hari === 'Rabu' ? 'selected' : ''}>Rabu</option>
                            <option value="Kamis" ${data?.hari === 'Kamis' ? 'selected' : ''}>Kamis</option>
                            <option value="Jumat" ${data?.hari === 'Jumat' ? 'selected' : ''}>Jumat</option>
                            <option value="Sabtu" ${data?.hari === 'Sabtu' ? 'selected' : ''}>Sabtu</option>
                            <option value="Minggu" ${data?.hari === 'Minggu' ? 'selected' : ''}>Minggu</option>
                        </select>
                    </div>
                `;
            }
            
            $('#modal-fields').html(fieldsHtml);
            
            // Initialize person select if editing libur
            if (dataType === 'libur' && data) {
                updatePersonSelect();
                setTimeout(() => {
                    $('#person_id').val(data.id_pegawai || data.id_user);
                }, 100);
            }
        }

        function updatePersonSelect() {
            const personType = $('#person_type').val();
            const personSelect = $('#person_id');
            
            personSelect.empty();
            personSelect.append('<option value="">Loading...</option>');
            
            if (personType === 'pegawai') {
                // Load employees dari server menggunakan API route yang benar
                $.get('/api/pegawais-dropdown')
                    .done(function(response) {
                        personSelect.empty();
                        personSelect.append('<option value="">Pilih Pegawai</option>');
                        if (response.data && response.data.length > 0) {
                            response.data.forEach(emp => {
                                personSelect.append(`<option value="${emp.id_Pegawai}">${emp.nama}</option>`);
                            });
                        }
                    })
                    .fail(function() {
                        personSelect.empty();
                        personSelect.append('<option value="">Error loading data</option>');
                    });
            } else if (personType === 'admin') {
                // Load admins dari server menggunakan API route yang benar
                $.get('/api/admins-dropdown')
                    .done(function(response) {
                        personSelect.empty();
                        personSelect.append('<option value="">Pilih Admin</option>');
                        if (response.data && response.data.length > 0) {
                            response.data.forEach(admin => {
                                personSelect.append(`<option value="${admin.id_User}">${admin.name}</option>`);
                            });
                        }
                    })
                    .fail(function() {
                        personSelect.empty();
                        personSelect.append('<option value="">Error loading data</option>');
                    });
            } else {
                personSelect.empty();
                personSelect.append('<option value="">Pilih tipe terlebih dahulu</option>');
            }
        }

        function closeModal() {
            $('#modal').hide();
            editingId = null;
        }

        function editEmployee(id) {
            $.get(`{{ url('admin/pegawais') }}/${id}/edit`)
                .done(function(response) {
                    modalType = 'edit';
                    currentDataType = 'employee';
                    editingId = id;
                    
                    $('#modal-title').text('Edit Pegawai');
                    generateModalFields('employee', response.data);
                    $('#modal').show();
                })
                .fail(function() {
                    alert('Error loading employee data');
                });
        }

        function editAdmin(id) {
            $.get(`{{ url('admin/admins') }}/${id}/edit`)
                .done(function(response) {
                    modalType = 'edit';
                    currentDataType = 'admin';
                    editingId = id;
                    
                    $('#modal-title').text('Edit Admin');
                    generateModalFields('admin', response.data);
                    $('#modal').show();
                })
                .fail(function() {
                    alert('Error loading admin data');
                });
        }

        function editLibur(id) {
            $.get(`{{ url('admin/liburs') }}/${id}/edit`)
                .done(function(response) {
                    modalType = 'edit';
                    currentDataType = 'libur';
                    editingId = id;
                    
                    $('#modal-title').text('Edit Data Libur');
                    generateModalFields('libur', response.data);
                    $('#modal').show();
                })
                .fail(function() {
                    alert('Error loading libur data');
                });
        }

        function confirmDelete(id, type) {
            deleteId = id;
            deleteType = type;
            $('#confirm-modal').show();
        }

        function closeConfirmModal() {
            $('#confirm-modal').hide();
            deleteId = null;
            deleteType = null;
        }

        function deleteItem() {
            if (!deleteId || !deleteType) return;
            
            let url;
            if (deleteType === 'employee') {
                url = `{{ url('admin/pegawais') }}/${deleteId}`;
            } else if (deleteType === 'admin') {
                url = `{{ url('admin/admins') }}/${deleteId}`;
            } else if (deleteType === 'libur') {
                url = `{{ url('admin/liburs') }}/${deleteId}`;
            }
            
            $.ajax({
                url: url,
                type: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('Error deleting item');
                    }
                },
                error: function() {
                    alert('Error deleting item');
                }
            });
            
            closeConfirmModal();
        }

        // Handle form submission
        $('#modal-form').on('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            let url, method;
            
            if (currentDataType === 'employee') {
                if (modalType === 'add') {
                    url = '/admin/pegawais';
                    method = 'POST';
                } else {
                    url = `/admin/pegawais/${editingId}`;
                    method = 'PUT';
                    formData.append('_method', 'PUT');
                }
            } else if (currentDataType === 'admin') {
                if (modalType === 'add') {
                    url = '/admin/admins';
                    method = 'POST';
                } else {
                    url = `/admin/admins/${editingId}`;
                    method = 'PUT';
                    formData.append('_method', 'PUT');
                }
            } else if (currentDataType === 'libur') {
                // Handle libur form submission dengan debugging
                const personType = formData.get('person_type');
                const personId = formData.get('person_id');
                const hari = formData.get('hari');
                
                console.log('Form Data Debug:', {
                    personType: personType,
                    personId: personId,
                    hari: hari
                });
                
                // Validasi client-side
                if (!personType || !personId || !hari) {
                    alert('Semua field harus diisi');
                    return;
                }
                
                // Clear existing pegawai/user fields
                formData.delete('id_pegawai');
                formData.delete('id_user');
                
                if (personType === 'pegawai') {
                    formData.append('id_pegawai', personId);
                } else if (personType === 'admin') {
                    formData.append('id_user', personId);
                }
                
                // Remove temporary fields
                formData.delete('person_type');
                formData.delete('person_id');
                
                if (modalType === 'add') {
                    url = '/admin/liburs';
                    method = 'POST';
                } else {
                    url = `/admin/liburs/${editingId}`;
                    method = 'PUT';
                    formData.append('_method', 'PUT');
                }
                
                console.log('Final URL:', url);
                console.log('Final FormData entries:');
                for (let pair of formData.entries()) {
                    console.log(pair[0] + ': ' + pair[1]);
                }
            }
            
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('Success Response:', response);
                    if (response.success) {
                        closeModal();
                        location.reload();
                    } else {
                        alert('Error saving data: ' + (response.message || 'Unknown error'));
                    }
                },
                error: function(xhr) {
                    console.log('Error Response:', xhr);
                    console.log('Status:', xhr.status);
                    console.log('Response Text:', xhr.responseText);
                    
                    if (xhr.status === 422) {
                        const response = xhr.responseJSON;
                        if (response && response.errors) {
                            let errorMessage = 'Validation errors:\n';
                            for (const field in response.errors) {
                                errorMessage += `- ${response.errors[field].join(', ')}\n`;
                            }
                            alert(errorMessage);
                        } else if (response && response.message) {
                            alert('Error: ' + response.message);
                        }
                    } else if (xhr.status === 500) {
                        alert('Server error. Check console and Laravel logs.');
                    } else if (xhr.status === 404) {
                        alert('Route not found: ' + url);
                    } else {
                        alert('Error saving data. Status: ' + xhr.status);
                    }
                }
            });
        });
    </script>
</body>
</html>