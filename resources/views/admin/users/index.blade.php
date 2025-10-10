@extends('layouts.admin')

@section('title', 'Data User')

@section('content')
    <!-- Header & Button -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-slate-700">Data User</h2>
        <button onclick="openCreateModal()" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            + Create New User
        </button>
    </div>

    <!-- Filter -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <form action="{{ route('admin.users.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Cari User</label>
                <input type="text" name="q" value="{{ request('q') }}" 
                       class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-200" 
                       placeholder="Masukkan nama / email">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Tanggal Daftar</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" 
                       class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-200">
            </div>
            <div class="flex items-end">
                <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded p-2 font-semibold">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <h3 class="text-sm text-gray-500">Total User</h3>
            <p class="text-2xl font-bold text-slate-700">{{ $totalUser ?? 0 }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <h3 class="text-sm text-gray-500">Active User</h3>
            <p class="text-2xl font-bold text-green-600">{{ $activeUser ?? 0 }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <h3 class="text-sm text-gray-500">New User</h3>
            <p class="text-2xl font-bold text-blue-600">{{ $newUser ?? 0 }}</p>
        </div>
    </div>

    <!-- Tabel User -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Profile</th>
                    <th class="px-6 py-3">Username</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Password</th>
                    <th class="px-6 py-3">Operation</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($users as $user)
                    <tr>
                        <td class="px-6 py-4">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" 
                                 class="w-10 h-10 rounded-full" alt="avatar">
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-gray-600">********</td>
                        <td class="px-6 py-4 flex space-x-2">
                            <!-- Delete Button - FIXED: Menggunakan modal alih-alih confirm -->
                            <button type="button" 
                                    onclick="openDeleteModal('{{ $user->id }}', '{{ $user->name }}', '{{ route('admin.users.destroy', $user) }}')"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada user ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->links() }}
    </div>

    <!-- Create User Modal -->
    <div id="createModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4">
            <h3 class="text-xl font-bold text-gray-800 mb-6">Create User</h3>
            
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                
                <!-- Username -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Enter username"
                           required>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Enter email"
                           required>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Enter password"
                           required>
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Confirm password"
                           required>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeCreateModal()"
                       class="px-4 py-2 text-gray-600 bg-gray-200 hover:bg-gray-300 rounded-md transition duration-200">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-md transition duration-200">
                        Konfirmasi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4">
            <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">Pemberitahuan</h3>
            <p class="text-gray-600 mb-6 text-center" id="deleteMessage">Anda Yakin Ingin Menghapus user?</p>
            
            <div class="flex justify-center space-x-3">
                <button type="button" onclick="closeDeleteModal()"
                   class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md transition duration-200">
                    Batal
                </button>
                <button type="button" onclick="confirmDelete()" 
                        class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition duration-200">
                    Konfirmasi
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
        let deleteRoute = null;

        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
        }

        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
        }

        function openDeleteModal(userId, userName, route) {
            deleteRoute = route;
            document.getElementById('deleteMessage').textContent = `Anda Yakin Ingin Menghapus ${userName}?`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            deleteRoute = null;
        }

        function confirmDelete() {
            if (deleteRoute) {
                const form = document.getElementById('deleteForm');
                form.action = deleteRoute;
                form.submit();
            }
        }

        // Close modals when clicking outside
        document.getElementById('createModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCreateModal();
            }
        });

        document.getElementById('deleteModal').addEventListener('click', function(e) {
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
    </script>
@endsection