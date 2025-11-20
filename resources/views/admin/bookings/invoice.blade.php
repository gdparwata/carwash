<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $booking->id_booking }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-8">
            <!-- Header -->
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">INVOICE</h1>
                    <p class="text-gray-600">#{{ $booking->id_booking }}</p>
                </div>
                <div class="text-right">
                    <h2 class="text-xl font-bold text-teal-600">Car Wash Service</h2>
                    <p class="text-gray-600">{{ config('app.name', 'Car Wash') }}</p>
                    <p class="text-sm text-gray-500">
                        Tanggal: {{ now()->format('d M Y, H:i') }}
                    </p>
                </div>
            </div>

            <!-- Customer & Booking Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Informasi Customer</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p><strong>Nama:</strong> {{ $booking->nama ?? ($booking->user->name ?? '-') }}</p>
                        <p><strong>Email:</strong> {{ $booking->email ?? ($booking->user->email ?? '-') }}</p>
                        <p><strong>Telepon:</strong> {{ $booking->nomor_telepon ?? '-' }}</p>
                        <p><strong>Alamat:</strong> {{ $booking->alamat ?? '-' }}</p>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Informasi Kendaraan</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p><strong>Nomor Polisi:</strong> {{ $booking->nomor_polisi ?? '-' }}</p>
                        <p><strong>Jenis:</strong> {{ $booking->jenisKendaraan->jenis_kendaraan ?? '-' }}</p>
                        <p><strong>Tanggal Service:</strong> {{ \Carbon\Carbon::parse($booking->tanggal)->format('d M Y, H:i') }}</p>
                        <p><strong>Pegawai:</strong> {{ $booking->pegawai->nama ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Services Table -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Detail Layanan</h3>
                <table class="w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 p-3 text-left">Layanan</th>
                            <th class="border border-gray-300 p-3 text-left">Deskripsi</th>
                            <th class="border border-gray-300 p-3 text-right">Harga</th>
                        </tr>
                    </thead>
<tbody>
  @php
    $hargaKendaraan = $booking->jenisKendaraan->harga ?? 0;
    $hargaPaket = $booking->paket->tingkatan->harga ?? $booking->paket->harga ?? 0;
    $hargaAddons = $booking->addons->harga ?? 0;
    $diskonPersen = $booking->diskon ?? 0;

    $subtotal = $hargaKendaraan + $hargaPaket + $hargaAddons;
    $diskonNilai = ($subtotal * $diskonPersen) / 100;
    $totalAkhir = $subtotal - $diskonNilai;
@endphp

<tr>
    <td class="border border-gray-300 p-3">Jenis Kendaraan</td>
    <td class="border border-gray-300 p-3 text-sm text-gray-600">
        {{ $booking->jenisKendaraan->jenis_kendaraan ?? '-' }}
    </td>
    <td class="border border-gray-300 p-3 text-right">
        Rp {{ number_format($hargaKendaraan, 0, ',', '.') }}
    </td>
</tr>

<tr>
    <td class="border border-gray-300 p-3">Paket</td>
    <td class="border border-gray-300 p-3 text-sm text-gray-600">
        {{ $booking->paket->kategori_paket ?? '-' }}
    </td>
    <td class="border border-gray-300 p-3 text-right">
        Rp {{ number_format($hargaPaket, 0, ',', '.') }}
    </td>
</tr>

@if($booking->addons)
<tr>
    <td class="border border-gray-300 p-3">{{ $booking->addons->nama }}</td>
    <td class="border border-gray-300 p-3 text-sm text-gray-600">{{ $booking->addons->deskripsi ?? '-' }}</td>
    <td class="border border-gray-300 p-3 text-right">
        Rp {{ number_format($hargaAddons, 0, ',', '.') }}
    </td>
</tr>
@endif

<tr>
    <td colspan="2" class="text-right font-semibold">Subtotal</td>
    <td class="text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
</tr>

@if($diskonPersen > 0)
<tr>
    <td colspan="2" class="text-right text-red-600">Diskon ({{ $diskonPersen }}%)</td>
    <td class="text-right text-red-600">- Rp {{ number_format($diskonNilai, 0, ',', '.') }}</td>
</tr>
@endif

<tr>
    <td colspan="2" class="text-right font-bold text-lg">Total</td>
    <td class="text-right font-bold text-lg">
        Rp {{ number_format($totalAkhir, 0, ',', '.') }}
    </td>
</tr>
</tbody>


</table>
            </div>

            <!-- Total -->
            <div class="flex justify-end mb-8">
    <div class="w-64">
        <div class="bg-teal-50 p-4 rounded-lg border-2 border-teal-200">
            <div class="flex justify-between items-center">
                <span class="text-lg font-semibold text-gray-800">Total Pembayaran:</span>
                <span class="text-xl font-bold text-teal-600">
                    Rp {{ number_format($totalAkhir, 0, ',', '.') }}
                </span>
            </div>
            <div class="text-sm text-gray-600 mt-1">
                Metode: {{ ucfirst($booking->metode ?? 'cash') }}
            </div>
        </div>
    </div>
</div>


            <!-- Notes -->
            @if($booking->catatan)
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Catatan</h3>
                <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                    <p class="text-gray-700">{{ $booking->catatan }}</p>
                </div>
            </div>
            @endif

            <!-- Status -->
            <div class="mb-8">
                <div class="flex items-center space-x-2">
                    <span class="text-gray-600">Status:</span>
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        {{ $booking->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $booking->status == 'confirmed' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $booking->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $booking->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center text-sm text-gray-500 border-t pt-4">
                <p>Terima kasih telah menggunakan layanan kami!</p>
                <p>Invoice ini digenerate secara otomatis pada {{ now()->format('d M Y, H:i') }}</p>
            </div>

            <!-- Print Button -->
            <div class="no-print mt-6 text-center">
                <button onclick="window.print()" 
                        class="bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700 mr-2">
                    Print Invoice
                </button>
                <button onclick="window.close()" 
                        class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</body>
</html>