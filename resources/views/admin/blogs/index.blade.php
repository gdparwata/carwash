@extends('layouts.admin')

@section('title', 'Pengelolaan Artikel')

@section('content')
<div class="w-full bg-gray-100 min-h-screen p-6">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-bold text-gray-700 mb-6">Pengelolaan Blog</h2>

        {{-- Alert Success --}}
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
        @endif

        {{-- Form Tambah Artikel --}}
        <div class="bg-blue-500 rounded-lg shadow-lg p-8 mb-8">
            <h3 class="text-2xl font-semibold text-white mb-6">Form Tambah Artikel</h3>
            
            <form id="blogForm" action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Judul Artikel --}}
                <div>
                    <label class="block text-white font-medium mb-2">Judul artikel</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                           class="w-full rounded-lg px-4 py-3 border-none focus:ring-2 focus:ring-blue-300 text-gray-800" 
                           placeholder="Masukkan judul artikel..." required>
                    @error('title')
                        <span class="text-red-200 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Kategori dan Penulis --}}
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-white font-medium mb-2">Kategori Artikel</label>
                        <input type="text" name="kategori" value="{{ old('kategori') }}"
                               class="w-full rounded-lg px-4 py-3 border-none focus:ring-2 focus:ring-blue-300 text-gray-800" 
                               placeholder="Tentang Mobil, Berita Perusahaan Berita Terkini">
                    </div>
                    <div>
                        <label class="block text-white font-medium mb-2">Penulis artikel</label>
                        <input type="text" name="penulis" value="{{ auth()->user()->name }}"
                               class="w-full rounded-lg px-4 py-3 border-none bg-gray-200 text-gray-600" readonly>
                    </div>
                </div>

                {{-- Ringkasan Artikel --}}
                <div>
                    <label class="block text-white font-medium mb-2">Ringkasan Artikel</label>
                    <textarea name="deskripsi_singkat" rows="4"
                              class="w-full rounded-lg px-4 py-3 border-none focus:ring-2 focus:ring-blue-300 text-gray-800 resize-none" 
                              placeholder="Tulis ringkasan artikel..." required>{{ old('deskripsi_singkat') }}</textarea>
                    @error('deskripsi_singkat')
                        <span class="text-red-200 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Konten Artikel --}}
                <div>
                    <label class="block text-white font-medium mb-2">Konten Artikel</label>
                    <textarea name="isi" rows="6"
                              class="w-full rounded-lg px-4 py-3 border-none focus:ring-2 focus:ring-blue-300 text-gray-800 resize-none" 
                              placeholder="Tulis konten artikel lengkap..." required>{{ old('isi') }}</textarea>
                    @error('isi')
                        <span class="text-red-200 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Upload Gambar --}}
                <div>
                    <label class="block text-white font-medium mb-2">Gambar Utama</label>
                    <div class="bg-white rounded-lg p-8 border-2 border-dashed border-gray-300 text-center">
                        <input type="file" name="gambar" id="gambar" class="hidden" accept="image/*" onchange="previewImage(event)">
                        <label for="gambar" class="cursor-pointer">
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-8 h-8 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/>
                                </svg>
                                <span class="text-blue-500 font-medium hover:underline">Pilih gambar atau drag & drop</span>
                            </div>
                        </label>
                        <div id="preview" class="mt-4"></div>
                    </div>
                    @error('gambar')
                        <span class="text-red-200 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tags --}}
                <div>
                    <label class="block text-white font-medium mb-2">Tags</label>
                    <input type="text" name="tags" value="{{ old('tags') }}"
                           class="w-full rounded-lg px-4 py-3 border-none focus:ring-2 focus:ring-blue-300 text-gray-800" 
                           placeholder="Contoh: cuci mobil, tips berkendara">
                </div>

                {{-- Hidden status field --}}
                <input type="hidden" name="status" id="statusInput" value="">

                {{-- Tombol Aksi --}}
                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="confirmSubmit('published')"
                            class="flex-1 bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 rounded-lg transition duration-200 shadow-md">
                        Publish
                    </button>
                    <button type="button" onclick="confirmSubmit('draft')"
                            class="flex-1 bg-purple-500 hover:bg-purple-600 text-white font-semibold py-3 rounded-lg transition duration-200 shadow-md">
                        Draft
                    </button>
                    <button type="button" onclick="window.location.href='{{ route('admin.dashboard') }}'"
                            class="flex-1 bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-lg transition duration-200 shadow-md">
                        Cancel
                    </button>
                </div>
            </form>
        </div>

        {{-- Draft Section --}}
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h3 class="text-2xl font-bold text-gray-700 mb-4">Draft</h3>
            <div class="grid md:grid-cols-2 gap-6">
                @forelse($drafts as $draft)
                <div class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                    @if($draft->gambar)
                        <img src="{{ asset('storage/'.$draft->gambar) }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-400">No Image</span>
                        </div>
                    @endif
                    <div class="p-4">
                        <h4 class="font-bold text-gray-800 mb-2">{{ $draft->title }}</h4>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $draft->deskripsi_singkat }}</p>
                        <div class="flex gap-2 mt-3">
                            <a href="{{ route('admin.blogs.edit', $draft->id_blog) }}" 
                               class="flex-1 bg-blue-500 hover:bg-blue-600 text-white text-center py-2 rounded text-sm transition">
                                Edit
                            </a>
                            <form action="{{ route('admin.blogs.destroy', $draft->id_blog) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin hapus draft ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded text-sm transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 col-span-2 text-center py-8">Belum ada draft</p>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($drafts->hasPages())
            <div class="flex justify-center gap-2 mt-6">
                @if($drafts->onFirstPage())
                    <span class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-200 text-gray-400">&lt;</span>
                @else
                    <a href="{{ $drafts->previousPageUrl() }}" 
                       class="w-10 h-10 rounded-full flex items-center justify-center bg-blue-500 text-white hover:bg-blue-600 transition">&lt;</a>
                @endif

                @foreach($drafts->getUrlRange(1, $drafts->lastPage()) as $page => $url)
                    <a href="{{ $url }}" 
                       class="w-10 h-10 rounded-full flex items-center justify-center {{ $page == $drafts->currentPage() ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-600 hover:bg-gray-300' }} transition">
                        {{ $page }}
                    </a>
                @endforeach

                @if($drafts->hasMorePages())
                    <a href="{{ $drafts->nextPageUrl() }}" 
                       class="w-10 h-10 rounded-full flex items-center justify-center bg-blue-500 text-white hover:bg-blue-600 transition">&gt;</a>
                @else
                    <span class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-200 text-gray-400">&gt;</span>
                @endif
            </div>
            @endif
        </div>

        {{-- Recent Artikel Section --}}
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-2xl font-bold text-gray-700 mb-4">Recent Artikel</h3>
            <div class="space-y-4">
                @forelse($recents as $recent)
                <div class="flex gap-4 bg-white border rounded-lg p-4 hover:shadow-md transition">
                    @if($recent->gambar)
                        <img src="{{ asset('storage/'.$recent->gambar) }}" class="w-32 h-32 object-cover rounded-lg flex-shrink-0">
                    @else
                        <div class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="text-gray-400 text-xs">No Image</span>
                        </div>
                    @endif
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800 mb-2">{{ $recent->title }}</h4>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $recent->deskripsi_singkat }}</p>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.blogs.edit', $recent->id_blog) }}" 
                               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded text-sm transition">
                                Edit
                            </a>
                            <form action="{{ route('admin.blogs.destroy', $recent->id_blog) }}" method="POST" onsubmit="return confirm('Yakin hapus artikel ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded text-sm transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-center py-8">Belum ada artikel terpublikasi</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi --}}
<div id="confirmModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4 shadow-2xl">
        <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">Pemberitahuan</h3>
        <p class="text-gray-600 text-center mb-6">Anda Yakin?</p>
        <div class="flex gap-4">
            <button onclick="closeModal()" 
                    class="flex-1 bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-lg transition">
                Cancel
            </button>
            <button onclick="submitForm()" 
                    class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition">
                Konfirmasi
            </button>
        </div>
    </div>
</div>

<script>
// Preview gambar
function previewImage(event) {
    const preview = document.getElementById('preview');
    preview.innerHTML = '';
    
    const file = event.target.files[0];
    if (file) {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.classList.add('max-h-48', 'mx-auto', 'rounded-lg', 'shadow-md');
        preview.appendChild(img);
    }
}

// Modal konfirmasi
let selectedStatus = '';

function confirmSubmit(status) {
    selectedStatus = status;
    document.getElementById('confirmModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('confirmModal').classList.add('hidden');
}

function submitForm() {
    document.getElementById('statusInput').value = selectedStatus;
    document.getElementById('blogForm').submit();
}

// Close modal saat klik di luar
document.getElementById('confirmModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endsection