@extends('layouts.admin')

@section('title', 'Edit Artikel')

@section('content')
<div class="w-full p-6 bg-white rounded-xl shadow-md">

    {{-- Judul --}}
    <h2 class="text-2xl font-bold text-slate-700 mb-6">Edit Artikel</h2>

    {{-- Form Edit Artikel --}}
    <form action="{{ route('admin.blogs.update', $blog->id_blog) }}" method="POST" enctype="multipart/form-data"
          class="space-y-6 bg-sky-700 p-6 rounded-lg text-white">
        @csrf
        @method('PUT')

        {{-- Judul + Penulis --}}
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold mb-1">Judul Artikel</label>
                <input type="text" name="title" value="{{ old('title', $blog->title) }}"
                       class="w-full border rounded-lg px-3 py-2 text-black" required>
            </div>
            <div>
                <label class="block font-semibold mb-1">Penulis Artikel</label>
                <input type="text" name="penulis" value="{{ $blog->user->name ?? auth()->user()->name }}" 
                       class="w-full border rounded-lg px-3 py-2 text-black" readonly>
            </div>
        </div>

        {{-- Kategori --}}
        <div>
            <label class="block font-semibold mb-1">Kategori Artikel</label>
            <select name="kategori" class="w-full border rounded-lg px-3 py-2 text-black">
                <option value="Tips" {{ $blog->kategori == 'Tips' ? 'selected' : '' }}>Tips & Trik</option>
                <option value="Promo" {{ $blog->kategori == 'Promo' ? 'selected' : '' }}>Promo</option>
                <option value="Berita" {{ $blog->kategori == 'Berita' ? 'selected' : '' }}>Berita</option>
            </select>
        </div>

        {{-- Ringkasan --}}
        <div>
            <label class="block font-semibold mb-1">Ringkasan Artikel</label>
            <textarea name="deskripsi_singkat" rows="3" 
                      class="w-full border rounded-lg px-3 py-2 text-black" required>{{ old('deskripsi_singkat', $blog->deskripsi_singkat) }}</textarea>
        </div>

        {{-- Konten --}}
        <div>
            <label class="block font-semibold mb-1">Konten Artikel</label>
            <textarea name="isi" rows="6" 
                      class="w-full border rounded-lg px-3 py-2 text-black" required>{{ old('isi', $blog->isi) }}</textarea>
        </div>

        {{-- Upload Gambar --}}
        <div>
            <label class="block font-semibold mb-2">Gambar Utama</label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center bg-white">
                @if($blog->gambar)
                    <img src="{{ asset('storage/'.$blog->gambar) }}" class="max-h-48 mx-auto mb-3 rounded-lg shadow">
                @endif
                <input type="file" name="gambar" id="gambar" class="hidden" onchange="previewImage(event)">
                <label for="gambar" class="cursor-pointer text-blue-600 hover:underline">
                    Pilih gambar baru atau biarkan kosong
                </label>
                <div id="preview" class="mt-3"></div>
            </div>
        </div>

        {{-- Tags --}}
        <div>
            <label class="block font-semibold mb-1">Tags</label>
            <input type="text" name="tags" value="{{ old('tags', $blog->tags ?? '') }}"
                   placeholder="Contoh: cuci mobil, tips" 
                   class="w-full border rounded-lg px-3 py-2 text-black">
        </div>

        {{-- Tombol --}}
        <div class="flex space-x-3">
            <button type="submit" name="status" value="published"
                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Update & Publish</button>
            <button type="submit" name="status" value="draft"
                class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">Simpan Draft</button>
            <a href="{{ route('admin.blogs.index') }}"
                class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">Cancel</a>
        </div>
    </form>
</div>

{{-- JS Preview Gambar --}}
<script>
function previewImage(event) {
    let preview = document.getElementById('preview');
    preview.innerHTML = '';
    let file = event.target.files[0];
    if (file) {
        let img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.classList.add('max-h-48', 'mx-auto', 'rounded-lg', 'shadow');
        preview.appendChild(img);
    }
}
</script>
@endsection
