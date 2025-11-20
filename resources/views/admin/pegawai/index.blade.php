@extends('layouts.admin')

@section('title', 'Data Pegawai')

@section('content')
    <div class="p-4 md:p-8">
        <!-- Page Title -->
        <h1 class="text-2xl md:text-4xl font-bold text-gray-700 mb-4 md:mb-8">Data Pegawai</h1>
        
        <!-- Tabs -->
        <div class="bg-white rounded-2xl shadow-sm mb-6 overflow-hidden">
            <div class="flex flex-col sm:flex-row">
                <button onclick="showTab('employees')" id="tab-employees" class="flex-1 px-4 md:px-8 py-4 md:py-5 text-sm md:text-base font-semibold bg-teal-400 text-white transition-colors">
                    Data Pegawai
                </button>
                <button onclick="showTab('admins')" id="tab-admins" class="flex-1 px-4 md:px-8 py-4 md:py-5 text-sm md:text-base font-semibold text-gray-500 hover:bg-gray-50 transition-colors">
                    Data Admin
                </button>
                <button onclick="showTab('statistics')" id="tab-statistics" class="flex-1 px-4 md:px-8 py-4 md:py-5 text-sm md:text-base font-semibold text-gray-500 hover:bg-gray-50 transition-colors">
                    Statistik
                </button>
                <button onclick="showTab('libur')" id="tab-libur" class="flex-1 px-4 md:px-8 py-4 md:py-5 text-sm md:text-base font-semibold text-gray-500 hover:bg-gray-50 transition-colors">
                    Daftar Cuti
                </button>
            </div>
        </div>

        <!-- Content Area -->
        <div id="content-area">
            <!-- Employee Management -->
            <div id="employees-content">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <div class="bg-teal-400 text-white px-4 md:px-6 py-2 md:py-3 rounded-full text-sm md:text-base font-semibold shadow-md">
                        Total Pegawai: {{ count($pegawais) }}
                    </div>
                    <button onclick="openModal('add', 'employee')" class="w-full sm:w-auto bg-blue-500 hover:bg-blue-600 text-white px-6 md:px-8 py-2 md:py-3 rounded-xl text-sm md:text-base font-semibold shadow-md transition-colors">
                        Tambah Pegawai
                    </button>
                </div>
                
                <div class="space-y-4 md:space-y-5" id="employees-list">
                    @forelse($pegawais as $pegawai)
                        <div class="bg-white rounded-2xl shadow-md p-4 md:p-6 hover:shadow-lg transition-shadow" data-id="{{ $pegawai->id_Pegawai }}">
                            <div class="flex flex-col lg:flex-row items-start lg:items-center gap-4">
                                <!-- Avatar & Basic Info -->
                                <div class="flex items-center space-x-4 w-full lg:w-auto">
                                    <div class="w-12 h-12 md:w-16 md:h-16 bg-gray-400 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-white font-bold text-lg md:text-xl">{{ substr($pegawai->nama, 0, 1) }}</span>
                                    </div>
                                    <div class="flex-1 lg:hidden">
                                        <h3 class="font-bold text-gray-800 text-base md:text-lg mb-1">{{ $pegawai->nama }}</h3>
                                        <span class="inline-block bg-teal-400 text-white px-3 py-1 rounded-full text-xs font-medium">
                                            Karyawan
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Info Grid -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8 flex-1 w-full">
                                    <!-- Column 1: Name & Badge (Desktop) -->
                                    <div class="hidden lg:block">
                                        <h3 class="font-bold text-gray-800 text-lg mb-2">{{ $pegawai->nama }}</h3>
                                        <span class="inline-block bg-teal-400 text-white px-4 py-1 rounded-full text-sm font-medium">
                                            Karyawan
                                        </span>
                                    </div>
                                    
                                    <!-- Column 2: Contact Info -->
                                    <div class="space-y-2 md:space-y-3">
                                        <div>
                                            <p class="text-gray-500 text-xs md:text-sm font-medium mb-1">Email</p>
                                            <p class="text-gray-700 font-medium text-sm md:text-base break-all">{{ $pegawai->email }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-xs md:text-sm font-medium mb-1">Hari Cuti</p>
                                            <p class="text-red-500 font-bold text-sm md:text-base">{{ $pegawai->hari_cuti ?? 'Minggu' }}</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Column 3: Stats -->
                                    <div class="space-y-2 md:space-y-3">
                                        <div>
                                            <p class="text-gray-500 text-xs md:text-sm font-medium mb-1">No Telepon</p>
                                            <p class="text-gray-700 font-medium text-sm md:text-base">{{ $pegawai->nomor_telepon }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-xs md:text-sm font-medium mb-1">Dihasilkan</p>
                                            <p class="text-gray-700 font-bold text-sm md:text-base">RP. 3.500.000</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Car Count Section -->
                                <div class="flex items-center justify-between sm:justify-center w-full lg:w-auto lg:flex-col lg:px-6 lg:border-l-2 lg:border-r-2 border-gray-200 py-4 lg:py-0">
                                    <p class="text-gray-500 text-xs md:text-sm font-medium lg:mb-2">Jumlah Mobil Dicuci</p>
                                    <div class="flex items-center space-x-2 md:space-x-3">
                                        <svg class="w-8 h-8 md:w-12 md:h-12 text-teal-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                        </svg>
                                        <span class="text-3xl md:text-5xl font-bold text-gray-700">{{ $pegawai->jumlah_mobil }}</span>
                                    </div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex flex-row lg:flex-col space-x-3 lg:space-x-0 lg:space-y-3 w-full lg:w-auto">
                                    <button onclick="editEmployee({{ $pegawai->id_Pegawai }})" class="flex-1 lg:flex-none bg-blue-500 hover:bg-blue-600 text-white px-6 md:px-8 py-2 rounded-lg text-sm md:text-base font-semibold transition-colors shadow-md lg:min-w-[120px]">
                                        Edit
                                    </button>
                                    <button onclick="confirmDelete({{ $pegawai->id_Pegawai }}, 'employee')" class="flex-1 lg:flex-none bg-red-400 hover:bg-red-500 text-white px-6 md:px-8 py-2 rounded-lg text-sm md:text-base font-semibold transition-colors shadow-md lg:min-w-[120px]">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-2xl shadow-md p-8 md:p-12 text-center">
                            <p class="text-gray-400 text-base md:text-lg">Belum ada data pegawai</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Admin Management -->
            <div id="admins-content" style="display: none;">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <div class="bg-teal-400 text-white px-4 md:px-6 py-2 md:py-3 rounded-full text-sm md:text-base font-semibold shadow-md">
                        Total Admin: {{ count($admins) }}
                    </div>
                    <button onclick="openModal('add', 'admin')" class="w-full sm:w-auto bg-blue-500 hover:bg-blue-600 text-white px-6 md:px-8 py-2 md:py-3 rounded-xl text-sm md:text-base font-semibold shadow-md transition-colors">
                        Tambah Admin
                    </button>
                </div>
                
                <div class="space-y-4 md:space-y-5" id="admins-list">
                    @forelse($admins as $admin)
                        <div class="bg-white rounded-2xl shadow-md p-4 md:p-6 hover:shadow-lg transition-shadow" data-id="{{ $admin->id_User }}">
                            <div class="flex flex-col lg:flex-row items-start lg:items-center gap-4">
                                <div class="flex items-center space-x-4 w-full lg:w-auto">
                                    <div class="w-12 h-12 md:w-16 md:h-16 bg-gray-400 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-white font-bold text-lg md:text-xl">{{ substr($admin->name, 0, 1) }}</span>
                                    </div>
                                    <div class="flex-1 lg:hidden">
                                        <h3 class="font-bold text-gray-800 text-base md:text-lg mb-1">{{ $admin->name }}</h3>
                                        <span class="inline-block bg-teal-400 text-white px-3 py-1 rounded-full text-xs font-medium">
                                            {{ ucfirst($admin->role) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8 flex-1 w-full">
                                    <div class="hidden lg:block">
                                        <h3 class="font-bold text-gray-800 text-lg mb-2">{{ $admin->name }}</h3>
                                        <span class="inline-block bg-teal-400 text-white px-4 py-1 rounded-full text-sm font-medium">
                                            {{ ucfirst($admin->role) }}
                                        </span>
                                    </div>
                                    
                                    <div class="space-y-2 md:space-y-3">
                                        <div>
                                            <p class="text-gray-500 text-xs md:text-sm font-medium mb-1">Email</p>
                                            <p class="text-gray-700 font-medium text-sm md:text-base break-all">{{ $admin->email }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-2 md:space-y-3">
                                        <div>
                                            <p class="text-gray-500 text-xs md:text-sm font-medium mb-1">Dihasilkan</p>
                                            <p class="text-gray-700 font-bold text-sm md:text-base">RP. 3.500.000</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between sm:justify-center w-full lg:w-auto lg:flex-col lg:px-6 lg:border-l-2 lg:border-r-2 border-gray-200 py-4 lg:py-0">
                                    <p class="text-gray-500 text-xs md:text-sm font-medium lg:mb-2">Jumlah Mobil Dicuci</p>
                                    <div class="flex items-center space-x-2 md:space-x-3">
                                        <svg class="w-8 h-8 md:w-12 md:h-12 text-teal-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                        </svg>
                                        <span class="text-3xl md:text-5xl font-bold text-gray-700">{{ $admin->jumlah_mobil }}</span>
                                    </div>
                                </div>
                                
                                <div class="flex flex-row lg:flex-col space-x-3 lg:space-x-0 lg:space-y-3 w-full lg:w-auto">
                                    <button onclick="editAdmin({{ $admin->id_User }})" class="flex-1 lg:flex-none bg-blue-500 hover:bg-blue-600 text-white px-6 md:px-8 py-2 rounded-lg text-sm md:text-base font-semibold transition-colors shadow-md lg:min-w-[120px]">
                                        Edit
                                    </button>
                                    <button onclick="confirmDelete({{ $admin->id_User }}, 'admin')" class="flex-1 lg:flex-none bg-red-400 hover:bg-red-500 text-white px-6 md:px-8 py-2 rounded-lg text-sm md:text-base font-semibold transition-colors shadow-md lg:min-w-[120px]">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-2xl shadow-md p-8 md:p-12 text-center">
                            <p class="text-gray-400 text-base md:text-lg">Belum ada data admin</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Statistics -->
            <div id="statistics-content" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
                    <div class="bg-blue-500 text-white rounded-2xl p-6 md:p-8 shadow-lg">
                        <div class="flex items-center">
                            <svg class="w-10 h-10 md:w-12 md:h-12 mr-3 md:mr-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                            <div>
                                <p class="text-base md:text-xl font-medium opacity-90">Total Pegawai</p>
                                <p class="text-3xl md:text-4xl font-bold mt-1">{{ count($pegawais) }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-blue-500 text-white rounded-2xl p-6 md:p-8 shadow-lg">
                        <div class="flex items-center">
                            <svg class="w-10 h-10 md:w-12 md:h-12 mr-3 md:mr-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                            <div>
                                <p class="text-base md:text-xl font-medium opacity-90">Total Admin</p>
                                <p class="text-3xl md:text-4xl font-bold mt-1">{{ count($admins) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-orange-500 text-white rounded-2xl p-6 md:p-8 shadow-lg md:col-span-2 lg:col-span-1">
                        <div class="flex items-center">
                            <svg class="w-10 h-10 md:w-12 md:h-12 mr-3 md:mr-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-base md:text-xl font-medium opacity-90">Total Libur</p>
                                <p class="text-3xl md:text-4xl font-bold mt-1">{{ count($liburs ?? []) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-md">
                    <div class="p-4 md:p-6 border-b">
                        <h2 class="text-xl md:text-2xl font-bold text-gray-800">Performa Pegawai</h2>
                    </div>
                    <div class="p-4 md:p-6 space-y-3 md:space-y-4">
                        @foreach($pegawais as $pegawai)
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 md:p-5 bg-gray-50 rounded-xl gap-3">
                                <div class="flex items-center space-x-3 md:space-x-4">
                                    <div class="w-10 h-10 md:w-12 md:h-12 bg-gray-400 rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold text-sm md:text-base">{{ substr($pegawai->nama, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800 text-sm md:text-base">{{ $pegawai->nama }}</h3>
                                        <span class="inline-block bg-teal-400 text-white px-2 md:px-3 py-1 rounded-full text-xs font-medium mt-1">
                                            Karyawan
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3 md:space-x-6 w-full sm:w-auto">
                                    <p class="font-bold text-gray-800 text-base md:text-lg">{{ $pegawai->jumlah_mobil }} Mobil</p>
                                    <div class="flex-1 sm:w-32 md:w-40 bg-gray-300 rounded-full h-2 md:h-3">
                                        <div class="bg-teal-400 h-2 md:h-3 rounded-full" style="width: {{ min(($pegawai->jumlah_mobil / 1000) * 100, 100) }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @foreach($admins as $admin)
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 md:p-5 bg-gray-50 rounded-xl gap-3">
                                <div class="flex items-center space-x-3 md:space-x-4">
                                    <div class="w-10 h-10 md:w-12 md:h-12 bg-gray-400 rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold text-sm md:text-base">{{ substr($admin->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800 text-sm md:text-base">{{ $admin->name }}</h3>
                                        <span class="inline-block bg-blue-400 text-white px-2 md:px-3 py-1 rounded-full text-xs font-medium mt-1">
                                            Admin
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3 md:space-x-6 w-full sm:w-auto">
                                    <p class="font-bold text-gray-800 text-base md:text-lg">{{ $admin->jumlah_mobil }} Mobil</p>
                                    <div class="flex-1 sm:w-32 md:w-40 bg-gray-300 rounded-full h-2 md:h-3">
                                        <div class="bg-teal-400 h-2 md:h-3 rounded-full" style="width: {{ min(($admin->jumlah_mobil / 1000) * 100, 100) }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Libur Management -->
            <div id="libur-content" style="display: none;">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <div class="bg-orange-400 text-white px-4 md:px-6 py-2 md:py-3 rounded-full text-sm md:text-base font-semibold shadow-md">
                        Total Data Libur: {{ count($liburs ?? []) }}
                    </div>
                    <button onclick="openModal('add', 'libur')" class="w-full sm:w-auto bg-blue-500 hover:bg-blue-600 text-white px-6 md:px-8 py-2 md:py-3 rounded-xl text-sm md:text-base font-semibold shadow-md transition-colors">
                        Tambah Data Libur
                    </button>
                </div>
                
                <div class="space-y-4 md:space-y-5" id="libur-list">
                    @forelse($liburs ?? [] as $libur)
                        <div class="bg-white rounded-2xl shadow-md p-4 md:p-6 hover:shadow-lg transition-shadow" data-id="{{ $libur->id_libur }}">
                            <div class="flex flex-col lg:flex-row items-start lg:items-center gap-4">
                                <div class="flex items-center space-x-4 w-full lg:w-auto">
                                    <div class="w-12 h-12 md:w-16 md:h-16 bg-orange-400 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="lg:hidden">
                                        <h3 class="font-bold text-gray-800 text-base md:text-lg mb-1">
                                            @if($libur->id_pegawai)
                                                {{ $libur->pegawai->nama ?? 'Pegawai tidak ditemukan' }}
                                            @else
                                                {{ $libur->user->name ?? 'Admin tidak ditemukan' }}
                                            @endif
                                        </h3>
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-medium 
                                            {{ $libur->id_pegawai ? 'bg-teal-400 text-white' : 'bg-blue-400 text-white' }}">
                                            {{ $libur->id_pegawai ? 'Pegawai' : 'Admin' }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-12 flex-1 w-full">
                                    <div class="hidden lg:block">
                                        <h3 class="font-bold text-gray-800 text-lg mb-2">
                                            @if($libur->id_pegawai)
                                                {{ $libur->pegawai->nama ?? 'Pegawai tidak ditemukan' }}
                                            @else
                                                {{ $libur->user->name ?? 'Admin tidak ditemukan' }}
                                            @endif
                                        </h3>
                                        <span class="inline-block px-4 py-1 rounded-full text-sm font-medium 
                                            {{ $libur->id_pegawai ? 'bg-teal-400 text-white' : 'bg-blue-400 text-white' }}">
                                            {{ $libur->id_pegawai ? 'Pegawai' : 'Admin' }}
                                        </span>
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <div>
                                            <p class="text-gray-500 text-xs md:text-sm font-medium">Tanggal</p>
                                            <p class="text-gray-800 font-bold text-base md:text-lg">{{ $libur->hari }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-xs md:text-sm font-medium">Status</p>
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium 
                                                {{ strtotime($libur->hari) < time() ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                                {{ strtotime($libur->hari) < time() ? 'Selesai' : 'Akan Datang' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex flex-row lg:flex-col space-x-3 lg:space-x-0 lg:space-y-3 w-full lg:w-auto">
                                    <button onclick="editLibur({{ $libur->id_libur }})" class="flex-1 lg:flex-none bg-blue-500 hover:bg-blue-600 text-white px-6 md:px-8 py-2 rounded-lg text-sm md:text-base font-semibold transition-colors shadow-md lg:min-w-[120px]">
                                        Edit
                                    </button>
                                    <button onclick="confirmDelete({{ $libur->id_libur }}, 'libur')" class="flex-1 lg:flex-none bg-red-400 hover:bg-red-500 text-white px-6 md:px-8 py-2 rounded-lg text-sm md:text-base font-semibold transition-colors shadow-md lg:min-w-[120px]">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-2xl shadow-md p-8 md:p-12 text-center">
                            <p class="text-gray-400 text-base md:text-lg">Belum ada data libur</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
<div id="modal" class="fixed inset-0 bg-black/30 backdrop-blur-[2px]  bg-opacity-30 flex items-center justify-center z-50 p-4" style="display: none;">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
            <form id="modal-form">
                <div class="px-6 md:px-8 py-5 md:py-6 border-b sticky top-0 bg-white flex justify-between items-center">
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800" id="modal-title">
                        Tambah Pegawai
                    </h2>
                    <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">
                        ×
                    </button>
                </div>
                
                <div class="px-6 md:px-8 py-5 md:py-6 space-y-4 md:space-y-5" id="modal-fields">
                    <!-- Dynamic fields -->
                </div>
                
                <div class="px-6 md:px-8 py-5 md:py-6 border-t flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 sticky bottom-0 bg-white">
                    <button type="button" onclick="closeModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 py-3 px-6 rounded-xl font-semibold text-sm md:text-base transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-3 px-6 rounded-xl font-semibold text-sm md:text-base transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Confirm Delete Modal -->
    <div id="confirm-modal" class="fixed inset-0 bg-black/30 backdrop-blur-[2px]  bg-opacity-30 flex items-center justify-center z-50 p-4" style="display: none;">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
            <div class="px-6 md:px-8 py-5 md:py-6">
                <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-3 md:mb-4">Pemberitahuan</h2>
                <p class="text-gray-600 text-base md:text-lg mb-6 md:mb-8">Yakin Ingin Menghapus Data Ini?</p>
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                    <button onclick="closeConfirmModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 py-3 px-6 rounded-xl font-semibold text-sm md:text-base transition-colors">
                        Batal
                    </button>
                    <button onclick="deleteItem()" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-3 px-6 rounded-xl font-semibold text-sm md:text-base transition-colors">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
<script>
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
        $('[id^="tab-"]').removeClass('bg-teal-400 text-white').addClass('text-gray-500 hover:bg-gray-50');
        $('#tab-' + tab).removeClass('text-gray-500 hover:bg-gray-50').addClass('bg-teal-400 text-white');
        $('#employees-content, #admins-content, #libur-content, #statistics-content').hide();
        $('#' + tab + '-content').show();
    }

    function openModal(type, dataType) {
        modalType = type;
        currentDataType = dataType;
        editingId = null;

        let title = '';
        if (dataType === 'employee') title = (type === 'add' ? 'Tambah ' : 'Edit ') + 'Pegawai';
        else if (dataType === 'admin') title = (type === 'add' ? 'Tambah ' : 'Edit ') + 'Admin';
        else if (dataType === 'libur') title = (type === 'add' ? 'Tambah ' : 'Edit ') + 'Data Libur';

        $('#modal-title').text(title);
        generateModalFields(dataType, null);
        $('#modal').show();
    }

    function generateModalFields(dataType, data) {
        let fieldsHtml = '';

        if (dataType === 'employee') {
            fieldsHtml = `
                <div>
                    <label class="block text-xs md:text-sm font-semibold text-gray-700 mb-2">Foto Pegawai</label>
                    <input type="file" name="foto" class="w-full px-3 md:px-4 py-2 md:py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-400 text-sm md:text-base">
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-semibold text-gray-700 mb-2">Nama Panjang Pegawai</label>
                    <input type="text" name="nama" value="${data?.nama || ''}" class="w-full px-3 md:px-4 py-2 md:py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-400 text-sm md:text-base" required>
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-semibold text-gray-700 mb-2">Email Pribadi Pegawai</label>
                    <input type="email" name="email" value="${data?.email || ''}" class="w-full px-3 md:px-4 py-2 md:py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-400 text-sm md:text-base" required>
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-semibold text-gray-700 mb-2">Nomor Telepon Pegawai</label>
                    <input type="text" name="nomor_telepon" value="${data?.nomor_telepon || ''}" class="w-full px-3 md:px-4 py-2 md:py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-400 text-sm md:text-base" required>
                </div>`;
        } else if (dataType === 'admin') {
            fieldsHtml = `
                <div>
                    <label class="block text-xs md:text-sm font-semibold text-gray-700 mb-2">Foto Admin</label>
                    <input type="file" name="foto" class="w-full px-3 md:px-4 py-2 md:py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-400 text-sm md:text-base">
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-semibold text-gray-700 mb-2">Nama Panjang Admin</label>
                    <input type="text" name="name" value="${data?.name || ''}" class="w-full px-3 md:px-4 py-2 md:py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-400 text-sm md:text-base" required>
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-semibold text-gray-700 mb-2">Email Login Admin</label>
                    <input type="email" name="email" value="${data?.email || ''}" class="w-full px-3 md:px-4 py-2 md:py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-400 text-sm md:text-base" required>
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-semibold text-gray-700 mb-2">Password Login Admin</label>
                    <input type="password" name="password" class="w-full px-3 md:px-4 py-2 md:py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-400 text-sm md:text-base" ${modalType === 'add' ? 'required' : ''}>
                    ${modalType === 'edit' ? '<small class="text-gray-500 text-xs md:text-sm">Kosongkan jika tidak ingin mengubah password</small>' : ''}
                </div>`;
        } else if (dataType === 'libur') {
            fieldsHtml = `
                <div>
                    <label class="block text-xs md:text-sm font-semibold text-gray-700 mb-2">Pilih Karyawan/Admin</label>
                    <select name="person_type" id="person_type" onchange="updatePersonSelect()" class="w-full px-3 md:px-4 py-2 md:py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-400 text-sm md:text-base" required>
                        <option value="">Pilih Tipe</option>
                        <option value="pegawai" ${data?.id_pegawai ? 'selected' : ''}>Pegawai</option>
                        <option value="admin" ${data?.id_user ? 'selected' : ''}>Admin</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-semibold text-gray-700 mb-2">Pilih Nama</label>
                    <select name="person_id" id="person_id" class="w-full px-3 md:px-4 py-2 md:py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-400 text-sm md:text-base" required>
                        <option value="">Pilih nama terlebih dahulu</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-semibold text-gray-700 mb-2">Hari Libur</label>
                    <select name="hari" class="w-full px-3 md:px-4 py-2 md:py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-400 text-sm md:text-base" required>
                        <option value="">Pilih Hari</option>
                        ${['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'].map(day =>
                            `<option value="${day}" ${data?.hari === day ? 'selected' : ''}>${day}</option>`
                        ).join('')}
                    </select>
                </div>`;
        }

        $('#modal-fields').html(fieldsHtml);
    }

    function updatePersonSelect() {
        const personType = $('#person_type').val();
        const personSelect = $('#person_id');
        personSelect.empty().append('<option value="">Loading...</option>');

        const url = personType === 'pegawai' ? '/api/pegawais-dropdown' : '/api/admins-dropdown';
        if (!personType) {
            personSelect.html('<option value="">Pilih tipe terlebih dahulu</option>');
            return;
        }

        $.get(url)
            .done(res => {
                personSelect.empty().append(`<option value="">Pilih ${personType}</option>`);
                (res.data || []).forEach(p => {
                    const id = personType === 'pegawai' ? p.id_Pegawai : p.id_User;
                    const name = personType === 'pegawai' ? p.nama : p.name;
                    personSelect.append(`<option value="${id}">${name}</option>`);
                });
            })
            .fail(() => personSelect.html('<option value="">Gagal memuat data</option>'));
    }

    function closeModal() {
        $('#modal').hide();
        editingId = null;
    }

    function editEmployee(id) {
        $.get(`/owner/pegawais/${id}/edit`)
            .done(res => {
                modalType = 'edit';
                currentDataType = 'employee';
                editingId = id;
                $('#modal-title').text('Edit Pegawai');
                generateModalFields('employee', res.data);
                $('#modal').show();
            })
            .fail(() => alert('Error loading employee data'));
    }

    function editAdmin(id) {
        $.get(`/owner/admins/${id}/edit`)
            .done(res => {
                modalType = 'edit';
                currentDataType = 'admin';
                editingId = id;
                $('#modal-title').text('Edit Admin');
                generateModalFields('admin', res.data);
                $('#modal').show();
            })
            .fail(() => alert('Error loading admin data'));
    }

    function editLibur(id) {
        $.get(`/owner/liburs/${id}/edit`)
            .done(res => {
                modalType = 'edit';
                currentDataType = 'libur';
                editingId = id;
                $('#modal-title').text('Edit Data Libur');
                generateModalFields('libur', res.data);
                $('#modal').show();
            })
            .fail(() => alert('Error loading libur data'));
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

        let url = `/owner/${deleteType}s/${deleteId}`;
        $.ajax({
            url,
            type: 'DELETE',
            success: res => res.success ? location.reload() : alert('Error deleting item'),
            error: () => alert('Error deleting item')
        });

        closeConfirmModal();
    }

    $('#modal-form').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        let url = '', method = 'POST';

        if (currentDataType === 'employee') {
            url = modalType === 'add' ? '/owner/pegawais' : `/owner/pegawais/${editingId}`;
            if (modalType === 'edit') formData.append('_method', 'PUT');
        } else if (currentDataType === 'admin') {
            url = modalType === 'add' ? '/owner/admins' : `/owner/admins/${editingId}`;
            if (modalType === 'edit') formData.append('_method', 'PUT');
        } else if (currentDataType === 'libur') {
            const personType = formData.get('person_type');
            const personId = formData.get('person_id');
            const hari = formData.get('hari');
            if (!personType || !personId || !hari) return alert('Semua field harus diisi');
            formData.delete('person_type'); formData.delete('person_id');
            formData.append(personType === 'pegawai' ? 'id_pegawai' : 'id_user', personId);
            url = modalType === 'add' ? '/owner/liburs' : `/owner/liburs/${editingId}`;
            if (modalType === 'edit') formData.append('_method', 'PUT');
        }

        $.ajax({
            url, type: 'POST', data: formData, processData: false, contentType: false,
            success: res => res.success ? (closeModal(), location.reload()) : alert('Error: ' + (res.message || 'Unknown error')),
            error: xhr => {
                if (xhr.status === 422) {
                    const res = xhr.responseJSON;
                    let msg = 'Validasi gagal:\n';
                    for (const f in res.errors) msg += `- ${res.errors[f].join(', ')}\n`;
                    alert(msg);
                } else alert('Error saving data. Status: ' + xhr.status);
            }
        });
    });
</script>

@endsection