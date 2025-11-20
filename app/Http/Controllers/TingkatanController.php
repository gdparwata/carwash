<?php

namespace App\Http\Controllers;

use App\Models\Tingkatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TingkatanController extends Controller
{
    // GET - Tampilkan semua tingkatan (untuk admin)
    public function index()
    {
        $tingkatans = Tingkatan::orderBy('id_Tingkatan', 'asc')->get();
        
        // Jika request dari AJAX/API, return JSON
        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json($tingkatans, 200);
        }
        
        // Jika request dari web, return view
        return view('admin.tingkatans.index', compact('tingkatans'));
    }

    

    // GET - API untuk mendapatkan semua tingkatan (dipanggil dari JavaScript)
    public function getAll()
    {
        try {
            $tingkatans = Tingkatan::orderBy('id_Tingkatan', 'asc')->get();
            return response()->json($tingkatans, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // GET - Tampilkan satu tingkatan
    public function show($id)
    {
        try {
            $tingkatan = Tingkatan::find($id);
            
            if (!$tingkatan) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tingkatan tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $tingkatan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // POST - Tambah tingkatan baru
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'Tingkatan' => 'required|string|max:50',
                'deskripsi' => 'required|string',
                'harga' => 'required|numeric|min:0'
            ], [
                'Tingkatan.required' => 'Nama tingkatan wajib diisi',
                'deskripsi.required' => 'Deskripsi wajib diisi',
                'harga.required' => 'Harga wajib diisi',
                'harga.numeric' => 'Harga harus berupa angka',
                'harga.min' => 'Harga tidak boleh kurang dari 0'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $tingkatan = Tingkatan::create([
                'Tingkatan' => $request->Tingkatan,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Tingkatan berhasil ditambahkan',
                'data' => $tingkatan
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // PUT - Update tingkatan
    public function update(Request $request, Tingkatan $tingkatan)
    {
        try {
            $validator = Validator::make($request->all(), [
                'Tingkatan' => 'required|string|max:50',
                'deskripsi' => 'required|string',
                'harga' => 'required|numeric|min:0'
            ], [
                'Tingkatan.required' => 'Nama tingkatan wajib diisi',
                'deskripsi.required' => 'Deskripsi wajib diisi',
                'harga.required' => 'Harga wajib diisi',
                'harga.numeric' => 'Harga harus berupa angka',
                'harga.min' => 'Harga tidak boleh kurang dari 0'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $tingkatan->update([
                'Tingkatan' => $request->Tingkatan,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Tingkatan berhasil diperbarui',
                'data' => $tingkatan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // DELETE - Hapus tingkatan
    public function destroy(Tingkatan $tingkatan)
    {
        try {
            // Cek apakah tingkatan sedang digunakan oleh paket
            if ($tingkatan->pakets()->count() > 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tingkatan tidak dapat dihapus karena sedang digunakan oleh paket'
                ], 422);
            }

            $tingkatan->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Tingkatan berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}