<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class DiskonController extends Controller
{
    public function index()
    {
        $diskons = Diskon::orderBy('created_at', 'desc')->get();
        
        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json($diskons, 200);
        }
        
        return view('admin.diskons.index', compact('diskons'));
    }

    public function getAll()
    {
        try {
            $diskons = Diskon::orderBy('created_at', 'desc')->get();
            return response()->json($diskons, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $diskon = Diskon::find($id);
            
            if (!$diskon) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Diskon tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $diskon
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_diskon' => 'required|string|max:20|unique:diskons,id_diskon',
                'nama' => 'required|string|max:100',
                'persen' => 'required|numeric|min:0|max:100',
                'Berlaku_dari' => 'required|date',
                'Berlaku_sampai' => 'required|date|after:Berlaku_dari',
                'dibuat_oleh' => 'required|string|max:100'
            ], [
                'id_diskon.required' => 'Kode diskon wajib diisi',
                'id_diskon.unique' => 'Kode diskon sudah digunakan',
                'nama.required' => 'Nama diskon wajib diisi',
                'persen.required' => 'Persentase diskon wajib diisi',
                'persen.min' => 'Persentase minimal 0',
                'persen.max' => 'Persentase maksimal 100',
                'Berlaku_dari.required' => 'Tanggal mulai berlaku wajib diisi',
                'Berlaku_sampai.required' => 'Tanggal selesai berlaku wajib diisi',
                'Berlaku_sampai.after' => 'Tanggal selesai harus setelah tanggal mulai',
                'dibuat_oleh.required' => 'Pembuat diskon wajib diisi'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $diskon = Diskon::create([
                'id_diskon' => $request->id_diskon,
                'nama' => $request->nama,
                'persen' => $request->persen,
                'Berlaku_dari' => Carbon::parse($request->Berlaku_dari),
                'Berlaku_sampai' => Carbon::parse($request->Berlaku_sampai),
                'dibuat_oleh' => $request->dibuat_oleh
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Diskon berhasil ditambahkan',
                'data' => $diskon
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $diskon = Diskon::find($id);
            
            if (!$diskon) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Diskon tidak ditemukan'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:100',
                'persen' => 'required|numeric|min:0|max:100',
                'Berlaku_dari' => 'required|date',
                'Berlaku_sampai' => 'required|date|after:Berlaku_dari',
                'dibuat_oleh' => 'required|string|max:100'
            ], [
                'nama.required' => 'Nama diskon wajib diisi',
                'persen.required' => 'Persentase diskon wajib diisi',
                'persen.min' => 'Persentase minimal 0',
                'persen.max' => 'Persentase maksimal 100',
                'Berlaku_dari.required' => 'Tanggal mulai berlaku wajib diisi',
                'Berlaku_sampai.required' => 'Tanggal selesai berlaku wajib diisi',
                'Berlaku_sampai.after' => 'Tanggal selesai harus setelah tanggal mulai',
                'dibuat_oleh.required' => 'Pembuat diskon wajib diisi'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $diskon->update([
                'nama' => $request->nama,
                'persen' => $request->persen,
                'Berlaku_dari' => Carbon::parse($request->Berlaku_dari),
                'Berlaku_sampai' => Carbon::parse($request->Berlaku_sampai),
                'dibuat_oleh' => $request->dibuat_oleh
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Diskon berhasil diperbarui',
                'data' => $diskon
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $diskon = Diskon::find($id);
            
            if (!$diskon) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Diskon tidak ditemukan'
                ], 404);
            }

            // Cek apakah diskon sedang digunakan oleh booking
            if ($diskon->bookings()->count() > 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Diskon tidak dapat dihapus karena sedang digunakan pada booking'
                ], 422);
            }

            $diskon->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Diskon berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleStatus($id)
    {
        try {
            $diskon = Diskon::find($id);
            
            if (!$diskon) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Diskon tidak ditemukan'
                ], 404);
            }

            if (isset($diskon->status)) {
                $diskon->update(['status' => !$diskon->status]);
                
                return response()->json([
                    'status' => 'success',
                    'message' => 'Status diskon berhasil diubah',
                    'data' => $diskon
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