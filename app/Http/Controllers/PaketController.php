<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Tingkatan;
use App\Models\JenisKendaraan;
use App\Models\Addons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaketController extends Controller
{
    // GET - Tampilkan halaman PUBLIC untuk user/guest
    public function publicIndex()
    {
        $pakets = Paket::with('tingkatan')->get();
        $tingkatans = Tingkatan::all();
        $jenisKendaraans = JenisKendaraan::all();
         $addons = Addons::all(); // atau sesuaikan nama modelnya
        return view('paket_harga.index', compact('pakets', 'tingkatans', 'jenisKendaraans', 'addons'));
    }

    // GET - Tampilkan halaman ADMIN untuk manajemen paket
    public function index()
    {
        $pakets = Paket::with('tingkatan')->get();
        $tingkatans = Tingkatan::all();
        
        // Jika request dari AJAX/API, return JSON
        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json($pakets, 200);
        }
        
        // Jika request dari web, return view ADMIN
        return view('harga.index', compact('pakets', 'tingkatans'));
    }

    // GET - API untuk mendapatkan semua paket (dipanggil dari JavaScript)
    public function getAll()
    {
        try {
            $pakets = Paket::with('tingkatan')->get();
            return response()->json($pakets, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // GET - Tampilkan satu paket
    public function show(Paket $paket)
    {
        try {
            $paket->load('tingkatan');
            return response()->json($paket, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // POST - Tambah paket baru
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'kategori_paket' => 'required|string|max:100',
                'id_Tingkatan' => 'required|exists:tingkatans,id_Tingkatan'
            ], [
                'kategori_paket.required' => 'Kategori paket wajib diisi',
                'id_Tingkatan.required' => 'Tingkatan wajib dipilih',
                'id_Tingkatan.exists' => 'Tingkatan tidak valid'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $paket = Paket::create([
                'kategori_paket' => $request->kategori_paket,
                'id_Tingkatan' => $request->id_Tingkatan
            ]);

            $paket->load('tingkatan');

            return response()->json([
                'status' => 'success',
                'message' => 'Paket berhasil ditambahkan',
                'data' => $paket
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // PUT - Update paket
    public function update(Request $request, Paket $paket)
    {
        try {
            $validator = Validator::make($request->all(), [
                'kategori_paket' => 'required|string|max:100',
                'id_Tingkatan' => 'required|exists:tingkatans,id_Tingkatan'
            ], [
                'kategori_paket.required' => 'Kategori paket wajib diisi',
                'id_Tingkatan.required' => 'Tingkatan wajib dipilih',
                'id_Tingkatan.exists' => 'Tingkatan tidak valid'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $paket->update([
                'kategori_paket' => $request->kategori_paket,
                'id_Tingkatan' => $request->id_Tingkatan
            ]);

            $paket->load('tingkatan');

            return response()->json([
                'status' => 'success',
                'message' => 'Paket berhasil diperbarui',
                'data' => $paket
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // DELETE - Hapus paket
    public function destroy(Paket $paket)
    {
        try {
            $paket->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Paket berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // PATCH - Toggle status paket (jika ada field status di tabel)
    public function toggleStatus(Paket $paket)
    {
        try {
            // Jika tabel paket punya field 'status'
            if (isset($paket->status)) {
                $paket->update(['status' => !$paket->status]);
                
                return response()->json([
                    'status' => 'success',
                    'message' => 'Status paket berhasil diubah',
                    'data' => $paket
                ], 200);
            }
            
            return response()->json([
                'status' => 'error',
                'message' => 'Field status tidak tersedia'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}