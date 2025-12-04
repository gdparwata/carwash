<?php

namespace App\Http\Controllers;

use App\Models\Tingkatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class TingkatanController extends Controller
{
    // GET - Tampilkan semua tingkatan (untuk admin)
    public function index()
    {
        // ✅ PENTING: Load relasi 'paket' agar dropdown bisa tampil dengan benar
        $tingkatans = Tingkatan::with('paket')->orderBy('id_Tingkatan', 'asc')->get();
        
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
            // ✅ PENTING: Load relasi 'paket'
            $tingkatans = Tingkatan::with('paket')->orderBy('id_Tingkatan', 'asc')->get();
            
            Log::info('Tingkatan API called', [
                'count' => $tingkatans->count(),
                'sample' => $tingkatans->first()
            ]);
            
            return response()->json($tingkatans, 200);
        } catch (\Exception $e) {
            Log::error('Error in getAll tingkatan: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // GET - Tampilkan satu tingkatan
    public function show($id)
    {
        try {
            // ✅ Load relasi 'paket'
            $tingkatan = Tingkatan::with('paket')->find($id);
            
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
            Log::info('Creating tingkatan', ['data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'id_paket' => 'required|exists:pakets,id_paket',
                'Tingkatan' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'harga' => 'required|numeric|min:0'
            ], [
                'id_paket.required' => 'Paket wajib dipilih',
                'id_paket.exists' => 'Paket tidak valid',
                'Tingkatan.required' => 'Nama tingkatan wajib diisi',
                'deskripsi.required' => 'Deskripsi wajib diisi',
                'harga.required' => 'Harga wajib diisi',
                'harga.numeric' => 'Harga harus berupa angka',
            ]);

            if ($validator->fails()) {
                Log::warning('Validation failed', ['errors' => $validator->errors()]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $tingkatan = Tingkatan::create($request->all());
            
            // ✅ Load relasi setelah create
            $tingkatan->load('paket');
            
            Log::info('Tingkatan created', ['id' => $tingkatan->id_Tingkatan]);

            return response()->json([
                'status' => 'success',
                'message' => 'Tingkatan berhasil ditambahkan',
                'data' => $tingkatan
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating tingkatan: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // PUT - Update tingkatan
    public function update(Request $request, $id)
    {
        try {
            $tingkatan = Tingkatan::findOrFail($id);
            
            Log::info('Updating tingkatan', ['id' => $id, 'data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'id_paket' => 'required|exists:pakets,id_paket',
                'Tingkatan' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'harga' => 'required|numeric|min:0'
            ], [
                'id_paket.required' => 'Paket wajib dipilih',
                'id_paket.exists' => 'Paket tidak valid',
                'Tingkatan.required' => 'Nama tingkatan wajib diisi',
                'deskripsi.required' => 'Deskripsi wajib diisi',
                'harga.required' => 'Harga wajib diisi',
                'harga.numeric' => 'Harga harus berupa angka',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $tingkatan->update($request->all());
            
            // ✅ Load relasi setelah update
            $tingkatan->load('paket');
            
            Log::info('Tingkatan updated', ['id' => $id]);

            return response()->json([
                'status' => 'success',
                'message' => 'Tingkatan berhasil diperbarui',
                'data' => $tingkatan
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating tingkatan: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // DELETE - Hapus tingkatan
    public function destroy($id)
    {
        try {
            $tingkatan = Tingkatan::findOrFail($id);
            
            // Cek apakah tingkatan sedang digunakan
            if ($tingkatan->bookings()->count() > 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tingkatan tidak dapat dihapus karena sedang digunakan'
                ], 422);
            }

            $tingkatan->delete();
            
            Log::info('Tingkatan deleted', ['id' => $id]);

            return response()->json([
                'status' => 'success',
                'message' => 'Tingkatan berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting tingkatan: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}