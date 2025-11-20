@extends('layouts.admin')

@section('title', 'Pengelolaan Artikel')

@section('content')
<div class="w-full bg-gray-50 min-h-screen p-3 sm:p-4 md:p-6">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-6">Pengelolaan Blog</h2>

        {{-- Alert Success --}}
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-3 sm:px-4 py-2 sm:py-3 rounded mb-4 sm:mb-6 text-sm sm:text-base">
            {{ session('success') }}
        </div>
        @endif

        {{-- Form Tambah Artikel --}}
        <div class="bg-gradient-to-br from-blue-400 to-blue-500 rounded-lg shadow-lg p-4 sm:p-6 md:p-8 mb-6 sm:mb-8">
            <h3 class="text-xl sm:text-2xl font-semibold text-white mb-4 sm:mb-6">Form Tambah Artikel</h3>
            
            <form id="blogForm" action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 sm:space-y-5">
                @csrf

                {{-- Judul Artikel --}}
                <div>
                    <label class="block text-white font-medium mb-2 text-sm">Judul artikel</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                           class="w-full rounded-lg px-3 sm:px-4 py-2 sm:py-3 bg-white border-none focus:ring-2 focus:ring-white focus:ring-opacity-50 text-gray-800 text-sm sm:text-base" 
                           placeholder="Masukkan judul artikel..." required>
                    @error('title')
                        <span class="text-red-200 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Kategori dan Penulis --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                    <div>
                        <label class="block text-white font-medium mb-2 text-sm">Kategori Artikel</label>
                        <input type="text" name="kategori" value="{{ old('kategori') }}"
                               class="w-full rounded-lg px-3 sm:px-4 py-2 sm:py-3 bg-white border-none focus:ring-2 focus:ring-white focus:ring-opacity-50 text-gray-800 text-sm" 
                               placeholder="Tentang Mobil, Berita Perusahaan">
                    </div>
                    <div>
                        <label class="block text-white font-medium mb-2 text-sm">Penulis artikel</label>
                        <input type="text" name="penulis" value="{{ auth()->user()->name }}"
                               class="w-full rounded-lg px-3 sm:px-4 py-2 sm:py-3 bg-gray-200 border-none text-gray-700 text-sm" readonly>
                    </div>
                </div>

                {{-- Ringkasan Artikel --}}
                <div>
                    <label class="block text-white font-medium mb-2 text-sm">Ringkasan Artikel</label>
                    <textarea name="deskripsi_singkat" rows="3" 
                              class="w-full rounded-lg px-3 sm:px-4 py-2 sm:py-3 bg-white border-none focus:ring-2 focus:ring-white focus:ring-opacity-50 text-gray-800 resize-none text-sm" 
                              placeholder="Tulis ringkasan artikel..." required>{{ old('deskripsi_singkat') }}</textarea>
                    @error('deskripsi_singkat')
                        <span class="text-red-200 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Konten Artikel --}}
                <div>
                    <label class="block text-white font-medium mb-2 text-sm">Konten Artikel</label>
                    <textarea name="isi" rows="5"
                              class="w-full rounded-lg px-3 sm:px-4 py-2 sm:py-3 bg-white border-none focus:ring-2 focus:ring-white focus:ring-opacity-50 text-gray-800 resize-none text-sm" 
                              placeholder="Tulis konten artikel lengkap..." required>{{ old('isi') }}</textarea>
                    @error('isi')
                        <span class="text-red-200 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Upload Gambar --}}
                <div>
                    <label class="block text-white font-medium mb-2 text-sm">Gambar Utama</label>
                    <div class="bg-white rounded-lg p-4 sm:p-6 md:p-8 border-2 border-dashed border-blue-300 text-center hover:border-blue-400 transition">
                        <input type="file" name="gambar" id="gambar" class="hidden" accept="image/*" onchange="previewImage(event)">
                        <label for="gambar" class="cursor-pointer">
                            <div class="flex flex-col items-center justify-center gap-2 sm:gap-3">
                                <svg class="w-10 h-10 sm:w-12 sm:h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-blue-500 font-medium text-sm sm:text-base">Pilih gambar atau drag & drop</span>
                            </div>
                        </label>
                        <div id="preview" class="mt-3 sm:mt-4"></div>
                    </div>
                    @error('gambar')
                        <span class="text-red-200 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tags --}}
                <div>
                    <label class="block text-white font-medium mb-2 text-sm">Tags</label>
                    <input type="text" name="tags" value="{{ old('tags') }}"
                           class="w-full rounded-lg px-3 sm:px-4 py-2 sm:py-3 bg-white border-none focus:ring-2 focus:ring-white focus:ring-opacity-50 text-gray-800 text-sm" 
                           placeholder="Contoh: cuci mobil, tips berkendara">
                </div>

                {{-- Hidden status field --}}
                <input type="hidden" name="status" id="statusInput" value="">

                {{-- Tombol Aksi --}}
                <div class="grid grid-cols-3 gap-2 sm:gap-3 pt-3 sm:pt-4">
                    <button type="button" onclick="confirmSubmit('published')"
                            class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 sm:py-3 rounded-lg transition duration-200 shadow-md text-xs sm:text-sm">
                        Publish
                    </button>
                    <button type="button" onclick="confirmSubmit('draft')"
                            class="bg-purple-500 hover:bg-purple-600 text-white font-semibold py-2 sm:py-3 rounded-lg transition duration-200 shadow-md text-xs sm:text-sm">
                        Draft
                    </button>
                    <button type="button" onclick="window.location.href='{{ route('admin.dashboard') }}'"
                            class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 sm:py-3 rounded-lg transition duration-200 shadow-md text-xs sm:text-sm">
                        Delete
                    </button>
                </div>
            </form>
        </div>

        {{-- Draft Section --}}
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-6 sm:mb-8">
            <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 sm:mb-5">Draft</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                @forelse($drafts as $draft)
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                    @if($draft->gambar)
                        <img src="{{ asset('storage/'.$draft->gambar) }}" class="w-full h-36 sm:h-44 object-cover">
                    @else
                        <div class="w-full h-36 sm:h-44 bg-gray-100 flex items-center justify-center">
                            <span class="text-gray-400 text-sm">No Image</span>
                        </div>
                    @endif
                    <div class="p-3 sm:p-4">
                        <h4 class="font-bold text-gray-800 mb-2 text-sm sm:text-base line-clamp-2">{{ $draft->title }}</h4>
                        <p class="text-gray-600 text-xs sm:text-sm mb-3 sm:mb-4 line-clamp-2">{{ $draft->deskripsi_singkat }}</p>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('admin.blogs.edit', $draft->id_blog) }}" 
                               class="bg-blue-500 hover:bg-blue-600 text-white text-center py-2 rounded-md text-xs sm:text-sm font-medium transition">
                                Edit
                            </a>
                            <form action="{{ route('admin.blogs.destroy', $draft->id_blog) }}" method="POST" onsubmit="return confirm('Yakin hapus draft ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-md text-xs sm:text-sm font-medium transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 col-span-1 sm:col-span-2 text-center py-8 sm:py-12 text-sm">Belum ada draft</p>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($drafts->hasPages())
            <div class="flex justify-center items-center gap-1 sm:gap-2 mt-4 sm:mt-6 flex-wrap">
                <span class="text-gray-600 text-sm mr-1 sm:mr-2">&lt;</span>
                
                @foreach($drafts->getUrlRange(1, $drafts->lastPage()) as $page => $url)
                    <a href="{{ $url }}" 
                       class="w-8 h-8 sm:w-9 sm:h-9 rounded-full flex items-center justify-center text-xs sm:text-sm font-medium transition
                       {{ $page == $drafts->currentPage() ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        {{ $page }}
                    </a>
                @endforeach

                <span class="text-gray-600 text-sm ml-1 sm:ml-2">&gt;</span>
            </div>
            @endif
        </div>

        {{-- Recent Artikel Section --}}
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 sm:mb-5">Recent Artikel</h3>
            <div class="space-y-3 sm:space-y-4">
                @forelse($recents as $recent)
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 bg-white border border-gray-200 rounded-lg p-3 sm:p-4 hover:shadow-md transition">
                    @if($recent->gambar)
                        <img src="{{ asset('storage/'.$recent->gambar) }}" class="w-full sm:w-24 md:w-28 h-40 sm:h-24 md:h-28 object-cover rounded-lg flex-shrink-0">
                    @else
                        <div class="w-full sm:w-24 md:w-28 h-40 sm:h-24 md:h-28 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="text-gray-400 text-xs">No Image</span>
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-gray-800 mb-2 text-sm sm:text-base line-clamp-2">{{ $recent->title }}</h4>
                        <p class="text-gray-600 text-xs sm:text-sm mb-3 line-clamp-2">{{ $recent->deskripsi_singkat }}</p>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.blogs.edit', $recent->id_blog) }}" 
                               class="bg-blue-500 hover:bg-blue-600 text-white px-4 sm:px-5 py-1.5 rounded-md text-xs sm:text-sm font-medium transition">
                                Edit
                            </a>
                            <form action="{{ route('admin.blogs.destroy', $recent->id_blog) }}" method="POST" onsubmit="return confirm('Yakin hapus artikel ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 sm:px-5 py-1.5 rounded-md text-xs sm:text-sm font-medium transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-center py-8 sm:py-12 text-sm">Belum ada artikel terpublikasi</p>
                @endforelse
            </div>

            {{-- Pagination Recent --}}
            @if(isset($recents) && method_exists($recents, 'hasPages') && $recents->hasPages())
            <div class="flex justify-center items-center gap-1 sm:gap-2 mt-4 sm:mt-6 flex-wrap">
                <a href="{{ $recents->previousPageUrl() }}" 
                   class="w-8 h-8 sm:w-9 sm:h-9 rounded-full flex items-center justify-center text-xs sm:text-sm font-medium transition
                   {{ $recents->onFirstPage() ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-blue-500 text-white hover:bg-blue-600' }}">
                    &lt;
                </a>
                
                @foreach($recents->getUrlRange(1, $recents->lastPage()) as $page => $url)
                    <a href="{{ $url }}" 
                       class="w-8 h-8 sm:w-9 sm:h-9 rounded-full flex items-center justify-center text-xs sm:text-sm font-medium transition
                       {{ $page == $recents->currentPage() ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        {{ $page }}
                    </a>
                @endforeach

                <a href="{{ $recents->nextPageUrl() }}" 
                   class="w-8 h-8 sm:w-9 sm:h-9 rounded-full flex items-center justify-center text-xs sm:text-sm font-medium transition
                   {{ !$recents->hasMorePages() ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-blue-500 text-white hover:bg-blue-600' }}">
                    &gt;
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal Konfirmasi --}}
<div id="confirmModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl p-6 sm:p-8 max-w-md w-full shadow-2xl">
        <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-2 sm:mb-3 text-center">Pemberitahuan</h3>
        <p class="text-gray-600 text-center mb-6 sm:mb-8 text-sm sm:text-base">Anda Yakin?</p>
        <div class="grid grid-cols-2 gap-3 sm:gap-4">
            <button onclick="closeModal()" 
                    class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 sm:py-3 rounded-lg transition text-sm sm:text-base">
                Cancel
            </button>
            <button onclick="submitForm()" 
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 sm:py-3 rounded-lg transition text-sm sm:text-base">
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
        img.classList.add('max-h-32', 'sm:max-h-48', 'mx-auto', 'rounded-lg', 'shadow-md', 'mt-3');
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