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
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BookingController extends Controller
{
    // ==================== HITUNG HARGA ====================
    private function calculatePrice($jenisKendaraanId, $tingkatanId, $addonsId = null, $diskonId = null, $metode = null)
    {
        $hargaJenis = JenisKendaraan::find($jenisKendaraanId)->harga ?? 0;
        $hargaPaket = Tingkatan::find($tingkatanId)->harga ?? 0;
        $hargaAddons = $addonsId ? (Addons::find($addonsId)->harga ?? 0) : 0;

        $subtotal = $hargaJenis + $hargaPaket + $hargaAddons;

        $diskonPersen = 0;
        $diskonNilai = 0;

        if ($metode === 'Tunai' && $diskonId) {
            $diskon = Diskon::find($diskonId);
            if ($diskon && $diskon->Berlaku_sampai >= now()) {
                $diskonPersen = $diskon->persen ?? 0;
                $diskonNilai = round(($subtotal * $diskonPersen) / 100);
            }
        }

        $hargaFinal = $subtotal - $diskonNilai;

        return [
            'harga' => $hargaFinal,
            'subtotal' => $subtotal,
            'diskon_persen' => $diskonPersen,
            'diskon_nilai' => $diskonNilai,
        ];
    }

    // ==================== INDEX ====================
    public function index(Request $request)
    {
        $query = Booking::with(['jenisKendaraan', 'paket', 'pegawai', 'addons']);

        if ($request->tanggal) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->kategori && $request->kategori != 'Sudah Selesai') {
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

    // ==================== CEK PEGAWAI LIBUR ====================
    public function getAvailablePegawai(Request $request)
    {
        if (!$request->tanggal) {
            return response()->json(['success' => false, 'message' => 'Tanggal harus diisi'], 422);
        }

        $hari = $this->getDayInIndonesian(Carbon::parse($request->tanggal)->dayOfWeek);

        $available = Pegawai::whereDoesntHave('liburs', function ($q) use ($hari) {
            $q->where('hari', $hari);
        })->get();

        return response()->json([
            'success' => true,
            'data' => $available,
            'hari' => $hari,
            'total_available' => $available->count()
        ]);
    }

    private function getDayInIndonesian($dayNumber)
    {
        return [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu'
        ][$dayNumber];
    }

    // ==================== STORE BOOKING ADMIN ====================
    public function store(Request $request)
    {
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
            'metode' => 'required|string|in:Tunai,Non Tunai',
            'id_Addons' => 'nullable|exists:addons,id_addons',
            'id_Diskon' => 'nullable|exists:diskons,id_Diskon',
            'jumlah_uang' => 'nullable|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $hari = $this->getDayInIndonesian(Carbon::parse($request->tanggal)->dayOfWeek);
        if (Libur::where('id_pegawai', $request->id_Pegawai)->where('hari', $hari)->exists()) {
            return response()->json(['success' => false, 'message' => 'Pegawai sedang libur'], 422);
        }

        // hitung harga fix
        $priceData = $this->calculatePrice(
            $request->id_jenis_kendaraan,
            $request->id_jenis_penanganan,
            $request->id_Addons,
            $request->id_Diskon,
            $request->metode
        );

        $booking = new Booking();
        $booking->fill([
            'nama' => $request->nama,
            'nomor_telepon' => $request->nomor_telepon,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'nomor_polisi' => $request->nomor_polisi,
            'tanggal' => $request->tanggal,
            'catatan' => $request->catatan,
            'metode' => $request->metode,
            'status' => 'InProgres',
            'id_jenis_kendaraan' => $request->id_jenis_kendaraan,
            'id_paket' => $request->id_Paket,
            'id_Pegawai' => $request->id_Pegawai,
            'id_addons' => $request->id_Addons,
            'id_Diskon' => $request->id_Diskon,
            'id_user' => auth()->id(),
        ]);

        $booking->harga = $priceData['harga'];
        $booking->diskon = $priceData['diskon_persen'];
        $booking->jumlah_uang = $request->jumlah_uang;
        $booking->kembalian = $request->jumlah_uang
            ? $request->jumlah_uang - $priceData['harga']
            : 0;
        $booking->save();

        DB::table('invoices')->insert([
            'id_booking' => $booking->id_Booking,
            'tanggal' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil disimpan!',
            'harga' => $priceData['harga']
        ]);
    }

    public function storeUserBooking(Request $request)
{
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
        'metode' => 'required|string|in:Tunai,Non Tunai', // ubah hidden input di form ke "Tunai"
        'id_Addons' => 'nullable|exists:addons,id_addons',
    ]);

    if ($validator->fails()) {
        return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
    }

    // hitung harga tanpa diskon
    $priceData = $this->calculatePrice(
        $request->id_jenis_kendaraan,
        $request->id_jenis_penanganan,
        $request->id_Addons,
        null,
        $request->metode
    );

    // buat booking baru
    $booking = new Booking();
    $booking->fill([
        'nama' => $request->nama,
        'nomor_telepon' => $request->nomor_telepon,
        'email' => $request->email,
        'alamat' => $request->alamat,
        'nomor_polisi' => $request->nomor_polisi,
        'tanggal' => $request->tanggal,
        'catatan' => $request->catatan,
        'metode' => $request->metode,
        'status' => 'Menunggu Konfirmasi',
        'id_jenis_kendaraan' => $request->id_jenis_kendaraan,
        'id_paket' => $request->id_Paket,
        'id_user' => auth()->id(),
        'id_addons' => $request->id_Addons,
        'harga' => $priceData['harga'],
    ]);

    $booking->save();

    return response()->json([
        'success' => true,
        'message' => 'Booking berhasil dikirim! Tunggu konfirmasi admin.',
        'harga' => $priceData['harga']
    ]);
}


    // ==================== UPDATE STATUS ====================
    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Done,Canceled,InProgres',
            'metode' => 'nullable|in:Tunai,Non Tunai',
            'jumlah_uang' => 'nullable|numeric|min:0',
            'id_diskon' => 'nullable|exists:diskons,id_Diskon'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $booking->status = $request->status;

        // kalau update jadi Done, pastiin harga direfresh
        if ($request->status === 'Done') {
            $priceData = $this->calculatePrice(
                $booking->id_jenis_kendaraan,
                $booking->paket->tingkatan->id_Tingkatan ?? null,
                $booking->id_addons,
                $request->id_diskon,
                $request->metode ?? $booking->metode
            );

            $booking->harga = $priceData['harga'];
            $booking->diskon = $priceData['diskon_persen'];
            $booking->metode = $request->metode ?? $booking->metode;
            $booking->tanggal_bayar = now();

            if ($request->metode === 'Tunai' && $request->jumlah_uang) {
                $booking->jumlah_uang = $request->jumlah_uang;
                $booking->kembalian = $request->jumlah_uang - $priceData['harga'];
            }
        }

        $booking->save();

        DB::table('invoices')->updateOrInsert(
            ['id_booking' => $booking->id_Booking],
            ['tanggal' => now(), 'updated_at' => now()]
        );

        return response()->json(['success' => true, 'message' => 'Status berhasil diupdate!']);
    }

    // ==================== INVOICE ====================
    public function invoice($id)
    {
        $booking = Booking::with(['jenisKendaraan', 'paket', 'addons', 'diskon', 'pegawai'])->findOrFail($id);

        $hargaKendaraan = $booking->jenisKendaraan->harga ?? 0;
        $hargaPaket = $booking->paket->harga ?? 0;
        $hargaAddons = $booking->addons->harga ?? 0;

        $subtotal = $hargaKendaraan + $hargaPaket + $hargaAddons;

        $diskonPersen = $booking->diskon ? ($booking->diskon->persen ?? 0) : 0;
        $diskonNilai = round(($subtotal * $diskonPersen) / 100);
        $totalAkhir = $subtotal - $diskonNilai;

        return view('admin.bookings.invoice', compact(
            'booking',
            'hargaKendaraan',
            'hargaPaket',
            'hargaAddons',
            'subtotal',
            'diskonPersen',
            'diskonNilai',
            'totalAkhir'
        ));
    }
    public function create()
{
    $pakets = Paket::with('tingkatan')->get();
    $jenisKendaraans = JenisKendaraan::all();
    $addons = Addons::all();
    $jenisPenanganans = Tingkatan::all();

    return view('bookings.create', compact(
        'pakets',
        'jenisKendaraans',
        'addons',
        'jenisPenanganans'
    ));
}

}
