@extends('layouts.admin')

@section('title', 'Data User')

@section('content')
    <!-- Header & Button -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 pt-4">
        <h2 class="text-2xl font-bold text-slate-700">Data User</h2>
        <button onclick="openCreateModal()" 
           class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition duration-200">
            + Create New User
        </button>
    </div>

    <!-- Filter -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <form action="{{ route('admin.users.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Cari User</label>
                <input type="text" name="q" value="{{ request('q') }}" 
                       class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-200 focus:outline-none" 
                       placeholder="Masukkan nama / email">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Tanggal Daftar</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" 
                       class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-200 focus:outline-none">
            </div>
            <div class="flex items-end gap-2 sm:col-span-2 lg:col-span-1">
                <button type="submit" 
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white rounded p-2 font-semibold transition duration-200">
                    Filter
                </button>
                @if(request('q') || request('tanggal'))
                    <a href="{{ route('admin.users.index') }}" 
                       class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded transition duration-200">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 flex items-center justify-between">
            <span class="text-sm sm:text-base">{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900 ml-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 flex items-center justify-between">
            <span class="text-sm sm:text-base">{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900 ml-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    @endif

    <!-- Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6">
        <div class="bg-blue-600 shadow-lg rounded-lg p-4 sm:p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xs sm:text-sm opacity-90 mb-1">Total User</h3>
                    <p class="text-2xl sm:text-3xl font-bold">{{ $totalUser ?? 0 }}</p>
                </div>
                <div>
                    <svg class="w-12 h-12 sm:w-16 sm:h-16 opacity-90" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-teal-600 shadow-lg rounded-lg p-4 sm:p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xs sm:text-sm opacity-90 mb-1">Active User</h3>
                    <p class="text-2xl sm:text-3xl font-bold">{{ $activeUser ?? 0 }}</p>
                </div>
                <div>
                    <svg class="w-12 h-12 sm:w-16 sm:h-16 opacity-90" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-blue-500 shadow-lg rounded-lg p-4 sm:p-6 text-white sm:col-span-2 lg:col-span-1">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xs sm:text-sm opacity-90 mb-1">New User (Today)</h3>
                    <p class="text-2xl sm:text-3xl font-bold">{{ $newUser ?? 0 }}</p>
                </div>
                <div>
                    <svg class="w-12 h-12 sm:w-16 sm:h-16 opacity-90" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel User -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-gradient-to-r from-blue-500 to-teal-500 text-white uppercase text-xs">
                    <tr>
                        <th class="px-3 sm:px-6 py-3 sm:py-4">Profile</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4">Username</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 hidden md:table-cell">Email</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 hidden lg:table-cell">No. Telepon</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 hidden sm:table-cell">Tanggal Daftar</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-blue-50 transition duration-150">
                            <td class="px-3 sm:px-6 py-3 sm:py-4">
                                <img src="{{ $user->foto_profile_url }}" 
                                     class="w-10 h-10 sm:w-12 sm:h-12 rounded-full border-2 border-blue-200" 
                                     alt="{{ $user->name }}">
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4">
                                <div class="font-medium text-gray-800 text-xs sm:text-sm">{{ $user->nama_lengkap }}</div>
                                <div class="text-xs text-gray-500 md:hidden">{{ $user->email }}</div>
                                @if($user->alamat)
                                    <div class="text-xs text-gray-500 hidden sm:block">{{ Str::limit($user->alamat, 30) }}</div>
                                @endif
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 text-gray-600 hidden md:table-cell text-xs sm:text-sm">{{ $user->email }}</td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 text-gray-600 hidden lg:table-cell text-xs sm:text-sm">{{ $user->no_telepon ?? '-' }}</td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 text-gray-600 hidden sm:table-cell text-xs sm:text-sm">
                                {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4">
                                <div class="flex justify-center">
                                    <button type="button" 
                                            onclick="openDeleteModal('{{ $user->id_User }}', '{{ $user->nama_lengkap }}')"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 sm:px-4 sm:py-2 rounded text-xs transition duration-200 flex items-center gap-1">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="hidden sm:inline">Delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-8 px-4">
                                <svg class="w-12 h-12 sm:w-16 sm:h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <p class="text-base sm:text-lg font-medium">Tidak ada user ditemukan</p>
                                <p class="text-xs sm:text-sm text-gray-400 mt-1">Silakan tambah user baru atau ubah filter pencarian</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $users->links() }}
    </div>

    <!-- Create User Modal -->
    <div id="createModal"  class="hidden fixed inset-0 bg-black/30 backdrop-blur-[2px] flex items-center justify-center z-50 p-4" style="z-index: 9999;">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col animate-fade-in">
            <!-- Header - Fixed -->
            <div class="flex justify-between items-center p-4 sm:p-5 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-800">Create New User</h3>
                <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Form Content - Scrollable -->
            <div class="overflow-y-auto flex-1 p-4 sm:p-5">
                <form id="createUserForm" action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Depan *</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Masukkan nama depan"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="nama_belakang" class="block text-sm font-medium text-gray-700 mb-1">Nama Belakang</label>
                        <input type="text" 
                               id="nama_belakang" 
                               name="nama_belakang" 
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Masukkan nama belakang (opsional)">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="contoh@email.com"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                        <input type="text" 
                               id="no_telepon" 
                               name="no_telepon" 
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="08xxxxxxxxxx">
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <textarea id="alamat" 
                                  name="alamat" 
                                  rows="2"
                                  class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                  placeholder="Masukkan alamat lengkap"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Minimal 6 karakter"
                               required>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password *</label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Ulangi password"
                               required>
                    </div>
                </form>
            </div>

            <!-- Footer Buttons - Fixed -->
            <div class="flex flex-col-reverse sm:flex-row justify-end gap-2 p-4 sm:p-5 border-t border-gray-200 bg-gray-50">
                <button type="button" 
                        onclick="closeCreateModal()"
                        class="w-full sm:w-auto px-4 py-2 text-sm text-gray-600 bg-white border border-gray-300 hover:bg-gray-100 rounded-md transition duration-200">
                    Cancel
                </button>
                <button type="button"
                        onclick="document.getElementById('createUserForm').submit()"
                        class="w-full sm:w-auto px-5 py-2 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-md transition duration-200 font-medium">
                    Simpan User
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black/30 backdrop-blur-[2px] flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-2xl p-4 sm:p-6 w-full max-w-md">
            <div class="text-center mb-6">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-2">Konfirmasi Hapus</h3>
                <p class="text-sm sm:text-base text-gray-600 mb-2" id="deleteMessage">Anda yakin ingin menghapus user ini?</p>
                <p class="text-xs sm:text-sm text-gray-500">Data yang dihapus dapat dipulihkan kembali.</p>
            </div>
            
            <div class="flex flex-col-reverse sm:flex-row justify-center gap-2 sm:gap-3">
                <button type="button" onclick="closeDeleteModal()"
                   class="w-full sm:w-auto px-6 py-2 bg-white hover:bg-gray-100 text-gray-700 border border-gray-300 rounded-md transition duration-200">
                    Batal
                </button>
                <button type="button" onclick="confirmDelete()" 
                        class="w-full sm:w-auto px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition duration-200">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden form for delete -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        let deleteUserId = null;

        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('createUserForm').reset();
        }

        function openDeleteModal(userId, userName) {
            deleteUserId = userId;
            document.getElementById('deleteMessage').textContent = `Anda yakin ingin menghapus "${userName}"?`;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            deleteUserId = null;
        }

        function confirmDelete() {
            if (deleteUserId) {
                const form = document.getElementById('deleteForm');
                form.action = `/admin/users/${deleteUserId}`;
                form.submit();
            }
        }

        // Close modals when clicking outside
        document.getElementById('createModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeCreateModal();
            }
        });

        document.getElementById('deleteModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeCreateModal();
                closeDeleteModal();
            }
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('[class*="bg-green-50"], [class*="bg-red-50"]');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.2s ease-out;
        }

        /* Custom Scrollbar */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 10px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }
    </style>
@endsection