@extends('layouts.user')

@section('title', 'Form Pendaftaran Cucicar')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-gray-700 mb-8 text-center">FORM PENDAFTARAN CUCICAR</h1>

        @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Section -->
            <div class="lg:col-span-2">
                <form id="bookingForm" action="{{ route('bookings.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Data Diri -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Data diri</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-600 mb-1">Nama Lengkap</label>
                                <input type="text" id="nama" name="nama" value="{{ old('nama', auth()->user()->name ?? '') }}" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama') border-red-500 @enderror" 
                                    required>
                                @error('nama')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="nomor_telepon" class="block text-sm font-medium text-gray-600 mb-1">Nomor Whatsapp</label>
                                    <input type="text" id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon') }}" 
                                        placeholder="08xxx" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nomor_telepon') border-red-500 @enderror" 
                                        required>
                                    @error('nomor_telepon')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                                    <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror" 
                                        required>
                                    @error('email')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="alamat" class="block text-sm font-medium text-gray-600 mb-1">Alamat Lengkap</label>
                                <textarea id="alamat" name="alamat" rows="2" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('alamat') border-red-500 @enderror" 
                                    required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Detail Kendaraan -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Detail Kendaraan</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="id_jenis_kendaraan" class="block text-sm font-medium text-gray-600 mb-1">Jenis Kendaraan</label>
                                <select id="id_jenis_kendaraan" name="id_jenis_kendaraan" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('id_jenis_kendaraan') border-red-500 @enderror" 
                                    required>
                                    <option value="">Pilih Jenis Kendaraan</option>
                                    @foreach($jenisKendaraans as $jenis)
                                    <option value="{{ $jenis->id_jenis_kendaraan }}" 
                                        data-harga="{{ $jenis->harga }}"
                                        {{ old('id_jenis_kendaraan') == $jenis->id_jenis_kendaraan ? 'selected' : '' }}>
                                        {{ $jenis->jenis_kendaraan }} {{ $jenis->nama_kendaraan ? '- ' . $jenis->nama_kendaraan : '' }} (Rp {{ number_format($jenis->harga, 0, ',', '.') }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('id_jenis_kendaraan')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nomor_polisi" class="block text-sm font-medium text-gray-600 mb-1">Nomor Polisi</label>
                                <input type="text" id="nomor_polisi" name="nomor_polisi" value="{{ old('nomor_polisi') }}" 
                                    placeholder="DK 2993 AH" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nomor_polisi') border-red-500 @enderror" 
                                    required>
                                @error('nomor_polisi')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Pilihan Penanganan -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Pilihan Penanganan</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="id_jenis_penanganan" class="block text-sm font-medium text-gray-600 mb-1">Jenis Penanganan</label>
                                <select id="id_jenis_penanganan" name="id_jenis_penanganan" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('id_jenis_penanganan') border-red-500 @enderror" 
                                    required>
                                    <option value="">Pilih Jenis Penanganan</option>
                                    @foreach($jenisPenanganans as $penanganan)
                                    <option value="{{ $penanganan->id_Tingkatan }}" 
                                        data-harga="{{ $penanganan->harga }}"
                                        {{ old('id_jenis_penanganan') == $penanganan->id_tingkatan ? 'selected' : '' }}>
                                        {{ $penanganan->Tingkatan }} (Rp {{ number_format($penanganan->harga, 0, ',', '.') }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('id_jenis_penanganan')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="id_Paket" class="block text-sm font-medium text-gray-600 mb-1">Paket Penanganan</label>
                                <select id="id_Paket" name="id_Paket" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('id_Paket') border-red-500 @enderror" 
                                    required>
                                    <option value="">Pilih Paket</option>
                                    @foreach($pakets as $paket)
                                    <option value="{{ $paket->id_Paket }}" 
                                        data-tingkatan="{{ $paket->id_Tingkatan }}"
                                        {{ old('id_Paket') == $paket->id_Paket ? 'selected' : '' }}>
                                        {{ $paket->kategori_paket }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('id_Paket')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="id_Addons" class="block text-sm font-medium text-gray-600 mb-1">Tambahan (Opsional)</label>
                            <select id="id_Addons" name="id_Addons" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Tanpa Addons</option>
                                @foreach($addons as $addon)
                                <option value="{{ $addon->id_addons }}" 
                                    data-harga="{{ $addon->harga }}"
                                    {{ old('id_Addons') == $addon->id_addons ? 'selected' : '' }}>
                                    {{ $addon->nama }} (Rp {{ number_format($addon->harga, 0, ',', '.') }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Pengaturan Jadwal -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Pengaturan Jadwal</h2>
                        
                        <div>
                            <label for="tanggal" class="block text-sm font-medium text-gray-600 mb-1">Tanggal Pencucian</label>
                            <input type="datetime-local" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" 
                                min="{{ date('Y-m-d\TH:i') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tanggal') border-red-500 @enderror" 
                                required>
                            @error('tanggal')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Informasi Tambahan -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Informasi Tambahan</h2>
                        
                        <div>
                            <label for="catatan" class="block text-sm font-medium text-gray-600 mb-1">Catatan Untuk Pegawai</label>
                            <textarea id="catatan" name="catatan" rows="3" 
                                placeholder="Tuliskan catatan khusus untuk pegawai (opsional)"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('catatan') }}</textarea>
                        </div>
                    </div>

                    <!-- Hidden fields -->
                    <input type="hidden" name="metode" value="cash">

                    <!-- Total & Submit -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-xl font-semibold text-gray-700">Total:</span>
                            <span id="totalPrice" class="text-3xl font-bold text-blue-600">Rp. 0</span>
                        </div>
                        
                        <button type="submit" 
                            class="w-full bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105">
                            Konfirmasi
                        </button>
                    </div>
                </form>
            </div>

            <!-- FAQ Section -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-8">
                    <h2 class="text-2xl font-semibold text-gray-700 mb-4">FAQ</h2>
                    
                    <div class="space-y-4">
                        <details class="group">
                            <summary class="cursor-pointer text-gray-600 font-medium hover:text-blue-600 transition">
                                Bagaimana cara pembayarannya?
                            </summary>
                            <p class="mt-2 text-sm text-gray-500 pl-4">
                                Pembayaran dapat dilakukan secara tunai saat service atau transfer ke rekening yang akan diberikan admin.
                            </p>
                        </details>

                        <details class="group">
                            <summary class="cursor-pointer text-gray-600 font-medium hover:text-blue-600 transition">
                                Bagaimana kalo saya memasukan data palsu?
                            </summary>
                            <p class="mt-2 text-sm text-gray-500 pl-4">
                                Harap mengisi data dengan benar agar admin dapat menghubungi Anda untuk konfirmasi jadwal.
                            </p>
                        </details>

                        <details class="group">
                            <summary class="cursor-pointer text-gray-600 font-medium hover:text-blue-600 transition">
                                Bagaimana saya tahu total harganya nanti?
                            </summary>
                            <p class="mt-2 text-sm text-gray-500 pl-4">
                                Total harga akan otomatis terhitung setelah Anda memilih jenis kendaraan, penanganan, dan addon.
                            </p>
                        </details>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">apabila ada hal yang perlu ditanyakan hubungi kami di Whatsapp</p>
                                <a href="https://wa.me/6289676372824" target="_blank" class="text-lg font-bold text-blue-600 hover:text-blue-700">
                                    089676372824
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-gradient-to-br from-blue-400 to-teal-400 mb-4">
                <img src="https://via.placeholder.com/100" alt="Success" class="h-16 w-16 rounded-full object-cover">
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">BERHASIL!</h3>
            <p class="text-sm text-gray-600 mb-4">Silahkan tunggu konfirmasi admin</p>
            <button onclick="closeModal()" 
                class="px-6 py-2 bg-blue-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                Konfirmasi
            </button>
        </div>
    </div>
</div>


<!-- Letakkan sebelum section setelah closing </div> terakhir -->

<script>
(function() {
    'use strict';
    
    console.log('=== SCRIPT STARTED ===');
    
    // Wait for DOM
    window.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded');
        
        // Get elements
        const jenisKendaraanSelect = document.getElementById('id_jenis_kendaraan');
        const jenisPenangananSelect = document.getElementById('id_jenis_penanganan');
        const paketSelect = document.getElementById('id_Paket');
        const addonsSelect = document.getElementById('id_Addons');
        const totalPriceEl = document.getElementById('totalPrice');
        
        // Debug: Check if elements exist
        console.log('Elements found:', {
            kendaraan: !!jenisKendaraanSelect,
            penanganan: !!jenisPenangananSelect,
            paket: !!paketSelect,
            addons: !!addonsSelect,
            totalPrice: !!totalPriceEl
        });
        
        if (!totalPriceEl) {
            console.error('Element totalPrice tidak ditemukan!');
            return;
        }
        
        // Calculate total function
        function calculateTotal() {
            let total = 0;
            console.log('=== Calculating Total ===');
            
            // Vehicle price
            if (jenisKendaraanSelect && jenisKendaraanSelect.value) {
                const opt = jenisKendaraanSelect.options[jenisKendaraanSelect.selectedIndex];
                const price = parseFloat(opt.getAttribute('data-harga')) || 0;
                console.log('Vehicle:', opt.text, '- Price:', price);
                total += price;
            }
            
            // Handling price
            if (jenisPenangananSelect && jenisPenangananSelect.value) {
                const opt = jenisPenangananSelect.options[jenisPenangananSelect.selectedIndex];
                const price = parseFloat(opt.getAttribute('data-harga')) || 0;
                console.log('Penanganan:', opt.text, '- Price:', price);
                total += price;
            }
            
            // Addons price
            if (addonsSelect && addonsSelect.value) {
                const opt = addonsSelect.options[addonsSelect.selectedIndex];
                const price = parseFloat(opt.getAttribute('data-harga')) || 0;
                console.log('Addons:', opt.text, '- Price:', price);
                total += price;
            }
            
            console.log('TOTAL:', total);
            
            // Update display
            totalPriceEl.textContent = 'Rp. ' + total.toLocaleString('id-ID');
            console.log('Display updated to:', totalPriceEl.textContent);
        }
        
        // Filter paket function
        function filterPaket() {
            if (!paketSelect || !jenisPenangananSelect) return;
            
            const selectedTingkatan = jenisPenangananSelect.value;
            const paketOptions = paketSelect.querySelectorAll('option');
            
            paketOptions.forEach(option => {
                if (option.value === '') {
                    option.style.display = 'block';
                    return;
                }
                
                if (option.getAttribute('data-tingkatan') === selectedTingkatan) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });
            
            // Reset if invalid
            const currentPaket = paketSelect.options[paketSelect.selectedIndex];
            if (currentPaket && currentPaket.value !== '' && 
                currentPaket.getAttribute('data-tingkatan') !== selectedTingkatan) {
                paketSelect.value = '';
            }
        }
        
        // Add event listeners
        if (jenisKendaraanSelect) {
            jenisKendaraanSelect.addEventListener('change', function() {
                console.log('Vehicle changed');
                calculateTotal();
            });
        }
        
        if (jenisPenangananSelect) {
            jenisPenangananSelect.addEventListener('change', function() {
                console.log('Penanganan changed');
                filterPaket();
                calculateTotal();
            });
        }
        
        if (addonsSelect) {
            addonsSelect.addEventListener('change', function() {
                console.log('Addons changed');
                calculateTotal();
            });
        }
        
        if (paketSelect) {
            paketSelect.addEventListener('change', function() {
                console.log('Paket changed');
            });
        }
        
        // Initial calculation
        console.log('Running initial calculation...');
        calculateTotal();
        
        console.log('=== SCRIPT READY ===');
    });
})();

// Modal functions
function showSuccessModal() {
    document.getElementById('successModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('successModal').classList.add('hidden');
    window.location.href = '/';
}
</script>
@endsection
