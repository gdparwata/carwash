<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Paket;
use App\Models\JenisKendaraan;
use App\Models\Pegawai;
use App\Models\Addons;
use App\Models\Diskon;
use App\Models\Tingkatan;
use App\Models\Libur;
use App\Models\Invoice;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BookingController extends Controller
{
    // Hapus constructor dan property invoiceController

    // ... (semua method calculatePrice, index, getAvailablePegawai, getDayInIndonesian tetap sama)
    
    private function calculatePrice($jenisKendaraanId, $tingkatanId, $addonsId = null, $diskonId = null, $metode = null)
    {
        $harga = 0;
        $breakdown = [];

        $jenisKendaraan = JenisKendaraan::find($jenisKendaraanId);
        
        Log::info('🚗 === CALCULATE PRICE - JENIS KENDARAAN ===', [
            'id_requested' => $jenisKendaraanId,
            'found' => $jenisKendaraan ? 'YES' : 'NO',
            'data' => $jenisKendaraan ? $jenisKendaraan->toArray() : null,
            'harga_field_exists' => $jenisKendaraan ? isset($jenisKendaraan->harga) : false,
            'harga_value' => $jenisKendaraan ? $jenisKendaraan->harga : 'NULL',
            'harga_type' => $jenisKendaraan && $jenisKendaraan->harga ? gettype($jenisKendaraan->harga) : 'NULL'
        ]);
        
        if ($jenisKendaraan && $jenisKendaraan->harga) {
            $harga += $jenisKendaraan->harga;
            $breakdown['jenis_kendaraan'] = $jenisKendaraan->harga;
            Log::info('✅ Jenis kendaraan price added', ['price' => $jenisKendaraan->harga]);
        } else {
            Log::warning('⚠️ Jenis kendaraan price NOT added', [
                'reason' => !$jenisKendaraan ? 'Not found' : 'Harga is null/zero'
            ]);
        }

        $tingkatan = Tingkatan::find($tingkatanId);
        Log::info('📊 Tingkatan Check', [
            'id' => $tingkatanId,
            'found' => $tingkatan ? 'YES' : 'NO',
            'harga' => $tingkatan ? $tingkatan->harga : 'NULL'
        ]);
        
        if ($tingkatan) {
            $harga += $tingkatan->harga;
            $breakdown['tingkatan'] = $tingkatan->harga;
            Log::info('✅ Tingkatan price added', ['price' => $tingkatan->harga]);
        }

        if ($addonsId) {
            $addon = Addons::find($addonsId);
            Log::info('🎁 Addons Check', [
                'id' => $addonsId,
                'found' => $addon ? 'YES' : 'NO',
                'harga' => $addon ? $addon->harga : 'NULL'
            ]);
            
            if ($addon) {
                $harga += $addon->harga;
                $breakdown['addons'] = $addon->harga;
                Log::info('✅ Addons price added', ['price' => $addon->harga]);
            }
        }

        Log::info('💵 Subtotal (before discount)', [
            'breakdown' => $breakdown,
            'total' => $harga
        ]);

        $diskonPersen = 0;
        if ($metode === 'Tunai' && $diskonId) {
            $diskon = Diskon::find($diskonId);
            if ($diskon && $diskon->Berlaku_sampai >= now()) {
                $diskonPersen = $diskon->persen;
                $diskonAmount = ($harga * $diskonPersen) / 100;
                $harga = $harga - $diskonAmount;
                Log::info('💰 Discount applied', [
                    'percent' => $diskonPersen,
                    'amount' => $diskonAmount,
                    'final_price' => $harga
                ]);
            }
        }

        Log::info('🎯 === FINAL CALCULATION ===', [
            'breakdown' => $breakdown,
            'subtotal' => array_sum($breakdown),
            'discount_percent' => $diskonPersen,
            'final_price' => $harga
        ]);

        return [
            'harga' => $harga,
            'diskon_persen' => $diskonPersen
        ];
    }

    public function index(Request $request)
    {
        $query = Booking::with(['jenisKendaraan', 'paket', 'pegawai', 'addons']);

        if ($request->has('tanggal') && $request->tanggal) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->has('kategori') && $request->kategori != 'Sudah Selesai') {
            $query->where('status', $request->kategori);
        }

        $bookings = $query->orderBy('tanggal', 'desc')->paginate(6);

        $totalBooking = Booking::count();
        $bookingBelumSelesai = Booking::where('status', 'InProgres')->count();
        $bookingSelesai = Booking::where('status', 'Done')->count();

        $pakets = Paket::with('tingkatan')->get();
        $jenisKendaraans = JenisKendaraan::all();
        $pegawais = Pegawai::all();
        $addons = Addons::all();
        $diskons = Diskon::where('Berlaku_sampai', '>=', now())->get();
        $tingkatans = Tingkatan::all();

        return view('admin.bookings.index', compact(
            'bookings',
            'totalBooking',
            'bookingBelumSelesai',
            'bookingSelesai',
            'jenisKendaraans',
            'pakets',
            'pegawais',
            'addons',
            'diskons',
            'tingkatans'
        ));
    }

    public function getAvailablePegawai(Request $request)
    {
        try {
            $tanggal = $request->tanggal;
            
            if (!$tanggal) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tanggal harus diisi'
                ], 422);
            }

            $date = Carbon::parse($tanggal);
            $dayNumber = $date->dayOfWeek;
            $hariIndonesia = $this->getDayInIndonesian($dayNumber);
            
            Log::info('=== CHECKING AVAILABLE PEGAWAI ===', [
                'tanggal' => $tanggal,
                'hari_indonesia' => $hariIndonesia,
                'day_number' => $dayNumber
            ]);
            
            $availablePegawai = Pegawai::whereDoesntHave('liburs', function($query) use ($hariIndonesia) {
                $query->where('hari', $hariIndonesia);
            })->get();
            
            Log::info('Available pegawai found', [
                'count' => $availablePegawai->count(),
                'pegawai_ids' => $availablePegawai->pluck('id_Pegawai')->toArray(),
                'pegawai_names' => $availablePegawai->pluck('nama')->toArray()
            ]);

            return response()->json([
                'success' => true,
                'data' => $availablePegawai,
                'hari' => $hariIndonesia,
                'total_available' => $availablePegawai->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error getting available pegawai: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getDayInIndonesian($dayNumber)
    {
        $days = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu'
        ];
        
        return $days[$dayNumber];
    }

    /**
     * Store a newly created booking (ADMIN) - DENGAN AUTO CREATE INVOICE
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'nomor_telepon' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'alamat' => 'required|string|max:255',
                'nomor_polisi' => 'nullable|string|max:255',
                'tanggal' => 'required|date',
                'id_jenis_kendaraan' => 'required|exists:jenis_kendaraans,id_jenis_kendaraan',
                'id_jenis_penanganan' => 'required|exists:tingkatans,id_Tingkatan',
                'id_Paket' => 'required|exists:pakets,id_paket',
                'id_Pegawai' => 'required|exists:pegawais,id_Pegawai',
                'catatan' => 'nullable|string',
                'id_Addons' => 'nullable|exists:addons,id_addons',
                'metode' => 'required|string|in:Tunai,Non Tunai',
                'id_Diskon' => 'nullable|exists:diskons,id_Diskon',
                'jumlah_uang' => 'nullable|numeric|min:0',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $date = Carbon::parse($request->tanggal);
            $hariIndonesia = $this->getDayInIndonesian($date->dayOfWeek);
            
            $isLibur = Libur::where('id_pegawai', $request->id_Pegawai)
                           ->where('hari', $hariIndonesia)
                           ->exists();
            
            if ($isLibur) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pegawai yang dipilih sedang libur pada hari tersebut'
                ], 422);
            }

            $priceData = $this->calculatePrice(
                $request->id_jenis_kendaraan,
                $request->id_jenis_penanganan,
                $request->id_Addons,
                $request->id_Diskon,
                $request->metode
            );

            $booking = new Booking();
            $booking->nama = $request->nama;
            $booking->nomor_telepon = $request->nomor_telepon;
            $booking->email = $request->email;
            $booking->alamat = $request->alamat;
            $booking->nomor_polisi = $request->nomor_polisi;
            $booking->tanggal = $request->tanggal;
            $booking->catatan = $request->catatan;
            $booking->harga = $priceData['harga'];
            $booking->diskon = $priceData['diskon_persen'];
            $booking->metode = $request->metode;
            $booking->status = 'InProgres';
            $booking->id_jenis_kendaraan = $request->id_jenis_kendaraan;
            $booking->id_paket = $request->id_Paket;
            $booking->id_Pegawai = $request->id_Pegawai;
            $booking->id_addons = $request->id_Addons;
            $booking->id_Diskon = $request->id_Diskon;
            $booking->id_user = auth()->id();
            $booking->jumlah_uang = $request->jumlah_uang;
            $booking->kembalian = $request->jumlah_uang ? $request->jumlah_uang - $priceData['harga'] : 0;

            $booking->save();

            // 🔥 AUTO CREATE INVOICE setelah booking berhasil - DIRECT DB INSERT
            try {
                $bookingId = $booking->getKey(); // Ambil primary key apapun namanya
                
                Log::info('🔑 Booking ID for invoice', [
                    'booking_primary_key' => $bookingId,
                    'booking_object' => $booking->toArray()
                ]);
                
                DB::table('invoices')->insert([
                    'id_booking' => $bookingId,
                    'tanggal' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                Log::info('✅ Invoice created directly', ['booking_id' => $bookingId]);
            } catch (\Exception $e) {
                Log::error('❌ Failed to create invoice: ' . $e->getMessage(), [
                    'booking_data' => $booking->toArray()
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Booking berhasil ditambahkan!',
                'booking_id' => $booking->id_Booking,
                'harga' => $priceData['harga']
            ]);

        } catch (\Exception $e) {
            Log::error('Error creating booking: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store booking from user form (USER) - DENGAN AUTO CREATE INVOICE
     */
    public function storeUserBooking(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'nomor_telepon' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'alamat' => 'required|string|max:255',
                'nomor_polisi' => 'required|string|max:255',
                'id_jenis_kendaraan' => 'required|exists:jenis_kendaraans,id_jenis_kendaraan',
                'id_jenis_penanganan' => 'required|exists:tingkatans,id_Tingkatan',
                'id_Paket' => 'required|exists:pakets,id_paket',
                'id_Addons' => 'nullable|exists:addons,id_addons',
                'id_Diskon' => 'nullable|exists:diskons,id_Diskon',
                'tanggal' => 'required|date|after:now',
                'metode' => 'nullable|string|in:cash,transfer,qris,Tunai,Non Tunai',
                'catatan' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                if ($request->expectsJson() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validasi gagal',
                        'errors' => $validator->errors()
                    ], 422);
                }
                
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $priceData = $this->calculatePrice(
                $request->id_jenis_kendaraan,
                $request->id_jenis_penanganan,
                $request->id_Addons,
                $request->id_Diskon,
                null
            );

            $bookingData = [
                'nama' => $request->nama,
                'nomor_telepon' => $request->nomor_telepon,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'nomor_polisi' => $request->nomor_polisi,
                'tanggal' => $request->tanggal,
                'catatan' => $request->catatan,
                'harga' => $priceData['harga'],
                'diskon' => $priceData['diskon_persen'],
                'metode' => null,
                'status' => 'InProgres',
                'id_jenis_kendaraan' => $request->id_jenis_kendaraan,
                'id_paket' => $request->id_Paket,
                'id_Pegawai' => null,
                'id_addons' => $request->id_Addons ?: null,
                'id_Diskon' => $request->id_Diskon ?: null,
                'id_user' => auth()->id(),
                'tanggal_booking' => now(),
            ];

            $booking = Booking::create($bookingData);

            Log::info('User booking created successfully', [
                'booking_id' => $booking->id_Booking,
                'user_id' => auth()->id(),
                'harga' => $priceData['harga']
            ]);

            // 🔥 AUTO CREATE INVOICE setelah user booking berhasil - DIRECT DB INSERT
            try {
                $bookingId = $booking->getKey(); // Ambil primary key apapun namanya
                
                Log::info('🔑 User Booking ID for invoice', [
                    'booking_primary_key' => $bookingId
                ]);
                
                DB::table('invoices')->insert([
                    'id_booking' => $bookingId,
                    'tanggal' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                Log::info('✅ Invoice created directly', ['booking_id' => $bookingId]);
            } catch (\Exception $e) {
                Log::error('❌ Failed to create invoice: ' . $e->getMessage());
            }

            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Booking berhasil dibuat! Admin akan segera menghubungi Anda.',
                    'booking_id' => $booking->id_Booking,
                    'harga' => $priceData['harga']
                ], 201);
            }

            return redirect()->back()->with('success', 'Booking berhasil dibuat! Total: Rp ' . number_format($priceData['harga'], 0, ',', '.') . '. Admin akan segera menghubungi Anda.');

        } catch (\Exception $e) {
            Log::error('Error creating user booking: ' . $e->getMessage());
            
            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function assignPegawai(Request $request, $id)
    {
        try {
            $booking = Booking::where('id_Booking', $id)->firstOrFail();

            $validator = Validator::make($request->all(), [
                'id_pegawai' => 'required|exists:pegawais,id_Pegawai'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $date = Carbon::parse($booking->tanggal);
            $hariIndonesia = $this->getDayInIndonesian($date->dayOfWeek);
            
            $isLibur = Libur::where('id_pegawai', $request->id_pegawai)
                           ->where('hari', $hariIndonesia)
                           ->exists();
            
            if ($isLibur) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pegawai yang dipilih sedang libur pada hari tersebut'
                ], 422);
            }

            $booking->id_Pegawai = $request->id_pegawai;
            $booking->save();

            return response()->json([
                'success' => true,
                'message' => 'Pegawai berhasil ditugaskan!'
            ]);

        } catch (\Exception $e) {
            Log::error('Error assigning pegawai: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update booking status - DENGAN AUTO UPDATE INVOICE
     */
/**
 * Update booking status - FIXED VERSION
 */
public function updateStatus(Request $request, $booking)
{
    try {
        if (!($booking instanceof Booking)) {
            $booking = Booking::where('id_booking', $booking)->firstOrFail();
        }

        Log::info('=== UPDATE STATUS START ===', [
            'booking_id' => $booking->id_Booking,
            'current_status' => $booking->status,
            'current_harga' => $booking->harga,
            'new_status' => $request->status,
            'request_data' => $request->all()
        ]);

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Done,Canceled,InProgres',
            'metode' => 'nullable|in:Tunai,Non Tunai',
            'jumlah_uang' => 'nullable|numeric|min:0',
            'id_diskon' => 'nullable|exists:diskons,id_Diskon'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $oldStatus = $booking->status;
        $booking->status = $request->status;

        // Jika status Done dan belum ada metode (user booking yang baru bayar)
        if ($request->status === 'Done' && !$booking->metode && !$request->skip_metode_validation) {
            
            Log::info('Processing payment for user booking');
            
            if (!$request->metode) {
                return response()->json([
                    'success' => false,
                    'message' => 'Metode pembayaran harus diisi untuk user booking'
                ], 422);
            }

            // ✅ JANGAN HITUNG ULANG HARGA! Gunakan harga yang sudah ada
            $hargaFinal = $booking->harga;
            
            // Update payment info
            $booking->metode = $request->metode;
            
            // Handle discount (hanya update persentase dan ID diskon)
            if ($request->id_diskon && $request->metode === 'Tunai') {
                $diskon = Diskon::find($request->id_diskon);
                if ($diskon && $diskon->Berlaku_sampai >= now()) {
                    $booking->id_Diskon = $diskon->id_Diskon;
                    $booking->diskon = $diskon->persen;
                    
                    // Hitung harga setelah diskon
                    $diskonAmount = ($booking->harga * $diskon->persen) / 100;
                    $hargaFinal = $booking->harga - $diskonAmount;
                    
                    Log::info('Discount applied', [
                        'diskon_persen' => $diskon->persen,
                        'harga_original' => $booking->harga,
                        'diskon_amount' => $diskonAmount,
                        'harga_final' => $hargaFinal
                    ]);
                }
            }
            
            // Handle jumlah uang untuk Tunai
            if ($request->metode === 'Tunai' && $request->jumlah_uang) {
                $booking->jumlah_uang = $request->jumlah_uang;
                $booking->kembalian = $request->jumlah_uang - $hargaFinal;
                
                Log::info('Cash payment processed', [
                    'jumlah_uang' => $request->jumlah_uang,
                    'harga_final' => $hargaFinal,
                    'kembalian' => $booking->kembalian
                ]);
            }
            
            // Set tanggal bayar
            $booking->tanggal_bayar = now();
            
            Log::info('Payment info updated', [
                'metode' => $booking->metode,
                'harga_original' => $booking->harga,
                'diskon' => $booking->diskon,
                'jumlah_uang' => $booking->jumlah_uang,
                'kembalian' => $booking->kembalian
            ]);
        }

        $booking->save();

        Log::info('=== BOOKING SAVED ===', [
            'booking_id' => $booking->id_Booking,
            'status' => $booking->status,
            'harga' => $booking->harga,
            'metode' => $booking->metode
        ]);

        // Auto update invoice
        try {
            $invoice = DB::table('invoices')->where('id_booking', $booking->id_Booking)->first();
            if ($invoice) {
                DB::table('invoices')
                    ->where('id_booking', $booking->id_Booking)
                    ->update([
                        'tanggal' => now(),
                        'updated_at' => now()
                    ]);
                Log::info('✅ Invoice updated', ['booking_id' => $booking->id_Booking]);
            } else {
                DB::table('invoices')->insert([
                    'id_booking' => $booking->id_Booking,
                    'tanggal' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                Log::info('✅ Invoice created', ['booking_id' => $booking->id_Booking]);
            }
        } catch (\Exception $e) {
            Log::error('❌ Failed to update invoice: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui dari ' . $oldStatus . ' menjadi ' . $request->status,
            'data' => [
                'id' => $booking->id_Booking,
                'status' => $booking->status,
                'harga' => $booking->harga,
                'metode' => $booking->metode
            ]
        ], 200);

    } catch (\Exception $e) {
        Log::error('Error updating status', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Update the specified booking - DENGAN AUTO UPDATE INVOICE
     */
    public function update(Request $request, $booking)
    {
        try {
            if (!($booking instanceof Booking)) {
                $booking = Booking::where('id_booking', $booking)->firstOrFail();
            }

            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'nomor_telepon' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'alamat' => 'required|string|max:255',
                'nomor_polisi' => 'nullable|string|max:255',
                'tanggal' => 'required|date',
                'id_jenis_kendaraan' => 'required|exists:jenis_kendaraans,id_jenis_kendaraan',
                'id_jenis_penanganan' => 'required|exists:tingkatans,id_Tingkatan',
                'id_Paket' => 'required|exists:pakets,id_paket',
                'id_Pegawai' => 'required|exists:pegawais,id_Pegawai',
                'catatan' => 'nullable|string',
                'id_Addons' => 'nullable|exists:addons,id_addons',
                'metode' => 'nullable|string|in:Tunai,Non Tunai',
                'id_Diskon' => 'nullable|exists:diskons,id_Diskon',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $date = Carbon::parse($request->tanggal);
            $hariIndonesia = $this->getDayInIndonesian($date->dayOfWeek);
            
            $isLibur = Libur::where('id_pegawai', $request->id_Pegawai)
                           ->where('hari', $hariIndonesia)
                           ->exists();
            
            if ($isLibur) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pegawai yang dipilih sedang libur pada hari tersebut'
                ], 422);
            }

            $priceData = $this->calculatePrice(
                $request->id_jenis_kendaraan,
                $request->id_jenis_penanganan,
                $request->id_Addons,
                $request->id_Diskon,
                $request->metode
            );

            $booking->nama = $request->nama;
            $booking->nomor_telepon = $request->nomor_telepon;
            $booking->email = $request->email;
            $booking->alamat = $request->alamat;
            $booking->nomor_polisi = $request->nomor_polisi;
            $booking->tanggal = $request->tanggal;
            $booking->catatan = $request->catatan;
            $booking->harga = $priceData['harga'];
            $booking->diskon = $priceData['diskon_persen'];
            $booking->metode = $request->metode;
            $booking->id_jenis_kendaraan = $request->id_jenis_kendaraan;
            $booking->id_paket = $request->id_Paket;
            $booking->id_Pegawai = $request->id_Pegawai;
            $booking->id_addons = $request->id_Addons;
            $booking->id_Diskon = $request->id_Diskon;

            $booking->save();

            // 🔥 AUTO UPDATE INVOICE saat booking diupdate - DIRECT DB UPDATE
            try {
                $invoice = DB::table('invoices')->where('id_booking', $booking->id_Booking)->first();
                if ($invoice) {
                    DB::table('invoices')
                        ->where('id_booking', $booking->id_Booking)
                        ->update([
                            'tanggal' => now(),
                            'updated_at' => now()
                        ]);
                    Log::info('✅ Invoice updated directly', ['booking_id' => $booking->id_Booking]);
                } else {
                    // Buat invoice baru jika belum ada
                    DB::table('invoices')->insert([
                        'id_booking' => $booking->id_Booking,
                        'tanggal' => now(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    Log::info('✅ Invoice created (was missing)', ['booking_id' => $booking->id_Booking]);
                }
            } catch (\Exception $e) {
                Log::error('❌ Failed to update invoice: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Booking berhasil diperbarui!',
                'harga' => $priceData['harga']
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating booking: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function sendMessage(Request $request, $booking)
    {
        try {
            if (!($booking instanceof Booking)) {
                $booking = Booking::where('id_booking', $booking)->firstOrFail();
            }

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'whatsapp' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            return response()->json([
                'success' => true,
                'message' => 'Pesan berhasil dikirim ke ' . $request->email
            ]);

        } catch (\Exception $e) {
            Log::error('Error sending message: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getBookingDetails($booking)
    {
        try {
            if (!($booking instanceof Booking)) {
                $booking = Booking::where('id_Booking', $booking)->firstOrFail();
            }

            $booking->load([
                'paket.tingkatan', 
                'jenisKendaraan', 
                'pegawai', 
                'addons', 
                'diskon'
            ]);

            $response = [
                'id_Booking' => $booking->id_Booking,
                'nama' => $booking->nama,
                'email' => $booking->email,
                'nomor_telepon' => $booking->nomor_telepon,
                'alamat' => $booking->alamat,
                'nomor_polisi' => $booking->nomor_polisi,
                'status' => $booking->status,
                'tanggal' => $booking->tanggal,
                'harga' => $booking->harga,
                'catatan' => $booking->catatan,
                'metode' => $booking->metode,
                'diskon' => $booking->diskon,
                'id_jenis_kendaraan' => $booking->id_jenis_kendaraan,
                'id_Paket' => $booking->id_paket,
                'id_Pegawai' => $booking->id_Pegawai,
                'id_Addons' => $booking->id_addons,
                'id_Diskon' => $booking->id_Diskon,
            ];

            $response['jenis_kendaraan'] = $booking->jenisKendaraan ? [
                'id' => $booking->jenisKendaraan->id_jenis_kendaraan,
                'jenis_kendaraan' => $booking->jenisKendaraan->jenis_kendaraan,
                'nama_kendaraan' => $booking->jenisKendaraan->nama_kendaraan ?? null,
                'harga' => $booking->jenisKendaraan->harga ?? 0
            ] : null;

            $response['paket'] = $booking->paket ? [
                'id' => $booking->paket->id_Paket,
                'kategori_paket' => $booking->paket->kategori_paket,
                'tingkatan' => $booking->paket->tingkatan ? [
                    'tingkatan' => $booking->paket->tingkatan->Tingkatan,
                    'harga' => $booking->paket->tingkatan->harga
                ] : null
            ] : null;

            $response['pegawai'] = $booking->pegawai ? [
                'id' => $booking->pegawai->id_Pegawai,
                'nama' => $booking->pegawai->nama
            ] : null;

            $response['addons'] = $booking->addons ? [
                'id' => $booking->addons->id_addons,
                'nama' => $booking->addons->nama,
                'harga' => $booking->addons->harga
            ] : null;

            $response['diskonModel'] = $booking->diskon;
            $response['created_by_user'] = !$booking->metode;

            return response()->json($response, 200);

        } catch (\Exception $e) {
            Log::error('Error getting booking details', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function invoice($booking)
    {
        try {
            if (!($booking instanceof Booking)) {
                $booking = Booking::where('id_booking', $booking)->firstOrFail();
            }

            $booking->load(['paket', 'jenisKendaraan', 'pegawai', 'diskon', 'addons', 'user']);

            return view('admin.bookings.invoice', compact('booking'));
        } catch (\Exception $e) {
            Log::error('Error generating invoice: ' . $e->getMessage());
            return back()->with('error', 'Gagal membuat invoice: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $jenisKendaraans = JenisKendaraan::all();
        $pakets = Paket::with('tingkatan')->get();
        $addons = Addons::all();
        $diskons = Diskon::where('Berlaku_sampai', '>=', now())->get();
        $jenisPenanganans = Tingkatan::all();

        return view('bookings.create', compact(
            'jenisKendaraans', 
            'pakets', 
            'addons', 
            'diskons',
            'jenisPenanganans'
        ));
    }

    public function destroy($booking)
    {
        try {
            if (!($booking instanceof Booking)) {
                $booking = Booking::where('id_booking', $booking)->firstOrFail();
            }

            $booking->delete();

            return response()->json([
                'success' => true,
                'message' => 'Booking berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting booking: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getUnassignedBookings()
    {
        try {
            $bookings = Booking::whereNull('id_Pegawai')
                              ->where('status', 'InProgres')
                              ->with(['jenisKendaraan', 'paket', 'user'])
                              ->orderBy('tanggal', 'asc')
                              ->get();

            return response()->json([
                'success' => true,
                'data' => $bookings
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting unassigned bookings: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}