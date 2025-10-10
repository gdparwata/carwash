@extends('layouts.admin')

@section('title', 'Data Booking')

@push('styles')
<style>
    .modal-fade-in {
        animation: fadeIn 0.2s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="ml-44 p-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow p-6 mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-700">Data Booking</h2>
            <div class="flex gap-2">
                <button onclick="viewUnassignedBookings()" class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600">
                    <span id="unassigned-badge" class="hidden bg-red-500 text-white rounded-full px-2 py-1 text-xs mr-2"></span>
                    Booking Menunggu Pegawai
                </button>
                <button onclick="openCreateModal()" class="bg-teal-500 text-white px-6 py-2 rounded-lg hover:bg-teal-600">
                    Create New data
                </button>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-gradient-to-r from-teal-400 to-teal-500 rounded-lg shadow p-6 mb-6">
            <form method="GET" action="{{ route('admin.bookings.index') }}" class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-white text-sm mb-2">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" 
                           class="w-full px-4 py-2 rounded-lg border-0">
                </div>
                <div class="flex-1">
                    <label class="block text-white text-sm mb-2">Kategori booking</label>
                    <select name="kategori" class="w-full px-4 py-2 rounded-lg border-0">
                        <option value="">Sudah Selesai</option>
                        <option value="InProgres" {{ request('kategori') == 'InProgres' ? 'selected' : '' }}>In Progress</option>
                        <option value="Done" {{ request('kategori') == 'Done' ? 'selected' : '' }}>Done</option>
                        <option value="Canceled" {{ request('kategori') == 'Canceled' ? 'selected' : '' }}>Canceled</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-teal-700 text-white px-8 py-2 rounded-lg hover:bg-teal-800">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-3 gap-6 mb-6">
            <div class="bg-gradient-to-br from-teal-300 to-teal-400 rounded-lg shadow p-6 text-white">
                <h3 class="text-sm mb-2">Total Booking</h3>
                <p class="text-4xl font-bold">{{ $totalBooking }}</p>
            </div>
            <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg shadow p-6 text-white">
                <h3 class="text-sm mb-2">Booking Belum Selesai</h3>
                <p class="text-4xl font-bold">{{ $bookingBelumSelesai }}</p>
            </div>
            <div class="bg-gradient-to-br from-teal-300 to-teal-400 rounded-lg shadow p-6 text-white">
                <h3 class="text-sm mb-2">Booking Selesai</h3>
                <p class="text-4xl font-bold">{{ $bookingSelesai }}</p>
            </div>
        </div>

        <!-- Booking List -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-700">Booking Tanggal {{ request('tanggal') ?? date('d-m-Y') }}</h3>
                <button onclick="location.reload()" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    🔄 Refresh
                </button>
            </div>

@foreach($bookings as $booking)
<div class="bg-gradient-to-r from-teal-100 to-teal-200 rounded-lg p-6 mb-4">
    <div class="flex justify-between items-start">
        <div>
            <h4 class="text-xl font-bold text-gray-700">
                {{ $booking->jenisKendaraan->nama_kendaraan ?? 'Mobil' }} 
                ({{ $booking->jenisKendaraan->jenis_kendaraan ?? 'Kendaraan' }})
            </h4>
            <p class="text-sm text-gray-600">{{ $booking->email }}</p>
            
            {{-- Badge Penugasan Pegawai - FIXED: gunakan accessor --}}
            @if($booking->needs_pegawai_assignment)
                <span class="text-xs bg-orange-100 text-orange-800 px-2 py-1 rounded mt-1 inline-block">
                    ⚠️ Menunggu Penugasan Pegawai
                </span>
            @endif
            
            {{-- Badge Tipe Booking - FIXED: gunakan accessor --}}
            @if($booking->is_user_booking)
                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded mt-1 inline-block">
                    💳 User Booking - Belum Bayar
                </span>
            @else
                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded mt-1 inline-block">
                    ✓ Admin Booking - Sudah Bayar
                </span>
            @endif
            
            <p class="text-2xl font-bold text-gray-800 mt-2">
                RP. {{ number_format($booking->harga ?? 0, 0, ',', '.') }}
            </p>
        </div>
        <div class="flex gap-2">
            {{-- Tombol View --}}
            <button onclick="openViewModal({{ $booking->id_Booking }})" 
                    class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
                view
            </button>
            
            {{-- Tombol Pilih Pegawai - FIXED: gunakan accessor --}}
            @if($booking->needs_pegawai_assignment)
                <button onclick="openAssignPegawaiModal({{ $booking->id_Booking }}, '{{ $booking->tanggal }}')" 
                        class="bg-purple-500 text-white px-6 py-2 rounded-lg hover:bg-purple-600 transition">
                    Pilih Pegawai
                </button>
            @endif
            
            {{-- Kondisi berdasarkan status --}}
            @if($booking->status === 'Done')
                {{-- Jika Done: Tombol View Invoice + Badge Done --}}
                <button onclick="viewInvoiceFromList({{ $booking->id_Booking }})" 
                        class="bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700 transition">
                    View Invoice
                </button>
                <span class="bg-purple-500 text-white px-6 py-2 rounded-lg flex items-center">
                    Done
                </span>
            @elseif($booking->status === 'Canceled')
                {{-- Jika Canceled: Tombol Message + Badge Canceled --}}
                <button onclick="openMessageModal({{ $booking->id_Booking }}, '{{ $booking->email }}', '{{ $booking->nomor_telepon }}')" 
                        class="bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700 transition">
                    Message
                </button>
                <span class="bg-red-500 text-white px-6 py-2 rounded-lg flex items-center">
                    Canceled
                </span>
            @else
                {{-- Jika InProgres: Tombol Message + Dropdown Status --}}
                <button onclick="openMessageModal({{ $booking->id_Booking }}, '{{ $booking->email }}', '{{ $booking->nomor_telepon }}')" 
                        class="bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700 transition">
                    Message
                </button>
                <div class="relative inline-block">
                    <button onclick="event.stopPropagation(); toggleStatusDropdown({{ $booking->id_Booking }})" 
                            class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 flex items-center gap-2 transition">
                        {{ $booking->status }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="status-dropdown-{{ $booking->id_Booking }}" 
                         class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl z-50 border border-gray-200">
                        @php
                            // FIXED: gunakan accessor
                            $isUserBooking = $booking->is_user_booking ? 'true' : 'false';
                        @endphp
                        <button onclick="event.stopPropagation(); updateStatus({{ $booking->id_Booking }}, 'Done', {{ $isUserBooking }})" 
                                class="block w-full text-left px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-t-lg transition">
                            ✓ Done
                        </button>
                        <button onclick="event.stopPropagation(); updateStatus({{ $booking->id_Booking }}, 'Canceled', false)" 
                                class="block w-full text-left px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-b-lg transition">
                            ✗ Canceled
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endforeach
            <!-- Pagination -->
            <div class="flex justify-center items-center gap-2 mt-6">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
</div>
{{-- BAGIAN MODALS & SCRIPTS - Taruh setelah closing </div> dari booking list --}}

<!-- Modal Create/Edit Booking -->
<div id="dataModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 overflow-y-auto">
    <div class="bg-white rounded-lg p-8 w-full max-w-4xl max-h-[90vh] overflow-y-auto my-8">
        <h3 class="text-2xl font-bold text-gray-700 mb-6" id="modalTitle">Data diri</h3>
        <form id="bookingForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <!-- Data Diri -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" required
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 mb-2">Nomor Whatsapp</label>
                    <input type="text" name="nomor_telepon" id="nomor_telepon" required
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" id="email" required
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Alamat Lengkap</label>
                <input type="text" name="alamat" id="alamat" required
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>
            
         <!-- Detail Kendaraan -->
<h4 class="text-xl font-bold text-gray-700 mb-4">Detail Kendaraan</h4>
<div class="grid grid-cols-2 gap-4 mb-6">
    <div>
        <label class="block text-gray-700 mb-2">Jenis Kendaraan</label>
        <select name="id_jenis_kendaraan" id="id_jenis_kendaraan" required 
                onchange="calculateTotal()"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            <option value="">Pilih</option>
            @foreach($jenisKendaraans as $jenis)
            <option value="{{ $jenis->id_jenis_kendaraan }}" data-price="{{ $jenis->harga ?? 0 }}">
                {{ $jenis->jenis_kendaraan }}
                @if($jenis->harga)
                    (+Rp {{ number_format($jenis->harga, 0, ',', '.') }})
                @endif
            </option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-gray-700 mb-2">Nomor Polisi</label>
        <input type="text" name="nomor_polisi" id="nomor_polisi" placeholder="DK 5984 AH"
               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
    </div>
</div>
            <!-- Pilihan Penanganan -->
            <h4 class="text-xl font-bold text-gray-700 mb-4">Pilihan Penanganan</h4>
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 mb-2">Jenis Penanganan</label>
                    <select name="id_Paket" id="id_Paket" required onchange="loadPaketPenanganan()"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="">Pilih Jenis Penanganan</option>
                        @foreach($pakets as $paket)
                        <option value="{{ $paket->id_Paket }}">
                            {{ $paket->kategori_paket }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Paket Penanganan</label>
                    <select name="id_jenis_penanganan" id="id_jenis_penanganan" required onchange="calculateTotal()"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="">Pilih paket dulu</option>
                        @foreach($tingkatans as $tingkatan)
                        <option value="{{ $tingkatan->id_Tingkatan }}" data-price="{{ $tingkatan->harga }}">
                            {{ $tingkatan->Tingkatan }} - Rp {{ number_format($tingkatan->harga, 0, ',', '.') }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <!-- Addons Section -->
            <div class="mb-6">
                <label class="block text-gray-700 mb-2 font-semibold">Tambahan Layanan (Addons)</label>
                <select name="id_Addons" id="id_Addons" onchange="calculateTotal()"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Tidak Ada --</option>
                    @foreach($addons as $addon)
                    <option value="{{ $addon->id_addons }}" data-price="{{ $addon->harga }}">
                        {{ $addon->nama }} (+Rp {{ number_format($addon->harga, 0, ',', '.') }})
                    </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Pengaturan Jadwal -->
            <h4 class="text-xl font-bold text-gray-700 mb-4">Pengaturan Jadwal</h4>
            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Tanggal Pencucian</label>
                <input type="datetime-local" name="tanggal" id="tanggal" required onchange="loadAvailablePegawai()"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>
            
            <!-- Informasi Tambahan -->
            <h4 class="text-xl font-bold text-gray-700 mb-4">Informasi Tambahan</h4>
            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Catatan Untuk Pegawai</label>
                <textarea name="catatan" id="catatan"
                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"></textarea>
            </div>
            
            <!-- Handle Admin -->
            <h4 class="text-xl font-bold text-gray-700 mb-4">Handle (Admin)</h4>
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 mb-2">Pegawai</label>
                    <select name="id_Pegawai" id="id_Pegawai" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="">Pilih tanggal dulu</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1" id="pegawai-info"></p>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Admin</label>
                    <input type="text" value="Anda" readonly
                           class="w-full px-4 py-2 border rounded-lg bg-gray-100">
                </div>
            </div>

            <!-- PAYMENT SECTION -->
            <div class="border-t-2 pt-6 mt-6">
                <h4 class="text-xl font-bold text-gray-700 mb-4">Informasi Pembayaran</h4>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 mb-2">Metode Pembayaran</label>
                        <select name="metode" id="metode" required onchange="toggleDiskonField()"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                            <option value="">Pilih Metode</option>
                            <option value="Tunai">Tunai</option>
                            <option value="Non Tunai">Non Tunai</option>
                        </select>
                    </div>
                    <div id="diskonField" style="display: none;">
                        <label class="block text-gray-700 mb-2">Diskon (Opsional)</label>
                        <select name="id_Diskon" id="diskon" onchange="calculateTotal()"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                            <option value="">Tanpa Diskon</option>
                            @foreach($diskons as $diskon)
                            <option value="{{ $diskon->id_Diskon }}" data-persen="{{ $diskon->persen }}">
                                {{ $diskon->nama }} - {{ $diskon->persen }}%
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4" id="jumlahUangField" style="display: none;">
                    <div>
                        <label class="block text-gray-700 mb-2">Jumlah Uang</label>
                        <input type="number" name="jumlah_uang" id="jumlah_uang" oninput="calculateKembalian()"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2">Kembalian</label>
                        <input type="number" name="kembalian" id="kembalian" readonly
                               class="w-full px-4 py-2 border rounded-lg bg-gray-100 cursor-not-allowed text-green-600 font-bold">
                    </div>
                </div>

                <div class="mt-4 p-4 bg-teal-50 rounded-lg">
                    <p class="text-lg font-bold text-gray-700">Total Harga: <span id="totalHarga">Rp 0</span></p>
                </div>
            </div>
            
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeModal('dataModal')" 
                        class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                    Batal
                </button>
                <button type="submit" class="bg-teal-500 text-white px-6 py-2 rounded-lg hover:bg-teal-600">
                    Konfirmasi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Assign Pegawai -->
<div id="assignPegawaiModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-8 w-full max-w-md">
        <h3 class="text-2xl font-bold text-gray-700 mb-6">Pilih Pegawai</h3>
        <form id="assignPegawaiForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Pegawai Tersedia</label>
                <select name="id_pegawai" id="assign_id_pegawai" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">Loading...</option>
                </select>
                <p class="text-xs text-gray-500 mt-1" id="assign-pegawai-info"></p>
            </div>
            
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('assignPegawaiModal')" 
                        class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                    Batal
                </button>
                <button type="submit" class="bg-teal-500 text-white px-6 py-2 rounded-lg hover:bg-teal-600">
                    Tugaskan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Payment (untuk user booking yang diubah ke Done) -->
<div id="paymentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-8 w-full max-w-md">
        <h3 class="text-2xl font-bold text-gray-700 mb-6">Metode</h3>
        <form id="paymentForm" method="POST">
            @csrf
            <input type="hidden" name="status" value="Done">
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Jumlah Harga</label>
                <input type="text" id="payment_harga" readonly
                       class="w-full px-4 py-2 border rounded-lg bg-gray-100">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Metode</label>
                <select name="metode" id="payment_metode" required onchange="togglePaymentDiskon()"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">Pilih Metode</option>
                    <option value="Tunai">Tunai</option>
                    <option value="Non Tunai">Non Tunai</option>
                </select>
            </div>
            
            <div class="mb-4" id="payment_diskon_field" style="display: none;">
                <label class="block text-gray-700 mb-2">Diskon</label>
                <select name="id_diskon" id="payment_diskon" onchange="calculatePaymentTotal()"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">Tanpa Diskon</option>
                    @foreach($diskons as $diskon)
                    <option value="{{ $diskon->id_Diskon }}" data-persen="{{ $diskon->persen }}">
                        {{ $diskon->nama }} - {{ $diskon->persen }}%
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-4" id="payment_jumlah_field" style="display: none;">
                <label class="block text-gray-700 mb-2">Jumlah Uang</label>
                <input type="number" name="jumlah_uang" id="payment_jumlah_uang" oninput="calculatePaymentKembalian()"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>
            
            <div class="mb-4" id="payment_kembalian_field" style="display: none;">
                <label class="block text-gray-700 mb-2">Kembalian</label>
                <input type="number" id="payment_kembalian" readonly
                       class="w-full px-4 py-2 border rounded-lg bg-gray-100 text-green-600 font-bold">
            </div>
            
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('paymentModal')" 
                        class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                    Batal
                </button>
                <button type="submit" class="bg-teal-500 text-white px-6 py-2 rounded-lg hover:bg-teal-600">
                    Konfirmasi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Message -->
<div id="messageModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-8 w-full max-w-md">
        <h3 class="text-2xl font-bold text-gray-700 mb-6">Massage</h3>
        <form id="messageForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Email</label>
                <div class="relative">
                    <input type="email" name="email" id="msg_email" required
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <button type="button" class="absolute right-2 top-2 text-gray-400">📋</button>
                </div>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Whatsapp</label>
                <div class="relative">
                    <input type="text" name="whatsapp" id="msg_whatsapp" required
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <button type="button" class="absolute right-2 top-2 text-gray-400">📋</button>
                </div>
            </div>
            
            <div class="flex justify-end">
                <button type="button" onclick="closeModal('messageModal')" 
                        class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 mr-2">
                    Batal
                </button>
                <button type="submit" class="bg-teal-500 text-white px-6 py-2 rounded-lg hover:bg-teal-600">
                    Konfirmasi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal View -->
<div id="viewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-8 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <h3 class="text-2xl font-bold text-gray-700 mb-6">Detail Booking</h3>
        <div id="viewContent" class="mb-6">
            <!-- Content will be loaded dynamically -->
        </div>
        <div class="flex justify-between mt-6">
            <button onclick="closeModal('viewModal')" 
                    class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                Tutup
            </button>
            <div class="flex gap-2" id="viewModalActions">
                <!-- Actions will be loaded dynamically -->
            </div>
        </div>
    </div>
</div>

<!-- Modal Unassigned Bookings -->
<div id="unassignedModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-8 w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        <h3 class="text-2xl font-bold text-gray-700 mb-6">Booking Menunggu Penugasan Pegawai</h3>
        <div id="unassignedContent" class="mb-6">
            <!-- Content will be loaded dynamically -->
        </div>
        <div class="flex justify-end mt-6">
            <button onclick="closeModal('unassignedModal')" 
                    class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
let currentBookingId = null;
let currentBookingHarga = 0;

// Load available pegawai when date changes
function loadAvailablePegawai() {
    const tanggal = document.getElementById('tanggal').value;
    const pegawaiSelect = document.getElementById('id_Pegawai');
    const pegawaiInfo = document.getElementById('pegawai-info');
    
    if (!tanggal) {
        pegawaiSelect.innerHTML = '<option value="">Pilih tanggal dulu</option>';
        pegawaiInfo.textContent = '';
        return;
    }
    
    pegawaiSelect.innerHTML = '<option value="">Loading...</option>';
    pegawaiInfo.textContent = 'Memuat data pegawai...';
    
    console.log('=== LOAD AVAILABLE PEGAWAI ===');
    console.log('Tanggal:', tanggal);
    
    fetch('/api/available-pegawai', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ tanggal: tanggal })
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        
        if (data.success) {
            pegawaiSelect.innerHTML = '<option value="">Pilih Pegawai</option>';
            
            if (data.data.length === 0) {
                pegawaiSelect.innerHTML = '<option value="">Tidak ada pegawai tersedia</option>';
                pegawaiInfo.textContent = `⚠️ Semua pegawai libur pada hari ${data.hari}`;
                pegawaiInfo.classList.add('text-red-500');
                console.warn('Tidak ada pegawai tersedia!');
            } else {
                console.log('Pegawai tersedia:', data.data.length);
                data.data.forEach((pegawai, index) => {
                    console.log(`${index + 1}. ${pegawai.nama} (ID: ${pegawai.id_Pegawai})`);
                    const option = document.createElement('option');
                    option.value = pegawai.id_Pegawai;
                    option.textContent = pegawai.nama;
                    pegawaiSelect.appendChild(option);
                });
                pegawaiInfo.textContent = `✓ Tersedia ${data.data.length} pegawai pada hari ${data.hari}`;
                pegawaiInfo.classList.remove('text-red-500');
                pegawaiInfo.classList.add('text-green-600');
            }
            
            if (data.debug) {
                console.log('Debug info:', data.debug);
            }
        } else {
            console.error('Error:', data.message);
            pegawaiSelect.innerHTML = '<option value="">Error loading data</option>';
            pegawaiInfo.textContent = '❌ ' + (data.message || 'Gagal memuat data');
            pegawaiInfo.classList.add('text-red-500');
            alert(data.message || 'Gagal memuat data pegawai');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        pegawaiSelect.innerHTML = '<option value="">Error loading pegawai</option>';
        pegawaiInfo.textContent = '❌ Terjadi kesalahan koneksi';
        pegawaiInfo.classList.add('text-red-500');
        alert('Terjadi kesalahan: ' + error.message);
    });
}

// Calculate total price
// Calculate total price - FIXED VERSION
function calculateTotal() {
    console.log('=== CALCULATE TOTAL CALLED ===');
    
    const jenisKendaraanSelect = document.getElementById('id_jenis_kendaraan');
    const tingkatanSelect = document.getElementById('id_jenis_penanganan');
    const addonsSelect = document.getElementById('id_Addons');
    const diskonSelect = document.getElementById('diskon');
    const metodeSelect = document.getElementById('metode');
    
    // Get jenis kendaraan price
    let jenisKendaraanPrice = 0;
    if (jenisKendaraanSelect.value) {
        const selectedOption = jenisKendaraanSelect.selectedOptions[0];
        jenisKendaraanPrice = parseInt(selectedOption?.dataset.price || 0);
    }
    console.log('Jenis Kendaraan Price:', jenisKendaraanPrice);
    
    // Get tingkatan price
    let tingkatanPrice = 0;
    if (tingkatanSelect.value) {
        const selectedOption = tingkatanSelect.selectedOptions[0];
        tingkatanPrice = parseInt(selectedOption?.dataset.price || 0);
    }
    console.log('Tingkatan Price:', tingkatanPrice);
    
    // Get addons price
    let addonsPrice = 0;
    if (addonsSelect.value) {
        const selectedOption = addonsSelect.selectedOptions[0];
        addonsPrice = parseInt(selectedOption?.dataset.price || 0);
    }
    console.log('Addons Price:', addonsPrice);
    
    // Calculate subtotal
    let total = jenisKendaraanPrice + tingkatanPrice + addonsPrice;
    console.log('Subtotal (before discount):', total);
    
    // Apply discount only if Tunai
    if (metodeSelect.value === 'Tunai' && diskonSelect.value) {
        const diskonPersen = parseInt(diskonSelect.selectedOptions[0]?.dataset.persen || 0);
        const diskonAmount = (total * diskonPersen) / 100;
        total = total - diskonAmount;
        console.log('Discount:', diskonPersen + '%', '(Rp ' + diskonAmount.toLocaleString('id-ID') + ')');
    }
    
    console.log('Final Total:', total);
    console.log('=== END CALCULATE ===');
    
    document.getElementById('totalHarga').textContent = 'Rp ' + total.toLocaleString('id-ID');
    calculateKembalian();
}

function calculateKembalian() {
    const totalText = document.getElementById('totalHarga').textContent;
    const total = parseInt(totalText.replace(/[^0-9]/g, ''));
    const jumlahUang = parseInt(document.getElementById('jumlah_uang').value || 0);
    const kembalian = jumlahUang - total;
    document.getElementById('kembalian').value = kembalian > 0 ? kembalian : 0;
}

function toggleDiskonField() {
    const metode = document.getElementById('metode').value;
    const diskonField = document.getElementById('diskonField');
    const jumlahUangField = document.getElementById('jumlahUangField');
    
    if (metode === 'Tunai') {
        diskonField.style.display = 'block';
        jumlahUangField.style.display = 'grid';
    } else {
        diskonField.style.display = 'none';
        jumlahUangField.style.display = 'none';
        document.getElementById('diskon').value = '';
        document.getElementById('jumlah_uang').value = '';
        document.getElementById('kembalian').value = '';
    }
    calculateTotal();
}

function loadPaketPenanganan() {
    calculateTotal();
}
function openCreateModal() {
    document.getElementById('modalTitle').textContent = 'Data diri';
    document.getElementById('bookingForm').action = '{{ route("admin.bookings.store") }}';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('bookingForm').reset();
    document.getElementById('id_Pegawai').innerHTML = '<option value="">Pilih tanggal dulu</option>';
    document.getElementById('totalHarga').textContent = 'Rp 0';
    document.getElementById('dataModal').classList.remove('hidden');
}

function openViewModal(id) {
    currentBookingId = id;
    
    console.log('=== OPENING VIEW MODAL ===');
    console.log('Booking ID:', id);
    console.log('Fetch URL:', `/admin/bookings/${id}/details`);
    
    fetch(`/admin/bookings/${id}/details`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        return response.json();
    })
    .then(data => {
        console.log('=== BOOKING DATA RECEIVED ===');
        console.log('Full data:', data);
        console.log('Paket:', data.paket);
        console.log('Pegawai:', data.pegawai);
        console.log('Addons:', data.addons);
        console.log('Jenis Kendaraan:', data.jenis_kendaraan);
        
        const content = `
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Nama</p>
                    <p class="font-bold">${data.nama || '-'}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="font-bold">${data.email || '-'}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Nomor Telepon</p>
                    <p class="font-bold">${data.nomor_telepon || '-'}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Alamat</p>
                    <p class="font-bold">${data.alamat || '-'}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Nomor Polisi</p>
                    <p class="font-bold">${data.nomor_polisi || '-'}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Status</p>
                    <p class="font-bold ${data.status === 'Done' ? 'text-green-600' : data.status === 'Canceled' ? 'text-red-600' : 'text-orange-600'}">${data.status || '-'}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Jenis Kendaraan</p>
                    <p class="font-bold">${data.jenis_kendaraan ? data.jenis_kendaraan.jenis_kendaraan : '-'}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Paket</p>
                    <p class="font-bold">${data.paket ? data.paket.kategori_paket : '-'}</p>
                    ${data.paket && data.paket.tingkatan ? `<p class="text-sm text-gray-500">${data.paket.tingkatan.tingkatan}</p>` : ''}
                </div>
                <div>
                    <p class="text-sm text-gray-600">Tanggal</p>
                    <p class="font-bold">${data.tanggal ? new Date(data.tanggal).toLocaleString('id-ID') : '-'}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Harga</p>
                    <p class="font-bold text-teal-600">Rp ${data.harga ? new Intl.NumberFormat('id-ID').format(data.harga) : '0'}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Pegawai</p>
                    <p class="font-bold ${data.pegawai ? 'text-green-600' : 'text-orange-600'}">
                        ${data.pegawai ? '✓ ' + data.pegawai.nama : '⚠️ Belum Ditugaskan'}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Addons</p>
                    <p class="font-bold">${data.addons ? data.addons.nama + ' (+Rp ' + new Intl.NumberFormat('id-ID').format(data.addons.harga) + ')' : 'Tidak Ada'}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-600">Catatan</p>
                    <p class="font-bold">${data.catatan || 'Tidak ada catatan'}</p>
                </div>
                ${data.metode ? `
                <div>
                    <p class="text-sm text-gray-600">Metode Pembayaran</p>
                    <p class="font-bold">${data.metode}</p>
                </div>
                ` : ''}
                ${data.diskon && data.diskon > 0 ? `
                <div>
                    <p class="text-sm text-gray-600">Diskon</p>
                    <p class="font-bold text-green-600">${data.diskon}%</p>
                </div>
                ` : ''}
            </div>
        `;
        document.getElementById('viewContent').innerHTML = content;
        
        const actionsDiv = document.getElementById('viewModalActions');
        if (data.status === 'Done') {
            actionsDiv.innerHTML = `
                <button onclick="viewInvoice()" 
                        class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
                    View Invoice
                </button>
            `;
        } else {
            actionsDiv.innerHTML = '';
        }
        
        console.log('Modal content updated successfully');
        document.getElementById('viewModal').classList.remove('hidden');
    })
    .catch(error => {
        console.error('=== ERROR ===');
        console.error('Error:', error);
        console.error('Stack:', error.stack);
        alert('Gagal memuat detail booking: ' + error.message);
    });
}

function openAssignPegawaiModal(bookingId, tanggal) {
    currentBookingId = bookingId;
    
    const select = document.getElementById('assign_id_pegawai');
    select.innerHTML = '<option value="">Loading...</option>';
    
    fetch('/api/available-pegawai', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ tanggal: tanggal })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            select.innerHTML = '<option value="">Pilih Pegawai</option>';
            data.data.forEach(pegawai => {
                const option = document.createElement('option');
                option.value = pegawai.id_Pegawai;
                option.textContent = pegawai.nama;
                select.appendChild(option);
            });
            document.getElementById('assign-pegawai-info').textContent = 
                `Tersedia ${data.data.length} pegawai pada hari ${data.hari}`;
        } else {
            select.innerHTML = '<option value="">Tidak ada pegawai tersedia</option>';
            alert(data.message || 'Gagal memuat data pegawai');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        select.innerHTML = '<option value="">Error loading pegawai</option>';
    });
    
    document.getElementById('assignPegawaiForm').action = `/admin/bookings/${bookingId}/assign-pegawai`;
    document.getElementById('assignPegawaiModal').classList.remove('hidden');
}

function openMessageModal(id, email, whatsapp) {
    currentBookingId = id;
    document.getElementById('msg_email').value = email;
    document.getElementById('msg_whatsapp').value = whatsapp;
    document.getElementById('messageForm').action = `/admin/bookings/${id}/send-message`;
    document.getElementById('messageModal').classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

function toggleStatusDropdown(id) {
    document.querySelectorAll('[id^="status-dropdown-"]').forEach(dropdown => {
        if (dropdown.id !== `status-dropdown-${id}`) {
            dropdown.classList.add('hidden');
        }
    });
    
    const dropdown = document.getElementById(`status-dropdown-${id}`);
    dropdown.classList.toggle('hidden');
}

function updateStatus(id, status, needsPayment = false) {
    const dropdown = document.getElementById(`status-dropdown-${id}`);
    if (dropdown) {
        dropdown.classList.add('hidden');
    }
    
    // Convert string to boolean if needed
    const isUserBooking = needsPayment === true || needsPayment === 'true';
    
    console.log('=== UPDATE STATUS CALLED ===');
    console.log('ID:', id);
    console.log('Status:', status);
    console.log('Needs Payment (original):', needsPayment);
    console.log('Is User Booking:', isUserBooking);
    
    if (!confirm(`Apakah Anda yakin ingin mengubah status menjadi ${status}?`)) {
        console.log('User cancelled confirmation');
        return;
    }
    
    // If changing to Done and it's a user booking (no payment data), show payment modal
    if (status === 'Done' && isUserBooking) {
        console.log('✓ User booking detected, showing payment modal');
        currentBookingId = id;
        showPaymentModal(id);
        return;
    }
    
    console.log('✓ Admin booking or Canceled status, updating directly');
    // Otherwise, update status directly (admin booking or changing to Canceled)
    performStatusUpdate(id, status);
}

function showPaymentModal(bookingId) {
    console.log('=== SHOW PAYMENT MODAL ===');
    console.log('Booking ID:', bookingId);
    
    fetch(`/admin/bookings/${bookingId}/details`)
    .then(response => {
        console.log('Details response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Booking details:', data);
        console.log('Harga from server:', data.harga);
        
        // Store original price
        currentBookingHarga = parseInt(data.harga) || 0;
        console.log('currentBookingHarga set to:', currentBookingHarga);
        
        // Reset form
        document.getElementById('payment_metode').value = '';
        document.getElementById('payment_diskon').value = '';
        document.getElementById('payment_jumlah_uang').value = '';
        document.getElementById('payment_kembalian').value = '0';
        
        // Hide all optional fields
        document.getElementById('payment_diskon_field').style.display = 'none';
        document.getElementById('payment_jumlah_field').style.display = 'none';
        document.getElementById('payment_kembalian_field').style.display = 'none';
        
        // Display original price
        document.getElementById('payment_harga').value = 'Rp ' + currentBookingHarga.toLocaleString('id-ID');
        document.getElementById('paymentForm').action = `/admin/bookings/${bookingId}/status`;
        
        console.log('Opening payment modal');
        document.getElementById('paymentModal').classList.remove('hidden');
    })
    .catch(error => {
        console.error('Error loading booking details:', error);
        alert('Gagal memuat data booking');
    });
}

function togglePaymentDiskon() {
    const metode = document.getElementById('payment_metode').value;
    const diskonField = document.getElementById('payment_diskon_field');
    const jumlahField = document.getElementById('payment_jumlah_field');
    const kembalianField = document.getElementById('payment_kembalian_field');
    
    console.log('=== TOGGLE PAYMENT DISKON ===');
    console.log('Metode selected:', metode);
    console.log('Current booking harga:', currentBookingHarga);
    
    if (metode === 'Tunai') {
        diskonField.style.display = 'block';
        jumlahField.style.display = 'block';
        kembalianField.style.display = 'block';
        console.log('✓ Showing Tunai fields');
    } else if (metode === 'Non Tunai') {
        diskonField.style.display = 'none';
        jumlahField.style.display = 'none';
        kembalianField.style.display = 'none';
        // Reset values
        document.getElementById('payment_diskon').value = '';
        document.getElementById('payment_jumlah_uang').value = '';
        document.getElementById('payment_kembalian').value = '0';
        console.log('✓ Hiding Tunai fields (Non Tunai selected)');
    } else {
        // No metode selected
        diskonField.style.display = 'none';
        jumlahField.style.display = 'none';
        kembalianField.style.display = 'none';
        console.log('✓ No metode selected');
    }
    
    // Recalculate total
    calculatePaymentTotal();
}

function calculatePaymentTotal() {
    const diskonSelect = document.getElementById('payment_diskon');
    const metode = document.getElementById('payment_metode').value;
    const hargaInput = document.getElementById('payment_harga');
    
    console.log('=== CALCULATE PAYMENT TOTAL ===');
    console.log('Original Harga:', currentBookingHarga);
    console.log('Metode:', metode);
    
    let finalTotal = currentBookingHarga;
    
    // Apply discount only if Tunai and discount selected
    if (metode === 'Tunai' && diskonSelect.value) {
        const selectedOption = diskonSelect.options[diskonSelect.selectedIndex];
        const diskonPersen = parseInt(selectedOption.getAttribute('data-persen') || '0');
        const diskonAmount = Math.floor((currentBookingHarga * diskonPersen) / 100);
        finalTotal = currentBookingHarga - diskonAmount;
        
        console.log('Discount:', diskonPersen + '%');
        console.log('Discount amount:', diskonAmount);
        console.log('Final total after discount:', finalTotal);
    } else {
        console.log('No discount applied');
    }
    
    // Update display
    hargaInput.value = 'Rp ' + finalTotal.toLocaleString('id-ID');
    console.log('Display updated to:', hargaInput.value);
    
    // Recalculate kembalian
    calculatePaymentKembalian();
}

function calculatePaymentKembalian() {
    const hargaInput = document.getElementById('payment_harga');
    const jumlahUangInput = document.getElementById('payment_jumlah_uang');
    const kembalianInput = document.getElementById('payment_kembalian');
    
    console.log('=== CALCULATE PAYMENT KEMBALIAN ===');
    
    // Get current total from display
    const hargaText = hargaInput.value;
    console.log('Harga text:', hargaText);
    
    // Parse: "Rp 170.000" -> 170000
    const total = parseInt(hargaText.replace(/\D/g, '') || '0');
    console.log('Total (parsed):', total);
    
    // Get jumlah uang
    const jumlahUangValue = jumlahUangInput.value;
    const jumlahUang = parseInt(jumlahUangValue || '0');
    console.log('Jumlah uang:', jumlahUang);
    
    // Calculate kembalian
    const kembalian = jumlahUang - total;
    console.log('Kembalian calculated:', kembalian);
    
    // Display (0 if negative)
    const displayValue = kembalian >= 0 ? kembalian : 0;
    kembalianInput.value = displayValue;
    console.log('Kembalian displayed:', displayValue);
    
    // Color feedback
    if (kembalian < 0) {
        kembalianInput.classList.remove('text-green-600');
        kembalianInput.classList.add('text-red-600');
        console.log('Color: RED (insufficient)');
    } else {
        kembalianInput.classList.remove('text-red-600');
        kembalianInput.classList.add('text-green-600');
        console.log('Color: GREEN (sufficient)');
    }
    
    console.log('=== END KEMBALIAN CALCULATION ===');
}

// Test function - call this from browser console to debug
function testPaymentCalculation() {
    console.log('=== PAYMENT CALCULATION TEST ===');
    console.log('currentBookingHarga:', currentBookingHarga);
    console.log('payment_harga value:', document.getElementById('payment_harga').value);
    console.log('payment_jumlah_uang value:', document.getElementById('payment_jumlah_uang').value);
    console.log('payment_kembalian value:', document.getElementById('payment_kembalian').value);
    
    // Force recalculation
    calculatePaymentKembalian();
}
function performStatusUpdate(id, status, paymentData = null) {
    const requestData = { status: status };
    
    if (paymentData) {
        Object.assign(requestData, paymentData);
    } else if (status === 'Done') {
        // Untuk admin booking yang sudah punya metode, kirim flag khusus
        requestData.skip_metode_validation = true;
    }
    
    console.log('=== PERFORM STATUS UPDATE ===');
    console.log('Booking ID:', id);
    console.log('Status:', status);
    console.log('Payment Data:', paymentData);
    console.log('Request Data:', requestData);
    console.log('Request URL:', `/admin/bookings/${id}/status`);
    
    fetch(`/admin/bookings/${id}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin',
        body: JSON.stringify(requestData)
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response ok:', response.ok);
        
        if (!response.ok) {
            return response.text().then(text => {
                console.error('Response text:', text);
                throw new Error(`HTTP ${response.status}: ${text}`);
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        
        if (data.success) {
            alert(data.message || 'Status berhasil diupdate');
            location.reload();
        } else {
            const errorMsg = data.message || 'Unknown error';
            console.error('Update failed:', errorMsg, data);
            alert('Gagal update status: ' + errorMsg);
        }
    })
    .catch(error => {
        console.error('=== FETCH ERROR ===');
        console.error('Error:', error);
        console.error('Stack:', error.stack);
        alert('Terjadi kesalahan saat update status: ' + error.message);
    });
}

function viewInvoice() {
    if (currentBookingId) {
        window.open(`/admin/bookings/${currentBookingId}/invoice`, '_blank');
    }
}

function viewInvoiceFromList(bookingId) {
    window.open(`/admin/bookings/${bookingId}/invoice`, '_blank');
}

function viewUnassignedBookings() {
    fetch('/admin/bookings-unassigned', {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            let content = '';
            if (data.data.length === 0) {
                content = '<p class="text-center text-gray-500">Tidak ada booking yang menunggu penugasan pegawai</p>';
            } else {
                content = '<div class="space-y-4">';
                data.data.forEach(booking => {
                    content += `
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-bold text-lg">${booking.nama}</h4>
                                    <p class="text-sm text-gray-600">${booking.email}</p>
                                    <p class="text-sm text-gray-600">${booking.jenis_kendaraan ? booking.jenis_kendaraan.jenis_kendaraan : '-'}</p>
                                    <p class="text-sm text-gray-600">Tanggal: ${new Date(booking.tanggal).toLocaleString('id-ID')}</p>
                                    <p class="text-lg font-bold text-teal-600 mt-2">Rp ${new Intl.NumberFormat('id-ID').format(booking.harga)}</p>
                                </div>
                                <button onclick="openAssignPegawaiModal(${booking.id_Booking}, '${booking.tanggal}')" 
                                        class="bg-teal-500 text-white px-4 py-2 rounded-lg hover:bg-teal-600">
                                    Pilih Pegawai
                                </button>
                            </div>
                        </div>
                    `;
                });
                content += '</div>';
            }
            document.getElementById('unassignedContent').innerHTML = content;
            document.getElementById('unassignedModal').classList.remove('hidden');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal memuat data booking');
    });
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('button')) {
        document.querySelectorAll('[id^="status-dropdown-"]').forEach(dropdown => {
            dropdown.classList.add('hidden');
        });
    }
});

// Form submissions
document.getElementById('bookingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const method = document.getElementById('formMethod').value;
    
    if (method === 'PUT') {
        formData.append('_method', 'PUT');
    }
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = 'Menyimpan...';
    
    fetch(this.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
        
        if (data.success) {
            alert(data.message || 'Booking berhasil disimpan');
            closeModal('dataModal');
            location.reload();
        } else if (data.errors) {
            let errorMsg = 'Validasi gagal:\n';
            for (let field in data.errors) {
                errorMsg += `- ${data.errors[field].join(', ')}\n`;
            }
            alert(errorMsg);
        } else {
            alert('Terjadi kesalahan: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
        alert('Terjadi kesalahan: ' + error.message);
    });
});

document.getElementById('assignPegawaiForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Menugaskan...';
    
    fetch(this.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
        
        if (data.success) {
            alert(data.message || 'Pegawai berhasil ditugaskan!');
            closeModal('assignPegawaiModal');
            location.reload();
        } else {
            alert('Gagal menugaskan pegawai: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
        alert('Terjadi kesalahan: ' + error.message);
    });
});

document.getElementById('paymentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const paymentData = {
        status: 'Done',
        metode: formData.get('metode'),
        id_diskon: formData.get('id_diskon') || null,
        jumlah_uang: formData.get('jumlah_uang') || null
    };
    
    console.log('=== PAYMENT FORM SUBMIT ===');
    console.log('Booking ID:', currentBookingId);
    console.log('Payment Data:', paymentData);
    
    // Validate metode
    if (!paymentData.metode) {
        alert('Metode pembayaran harus diisi!');
        return;
    }
    
    // Validate jumlah_uang for Tunai
    if (paymentData.metode === 'Tunai' && !paymentData.jumlah_uang) {
        alert('Jumlah uang harus diisi untuk metode Tunai!');
        return;
    }
    
    closeModal('paymentModal');
    performStatusUpdate(currentBookingId, 'Done', paymentData);
});

document.getElementById('messageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Mengirim...';
    
    fetch(this.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
        
        if (data.success) {
            alert(data.message || 'Pesan berhasil dikirim!');
            closeModal('messageModal');
        } else {
            alert('Gagal mengirim pesan: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Message error:', error);
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
        alert('Terjadi kesalahan: ' + error.message);
    });
});

// Load unassigned bookings count on page load
document.addEventListener('DOMContentLoaded', function() {
    fetch('/admin/bookings-unassigned')
    .then(response => response.json())
    .then(data => {
        if (data.success && data.data.length > 0) {
            const badge = document.getElementById('unassigned-badge');
            badge.textContent = data.data.length;
            badge.classList.remove('hidden');
        }
    })
    .catch(error => console.error('Error loading unassigned count:', error));
});
</script>
@endsection