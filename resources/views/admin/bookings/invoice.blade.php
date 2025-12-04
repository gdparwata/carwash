<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $booking->id_Booking }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
        }
        
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .logo-text {
            font-size: 3rem;
            font-weight: 800;
            color: #1e3a5f;
            letter-spacing: -0.05em;
        }
        
        .logo-text span {
            color: #5eb3b7;
        }
        
        .invoice-title {
            font-size: 4rem;
            font-weight: 800;
            color: #1e3a5f;
            letter-spacing: -0.02em;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-12">
            <!-- Header -->
            <div class="flex justify-between items-start mb-12">
                <div>
                    <h1 class="logo-text">cuci<span>car</span></h1>
                    <p class="text-gray-700 font-medium mt-1">CUCICAR cuci mobil terbesar se Indonesia</p>
                    <p class="text-gray-700 font-medium">+6289676362824</p>
                </div>
                <div class="text-right">
                    <h2 class="invoice-title">INVOICE</h2>
                    <p class="text-gray-500 font-medium text-lg">Invoice no: {{ $booking->id_Booking }}</p>
                    <p class="text-gray-500 font-medium text-lg">{{ now()->format('d M Y') }}</p>
                </div>
            </div>

            <!-- Customer & Booking Info -->
            <div class="mb-8">
                <h3 class="text-3xl font-bold text-gray-800 mb-1">{{ strtoupper($booking->nama ?? ($booking->user->name ?? '-')) }}</h3>
                <p class="text-gray-600">{{ $booking->email ?? ($booking->user->email ?? '-') }}/{{ $booking->nomor_telepon ?? '-' }}</p>
            </div>

            <!-- Services Table -->
            <div class="mb-8">
                @php
                    $hargaKendaraan = $booking->jenisKendaraan->harga ?? 0;
                    $hargaPaket = $booking->paket->tingkatan->harga ?? 0;
                    $hargaAddons = $booking->addons->harga ?? 0;
                    
                    $subtotal = $hargaKendaraan + $hargaPaket + $hargaAddons;
                    $diskonPersen = $booking->diskon ?? 0;
                    $diskonNilai = round(($subtotal * $diskonPersen) / 100);
                    
                    $totalAkhir = $booking->harga;
                @endphp

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b-2 border-gray-300">
                            <th class="py-4 text-left text-gray-500 font-semibold text-sm">Layanan</th>
                            <th class="py-4 text-left text-gray-500 font-semibold text-sm">Deskripsi</th>
                            <th class="py-4 text-right text-gray-500 font-semibold text-sm">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Jenis Kendaraan -->
                        <tr class="border-b border-gray-200">
                            <td class="py-4 font-medium text-gray-800">Jenis Kendaraan</td>
                            <td class="py-4 text-gray-600">
                                {{ $booking->jenisKendaraan->jenis_kendaraan ?? '-' }} 
                                ({{ ucwords(strtolower($booking->jenisKendaraan->jenis_kendaraan ?? 'City Car')) }})
                            </td>
                            <td class="py-4 text-right font-medium text-gray-800">
                                Rp {{ number_format($hargaKendaraan, 0, ',', '.') }}
                            </td>
                        </tr>

                        <!-- Paket -->
                        <tr class="border-b border-gray-200">
                            <td class="py-4 font-medium text-gray-800">Paket</td>
                            <td class="py-4 text-gray-600">
                                {{ $booking->paket->kategori_paket ?? '-' }}
                                @if($booking->paket && $booking->paket->tingkatan)
                                - {{ $booking->paket->tingkatan->Tingkatan }}
                                @endif
                            </td>
                            <td class="py-4 text-right font-medium text-gray-800">
                                Rp {{ number_format($hargaPaket, 0, ',', '.') }}
                            </td>
                        </tr>

                        <!-- Addons -->
                        @if($booking->addons)
                        <tr class="border-b border-gray-200">
                            <td class="py-4 font-medium text-gray-800">Addons</td>
                            <td class="py-4 text-gray-600">{{ $booking->addons->nama }}</td>
                            <td class="py-4 text-right font-medium text-gray-800">
                                Rp {{ number_format($hargaAddons, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endif

                        <!-- Diskon -->
                        @if($diskonPersen > 0)
                        <tr class="border-b border-gray-200">
                            <td colspan="2" class="py-4 text-right font-medium text-red-600">
                                Diskon ({{ $diskonPersen }}%)
                            </td>
                            <td class="py-4 text-right font-medium text-red-600">
                                - Rp {{ number_format($diskonNilai, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endif

                        <!-- Total Pembayaran -->
                        <tr class="bg-teal-50 border-t-2 border-gray-300">
                            <td colspan="2" class="py-4 text-right font-bold text-lg text-gray-800">
                                Total Pembayaran
                            </td>
                            <td class="py-4 text-right font-bold text-2xl text-teal-600">
                                Rp {{ number_format($totalAkhir, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Thank You Message -->
            <div class="text-center my-12">
                <h2 class="text-3xl font-bold text-gray-800">Terimakasih telah mencuci mobil di cucicar!</h2>
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

            <!-- Payment Information & Logo -->
            <div class="flex justify-between items-end mt-12 mb-8">
                <div>
                    <h3 class="text-gray-500 font-semibold text-lg mb-2">Payment Information</h3>
                    <p class="text-gray-600">Silahkan bayar di Kasir cucicar!</p>
                    <p class="text-sm text-gray-500 mt-2">Metode: {{ ucfirst($booking->metode ?? 'cash') }}</p>
                </div>
                <div class="text-right">
                    <h1 class="logo-text text-5xl">cuci<span>car</span></h1>
                    <p class="text-gray-500 text-sm mt-1">Tempat Cuci Mobil terbesar nomor 1 seindonesia</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center text-sm text-gray-500 border-t pt-4 mb-6">
                <p>Terima kasih telah menggunakan layanan kami!</p>
                <p>Invoice ini digenerate secara otomatis pada {{ now()->format('d M Y, H:i') }}</p>
            </div>

            <!-- Print Button -->
            <div class="no-print mt-6 flex gap-4 justify-center">
                <button onclick="window.history.back()" 
                        class="bg-teal-500 text-white px-20 py-3 rounded-lg hover:bg-teal-600 font-semibold text-lg">
                    Back
                </button>
                <button onclick="window.print()" 
                        class="bg-blue-900 text-white px-16 py-3 rounded-lg hover:bg-blue-800 font-semibold text-lg">
                    Download
                </button>
            </div>
        </div>
    </div>
</body>
</html>