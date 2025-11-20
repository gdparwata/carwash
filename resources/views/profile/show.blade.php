@extends('layouts.user')

@section('title', 'Dashboard Profile')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-cyan-400 via-blue-500 to-purple-600 py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-5xl font-bold text-center text-white mb-12 drop-shadow-2xl">Dashboard Profile Cucicar</h1>

        <!-- Alert Messages -->
        @if(session('success'))
        <div class="bg-green-500 text-white px-6 py-4 rounded-xl shadow-2xl mb-8 animate-bounce">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="font-bold">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-500 text-white px-6 py-4 rounded-xl shadow-2xl mb-8">
            <div class="flex items-center mb-2">
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <p class="font-bold">Terjadi Kesalahan:</p>
            </div>
            <ul class="list-disc list-inside ml-8">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Panel - Profile Picture -->
            <div class="lg:col-span-1">
                <div class="bg-white bg-opacity-95 backdrop-blur-lg rounded-3xl shadow-2xl p-8">
                    <!-- Back Button -->
                    <div class="mb-6">
                        <a href="{{ route('dashboard') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali
                        </a>
                    </div>

                    <!-- Profile Picture -->
                    <div class="mb-8">
                        @if($user->foto_profile)
                        <img src="{{ asset('storage/' . $user->foto_profile) }}" 
                             alt="Profile" 
                             class="w-48 h-48 rounded-full mx-auto object-cover border-8 border-blue-500 shadow-2xl ring-4 ring-white">
                        @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=250&background=667eea&color=fff&bold=true" 
                             alt="Profile" 
                             class="w-48 h-48 rounded-full mx-auto border-8 border-blue-500 shadow-2xl ring-4 ring-white">
                        @endif
                    </div>

                    <!-- View Mode Buttons -->
                    <div id="viewMode" class="space-y-3">
                        <button type="button" 
                                onclick="toggleEditMode()"
                                class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition duration-300">
                            Edit Profile
                    </button>
                        <button type="button" 
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="w-full bg-gradient-to-r from-red-600 to-red-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition duration-300 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            LogOut
                        </button>
                    </div>

                    <!-- Edit Mode Buttons -->
                    <div id="editMode" class="hidden space-y-3">
                        <button type="button" 
                                onclick="document.getElementById('photoModal').classList.remove('hidden')"
                                class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition duration-300">
                            Ubah Foto Profile
                        </button>
                        <button type="button" 
                                onclick="toggleEditMode()"
                                class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition duration-300">
                            Simpan & Kembali
                        </button>
                    </div>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>

            <!-- Right Panel - Profile Information -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Main Profile Card -->
                <div class="bg-white bg-opacity-95 backdrop-blur-lg rounded-3xl shadow-2xl p-8">
                    <!-- View Mode Form (Read-only) -->
                    <div id="profileViewForm">
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                                <input type="email" 
                                       value="{{ $user->email }}"
                                       class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-xl font-semibold text-gray-800 cursor-not-allowed" 
                                       readonly>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Username</label>
                                <input type="text" 
                                       value="{{ $user->name }}"
                                       class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-xl font-semibold text-gray-800 cursor-not-allowed" 
                                       readonly>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                                <input type="password" 
                                       value="**********"
                                       class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-xl font-semibold text-gray-800 cursor-not-allowed" 
                                       readonly>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nomor Telepon</label>
                                <input type="text" 
                                       value="{{ $user->no_telepon ?? '-' }}"
                                       class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-xl font-semibold text-gray-800 cursor-not-allowed" 
                                       readonly>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Alamat</label>
                                <input type="text" 
                                       value="{{ $user->alamat ?? '-' }}"
                                       class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-xl font-semibold text-gray-800 cursor-not-allowed" 
                                       readonly>
                            </div>
                        </div>

                        <div class="flex gap-3 mt-8">
                            <button type="button" 
                                    onclick="toggleEditMode()"
                                    class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition duration-300">
                                Update
                            </button>
                            <button type="button" 
                                    onclick="window.location.reload()"
                                    class="flex-1 bg-white border-2 border-gray-300 text-gray-700 font-bold py-3 px-6 rounded-xl hover:bg-gray-50 transition duration-300 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Refresh
                            </button>
                        </div>
                    </div>

                    <!-- Edit Mode Form -->
                    <form id="profileEditForm" action="{{ route('profile.update') }}" method="POST" class="hidden">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                                <input type="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}"
                                       class="w-full px-4 py-3 border-2 border-blue-300 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition duration-200" 
                                       required>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Username</label>
                                <input type="text" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}"
                                       class="w-full px-4 py-3 border-2 border-blue-300 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition duration-200" 
                                       required>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nomor Telepon</label>
                                <input type="text" 
                                       name="no_telepon" 
                                       value="{{ old('no_telepon', $user->no_telepon) }}"
                                       class="w-full px-4 py-3 border-2 border-blue-300 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition duration-200"
                                       placeholder="08xxxxxxxxxx">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Alamat</label>
                                <textarea name="alamat" 
                                          rows="3"
                                          class="w-full px-4 py-3 border-2 border-blue-300 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition duration-200"
                                          placeholder="Masukkan alamat lengkap">{{ old('alamat', $user->alamat) }}</textarea>
                            </div>
                        </div>

                        <div class="flex gap-3 mt-8">
                            <button type="submit" 
                                    class="flex-1 bg-gradient-to-r from-green-600 to-green-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition duration-300 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                                </svg>
                                Simpan Perubahan
                            </button>
                            <button type="button" 
                                    onclick="toggleEditMode()"
                                    class="flex-1 bg-white border-2 border-gray-300 text-gray-700 font-bold py-3 px-6 rounded-xl hover:bg-gray-50 transition duration-300">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Change Password Card -->
                <div class="bg-white bg-opacity-95 backdrop-blur-lg rounded-3xl shadow-2xl p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <svg class="w-7 h-7 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Ubah Password
                    </h2>
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Password Saat Ini</label>
                                <input type="password" 
                                       name="current_password" 
                                       class="w-full px-4 py-3 border-2 border-blue-300 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition duration-200" 
                                       required>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Password Baru</label>
                                <input type="password" 
                                       name="password" 
                                       class="w-full px-4 py-3 border-2 border-blue-300 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition duration-200" 
                                       required>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       class="w-full px-4 py-3 border-2 border-blue-300 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition duration-200" 
                                       required>
                            </div>
                        </div>

                        <button type="submit" 
                                class="w-full mt-8 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition duration-300 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                            Ubah Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Photo Upload Modal -->
<div id="photoModal" class="hidden fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full mx-4 overflow-hidden transform transition-all">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-5">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-bold text-white">Ubah Foto Profile</h3>
                <button type="button" 
                        onclick="document.getElementById('photoModal').classList.add('hidden')"
                        class="text-white hover:text-gray-200 transition duration-200 transform hover:rotate-90">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        <form action="{{ route('profile.photo') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="p-8">
                <div class="text-center mb-6">
                    @if($user->foto_profile)
                    <img src="{{ asset('storage/' . $user->foto_profile) }}" 
                         alt="Current" 
                         class="w-40 h-40 rounded-full mx-auto object-cover border-4 border-blue-500 shadow-xl ring-4 ring-blue-100">
                    @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=200&background=667eea&color=fff" 
                         alt="Current" 
                         class="w-40 h-40 rounded-full mx-auto border-4 border-blue-500 shadow-xl ring-4 ring-blue-100">
                    @endif
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-3">Pilih Foto Baru</label>
                    <input type="file" 
                           name="photo" 
                           accept="image/*" 
                           class="w-full px-4 py-3 border-2 border-blue-300 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" 
                           required>
                    <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG. Maksimal 2MB</p>
                </div>
            </div>
            <div class="bg-gray-50 px-8 py-5 flex items-center justify-between border-t border-gray-200">
                @if($user->foto_profile)
                <button type="button" 
                        onclick="if(confirm('Yakin ingin menghapus foto profile?')) { document.getElementById('delete-photo-form').submit(); }"
                        class="text-red-600 hover:text-red-800 font-bold transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus Foto
                </button>
                @else
                <div></div>
                @endif
                <div class="flex gap-3">
                    <button type="button" 
                            onclick="document.getElementById('photoModal').classList.add('hidden')"
                            class="px-6 py-2 border-2 border-gray-300 rounded-xl text-gray-700 font-bold hover:bg-gray-100 transition duration-300">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-300">
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

<script>
function toggleEditMode() {
    const viewForm = document.getElementById('profileViewForm');
    const editForm = document.getElementById('profileEditForm');
    const viewMode = document.getElementById('viewMode');
    const editMode = document.getElementById('editMode');
    
    if (viewForm.style.display === 'none' || viewForm.classList.contains('hidden')) {
        viewForm.classList.remove('hidden');
        editForm.classList.add('hidden');
        viewMode.classList.remove('hidden');
        editMode.classList.add('hidden');
    } else {
        viewForm.classList.add('hidden');
        editForm.classList.remove('hidden');
        viewMode.classList.add('hidden');
        editMode.classList.remove('hidden');
    }
}
</script>
@endsection