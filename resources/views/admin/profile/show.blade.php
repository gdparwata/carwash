@extends('layouts.admin')

@section('title', 'Profil Admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-800 mb-8">Profil Admin</h1>

        <!-- Alert Messages -->
        @if(session('success'))
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="font-semibold">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
            <div class="flex items-center mb-2">
                <svg class="w-6 h-6 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <p class="font-semibold">Terjadi Kesalahan:</p>
            </div>
            <ul class="list-disc list-inside ml-8">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Profile Card -->
            <div class="lg:col-span-1">
                <div class="bg-gradient-to-br from-cyan-400 to-cyan-600 rounded-2xl shadow-2xl p-8 text-center">
                    <!-- Profile Picture -->
                    <div class="mb-6">
                        @if($user->foto_profile)
                        <img src="{{ asset('storage/' . $user->foto_profile) }}" 
                             alt="Profile" 
                             class="w-40 h-40 rounded-full mx-auto object-cover border-4 border-white shadow-xl">
                        @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=200&background=667eea&color=fff" 
                             alt="Profile" 
                             class="w-40 h-40 rounded-full mx-auto border-4 border-white shadow-xl">
                        @endif
                    </div>

                    <button type="button" 
                            onclick="document.getElementById('photoModal').classList.remove('hidden')"
                            class="bg-white text-cyan-600 font-semibold px-6 py-2 rounded-lg shadow-md hover:bg-gray-50 hover:shadow-lg transform hover:-translate-y-0.5 transition duration-300 mb-6">
                        Edit Profile
                    </button>

                    <!-- Stats Cards -->
                    <div class="space-y-4">
                        <div class="bg-white rounded-xl p-4 shadow-lg hover:shadow-xl transition duration-300">
                            <svg class="w-12 h-12 text-blue-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="text-3xl font-bold text-gray-800">32</h3>
                            <p class="text-sm text-gray-600">Artikel Dibuat</p>
                        </div>

                        <div class="bg-white rounded-xl p-4 shadow-lg hover:shadow-xl transition duration-300">
                            <svg class="w-12 h-12 text-yellow-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h3 class="text-3xl font-bold text-gray-800">2</h3>
                            <p class="text-sm text-gray-600">Bulan Bergabung</p>
                        </div>

                        <div class="bg-white rounded-xl p-4 shadow-lg hover:shadow-xl transition duration-300">
                            <svg class="w-12 h-12 text-green-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <h3 class="text-3xl font-bold text-gray-800">99%</h3>
                            <p class="text-sm text-gray-600">Performa</p>
                        </div>
                    </div>

                    <!-- Logout Button -->
                    <button type="button" 
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="w-full mt-6 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold px-6 py-3 rounded-lg shadow-lg hover:from-red-600 hover:to-red-700 hover:shadow-xl transform hover:-translate-y-0.5 transition duration-300">
                        Log Out
                    </button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>

            <!-- Right Column - Forms -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Personal Information Card -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-500 to-blue-500 px-6 py-4">
                        <h2 class="text-2xl font-bold text-white">Informasi Pribadi</h2>
                    </div>
                    <div class="p-6 bg-gradient-to-br from-gray-50 to-white">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Depan</label>
                                    <input type="text" 
                                           name="name" 
                                           value="{{ old('name', $user->name) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition duration-200 shadow-sm" 
                                           required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Belakang</label>
                                    <input type="text" 
                                           name="nama_belakang" 
                                           value="{{ old('nama_belakang', $user->nama_belakang) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition duration-200 shadow-sm">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                    <input type="email" 
                                           name="email" 
                                           value="{{ old('email', $user->email) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition duration-200 shadow-sm" 
                                           required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">No. Telepon</label>
                                    <input type="text" 
                                           name="no_telepon" 
                                           value="{{ old('no_telepon', $user->no_telepon) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition duration-200 shadow-sm"
                                           placeholder="08xxxxxxxxxx">
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat</label>
                                <textarea name="alamat" 
                                          rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition duration-200 shadow-sm"
                                          placeholder="Masukkan alamat lengkap">{{ old('alamat', $user->alamat) }}</textarea>
                            </div>

                            <div class="flex gap-3">
                                <button type="submit" 
                                        class="bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold px-8 py-3 rounded-lg shadow-lg hover:from-cyan-600 hover:to-blue-600 hover:shadow-xl transform hover:-translate-y-0.5 transition duration-300">
                                    Edit Data
                                </button>
                                <button type="reset" 
                                        class="bg-gradient-to-r from-gray-400 to-gray-500 text-white font-semibold px-8 py-3 rounded-lg shadow-lg hover:from-gray-500 hover:to-gray-600 hover:shadow-xl transform hover:-translate-y-0.5 transition duration-300">
                                    Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Security Card -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-500 to-blue-500 px-6 py-4">
                        <h2 class="text-2xl font-bold text-white">Keamanan Akun</h2>
                    </div>
                    <div class="p-6 bg-gradient-to-br from-gray-50 to-white">
                        <form action="{{ route('profile.password') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Password Saat Ini</label>
                                <input type="password" 
                                       name="current_password" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition duration-200 shadow-sm" 
                                       required>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">New Password</label>
                                    <input type="password" 
                                           name="password" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition duration-200 shadow-sm" 
                                           required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                                    <input type="password" 
                                           name="password_confirmation" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition duration-200 shadow-sm" 
                                           required>
                                </div>
                            </div>

                            <button type="submit" 
                                    class="bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold px-8 py-3 rounded-lg shadow-lg hover:from-cyan-600 hover:to-blue-600 hover:shadow-xl transform hover:-translate-y-0.5 transition duration-300">
                                Ubah Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Photo Upload Modal -->
<div id="photoModal" class="hidden fixed inset-0 bg-gradient-to-br from-gray-800/60 via-gray-900/50 to-gray-800/60 flex items-center justify-center z-50 p-4 transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
        <div class="bg-gradient-to-r from-cyan-500 to-blue-500 px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-white">Ubah Foto Profile</h3>
                <button type="button" 
                        onclick="document.getElementById('photoModal').classList.add('hidden')"
                        class="text-white hover:text-gray-200 hover:bg-white hover:bg-opacity-20 rounded-full p-1 transition duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        <form action="{{ route('profile.photo') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="p-6 bg-gradient-to-br from-gray-50 to-white">
                <div class="text-center mb-6">
                    @if($user->foto_profile)
                    <img src="{{ asset('storage/' . $user->foto_profile) }}" 
                         alt="Current" 
                         class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-cyan-500 shadow-lg">
                    @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=150" 
                         alt="Current" 
                         class="w-32 h-32 rounded-full mx-auto border-4 border-cyan-500 shadow-lg">
                    @endif
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Foto Baru</label>
                    <input type="file" 
                           name="photo" 
                           accept="image/*" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition duration-200 shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100" 
                           required>
                    <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG. Maksimal 2MB</p>
                </div>
            </div>
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 px-6 py-4 flex items-center justify-between border-t border-gray-200">
                @if($user->foto_profile)
                <button type="button" 
                        onclick="if(confirm('Yakin ingin menghapus foto profile?')) { document.getElementById('delete-photo-form').submit(); }"
                        class="text-red-600 hover:text-red-800 hover:bg-red-50 font-semibold px-4 py-2 rounded-lg transition duration-200">
                    Hapus Foto
                </button>
                @else
                <div></div>
                @endif
                <div class="flex gap-3">
                    <button type="button" 
                            onclick="document.getElementById('photoModal').classList.add('hidden')"
                            class="px-6 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 font-semibold hover:bg-gray-50 hover:shadow-md transition duration-200">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-semibold rounded-lg shadow-lg hover:from-cyan-600 hover:to-blue-600 hover:shadow-xl transform hover:-translate-y-0.5 transition duration-300">
                        Upload
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Delete Photo Form -->
<form id="delete-photo-form" action="{{ route('profile.photo.delete') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endsection