@extends('layouts.admin')
@section('title', 'About Us Management')

@section('content')

<div class="min-h-screen bg-gray-50 py-4 sm:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <!-- Header -->
        <div class="mb-6 sm:mb-10">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-800">SELAMAT DATANG DI ABOUT US!</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-4 sm:mb-6 flex items-center justify-between text-sm sm:text-base">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Form Tambah/Edit Artikel -->
        <div class="bg-blue-500 rounded-t-lg shadow-xl mb-6 sm:mb-10" id="formSection">
            <div class="bg-blue-600 px-4 sm:px-8 py-4 sm:py-5 rounded-t-lg">
                <h2 class="text-white text-lg sm:text-xl lg:text-2xl font-semibold" id="formTitle">Form Tambah About Us</h2>
            </div>
            
            <div class="bg-white p-4 sm:p-6 lg:p-8 rounded-b-lg">
                <form action="{{ route('admin.aboutus.store') }}" method="POST" id="mainForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="POST" id="formMethod">
                    
                    <div class="mb-4 sm:mb-6">
                        <label class="block text-gray-700 font-semibold mb-2 sm:mb-3 text-base sm:text-lg">Judul Artikel</label>
                        <input type="text" 
                               name="judul" 
                               id="inputJudul"
                               class="w-full px-3 sm:px-5 py-2 sm:py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-base sm:text-lg"
                               placeholder="Masukkan judul artikel"
                               required>
                    </div>

                    <div class="mb-4 sm:mb-6">
                        <label class="block text-gray-700 font-semibold mb-2 sm:mb-3 text-base sm:text-lg">Isi Konten</label>
                        <textarea name="isi" 
                                  id="inputIsi"
                                  rows="6" 
                                  class="w-full px-3 sm:px-5 py-2 sm:py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-base sm:text-lg"
                                  placeholder="Masukkan isi konten artikel"
                                  required></textarea>
                    </div>

                    <div class="mb-6 sm:mb-8">
                        <label class="block text-gray-700 font-semibold mb-2 sm:mb-3 text-base sm:text-lg">Gambar Utama</label>
                        <input type="file" 
                               name="foto" 
                               id="inputFoto" 
                               class="hidden" 
                               accept="image/*">
                        <div class="border-3 border-dashed border-blue-300 rounded-lg p-6 sm:p-8 lg:p-12 text-center bg-blue-50 cursor-pointer hover:bg-blue-100 transition"
                             id="uploadArea">
                            <div id="uploadPlaceholder">
                                <i class="fas fa-image text-4xl sm:text-5xl lg:text-7xl text-blue-400 mb-3 sm:mb-4 block"></i>
                                <p class="text-blue-600 font-semibold text-base sm:text-lg lg:text-xl">Pilih gambar atau drag & drop</p>
                                <p class="text-gray-500 text-sm sm:text-base mt-2">Format: JPG, PNG (Max 2MB)</p>
                            </div>
                            <div id="imagePreview" class="mt-4"></div>
                        </div>
                        <p class="text-xs sm:text-sm text-gray-500 mt-2 sm:mt-3" id="editNote" style="display: none;">Kosongkan jika tidak ingin mengubah gambar</p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                        <button type="submit" 
                                class="w-full sm:w-auto bg-green-500 hover:bg-green-600 text-white px-6 sm:px-10 py-2.5 sm:py-3 rounded-lg font-semibold transition text-base sm:text-lg shadow-md hover:shadow-lg">
                            <i class="fas fa-check mr-2"></i>Confirm
                        </button>
                        <button type="button" 
                                id="btnCancel"
                                class="w-full sm:w-auto bg-red-500 hover:bg-red-600 text-white px-6 sm:px-10 py-2.5 sm:py-3 rounded-lg font-semibold transition text-base sm:text-lg shadow-md hover:shadow-lg"
                                style="display: none;">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informasi Terakhir Section -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="border-b px-4 sm:px-8 py-4 sm:py-5">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Informasi Terakhir</h2>
            </div>
            <div class="p-4 sm:p-6 lg:p-8">
                @forelse($profils as $profil)
                <div class="bg-white border-2 border-gray-200 rounded-lg p-4 sm:p-6 lg:p-8 mb-6 sm:mb-8 hover:shadow-lg transition">
                    <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 lg:gap-8">
                        <!-- Image -->
                        <div class="flex-shrink-0 mx-auto sm:mx-0">
                            @if($profil->foto)
                                <img src="{{ asset('storage/' . $profil->foto) }}" 
                                     alt="{{ $profil->judul }}" 
                                     class="w-32 h-32 sm:w-36 sm:h-36 lg:w-40 lg:h-40 rounded-full object-cover border-4 border-gray-100 shadow-md">
                            @else
                                <div class="w-32 h-32 sm:w-36 sm:h-36 lg:w-40 lg:h-40 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center border-4 border-gray-100 shadow-md">
                                    <i class="fas fa-image text-3xl sm:text-4xl lg:text-5xl text-blue-400"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="flex-1">
                            <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mb-3 sm:mb-4 text-center sm:text-left">{{ $profil->judul }}</h3>
                            <p class="text-gray-600 text-sm sm:text-base lg:text-lg leading-relaxed whitespace-pre-line mb-4 sm:mb-6">{{ $profil->isi }}</p>
                            
                            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                                <button type="button" 
                                        class="btn-edit w-full sm:w-auto bg-yellow-400 hover:bg-yellow-500 text-gray-800 px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg font-semibold cursor-pointer transition shadow-md hover:shadow-lg text-sm sm:text-base text-center"
                                        data-id="{{ $profil->id }}"
                                        data-judul="{{ $profil->judul }}"
                                        data-isi="{{ $profil->isi }}"
                                        data-foto="{{ $profil->foto }}">
                                    <i class="fas fa-edit mr-2"></i> Edit
                                </button>
                                <form action="{{ route('admin.aboutus.destroy', $profil->id) }}" 
                                      method="POST" 
                                      class="w-full sm:w-auto"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full sm:w-auto bg-red-500 hover:bg-red-600 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg font-semibold transition shadow-md hover:shadow-lg text-sm sm:text-base">
                                        <i class="fas fa-trash mr-2"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="text-center py-12 sm:py-20">
                        <i class="fas fa-inbox text-6xl sm:text-7xl lg:text-8xl text-gray-300 mb-4 sm:mb-6"></i>
                        <p class="text-gray-500 text-lg sm:text-xl font-medium">Belum ada artikel.</p>
                        <p class="text-gray-400 text-base sm:text-lg mt-2">Silakan tambahkan artikel menggunakan form di atas.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('About Us Responsive loaded');
    
    const mainForm = document.getElementById('mainForm');
    const formTitle = document.getElementById('formTitle');
    const formMethod = document.getElementById('formMethod');
    const btnCancel = document.getElementById('btnCancel');
    const uploadArea = document.getElementById('uploadArea');
    const inputFoto = document.getElementById('inputFoto');
    const imagePreview = document.getElementById('imagePreview');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const editNote = document.getElementById('editNote');
    
    let isEditMode = false;
    
    // Upload area click
    uploadArea.addEventListener('click', function() {
        inputFoto.click();
    });
    
    // Preview image
    inputFoto.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                uploadPlaceholder.style.display = 'none';
                imagePreview.innerHTML = `
                    <div class="relative inline-block">
                        <img src="${e.target.result}" class="max-h-48 sm:max-h-56 lg:max-h-64 rounded-lg shadow-md">
                        <button type="button" 
                                class="btn-clear-img absolute -top-2 -right-2 sm:-top-3 sm:-right-3 bg-red-500 text-white rounded-full w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center hover:bg-red-600 shadow-lg transition text-sm">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                
                document.querySelector('.btn-clear-img')?.addEventListener('click', function(event) {
                    event.stopPropagation();
                    clearImagePreview();
                });
            }
            reader.readAsDataURL(file);
        }
    });
    
    function clearImagePreview() {
        inputFoto.value = '';
        imagePreview.innerHTML = '';
        uploadPlaceholder.style.display = 'block';
    }
    
    function resetForm() {
        mainForm.reset();
        mainForm.action = "{{ route('admin.aboutus.store') }}";
        formMethod.value = 'POST';
        formTitle.textContent = 'Form Tambah About Us';
        btnCancel.style.display = 'none';
        editNote.style.display = 'none';
        clearImagePreview();
        isEditMode = false;
        
        // Scroll to form
        document.getElementById('formSection').scrollIntoView({ behavior: 'smooth' });
    }
    
    // Cancel button
    btnCancel.addEventListener('click', function() {
        resetForm();
    });
    
    // Edit buttons
    document.querySelectorAll('.btn-edit').forEach(function(button) {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const judul = this.getAttribute('data-judul');
            const isi = this.getAttribute('data-isi');
            const foto = this.getAttribute('data-foto');
            
            // Set form to edit mode
            isEditMode = true;
            mainForm.action = `/admin/aboutus/${id}`;
            formMethod.value = 'PUT';
            formTitle.textContent = 'Form Edit About Us';
            btnCancel.style.display = 'inline-block';
            editNote.style.display = 'block';
            
            // Fill form
            document.getElementById('inputJudul').value = judul;
            document.getElementById('inputIsi').value = isi;
            
            // Show current image if exists
            if (foto) {
                uploadPlaceholder.style.display = 'none';
                imagePreview.innerHTML = `
                    <div class="text-center">
                        <img src="/storage/${foto}" class="max-h-48 sm:max-h-56 lg:max-h-64 rounded-lg shadow-md mx-auto mb-2">
                        <p class="text-xs sm:text-sm text-gray-500 mt-2">Gambar saat ini</p>
                    </div>
                `;
            } else {
                clearImagePreview();
            }
            
            // Scroll to form
            document.getElementById('formSection').scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
    
    // Drag & drop (only for larger screens)
    if (window.innerWidth >= 768) {
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('border-blue-500', 'bg-blue-100');
        });
        
        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('border-blue-500', 'bg-blue-100');
        });
        
        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-blue-500', 'bg-blue-100');
            
            const files = e.dataTransfer.files;
            if (files.length > 0 && files[0].type.startsWith('image/')) {
                inputFoto.files = files;
                inputFoto.dispatchEvent(new Event('change'));
            }
        });
    }
});
</script>

@endsection
