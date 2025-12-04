<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Addons;
use App\Models\JenisKendaraan;
use App\Models\Tingkatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaketController extends Controller
{
    /**
     * Halaman CRUD Admin untuk Paket
     * View: resources/views/Harga/index.blade.php
     */
    public function index()
    {
        try {
            // Return view CRUD admin (dari folder Harga)
            return view('Harga.index'); // ✅ Sesuai struktur folder Anda
        } catch (\Exception $e) {
            Log::error('Error loading admin paket page: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat halaman paket');
        }
    }

    /**
     * API untuk load data paket (dipanggil dari JavaScript di halaman CRUD)
     */
    public function getAll()
    {
        try {
            $pakets = Paket::with('tingkatans')->get();
            return response()->json($pakets, 200);
        } catch (\Exception $e) {
            Log::error('Error fetching pakets: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Halaman public untuk customer
     * View: resources/views/paket_harga/index.blade.php
     */
    public function publicIndex()
    {
        try {
            $pakets = Paket::with(['tingkatan'])->get();
            $jenisKendaraans = JenisKendaraan::all();
            $allAddons = Addons::with('pakets')->get();
            
            $addonsCuci = $allAddons->filter(function($addon) {
                return $addon->pakets->contains(function($paket) {
                    return stripos($paket->kategori_paket, 'Cuci') !== false;
                });
            });
            
            $addonsBanjir = $allAddons->filter(function($addon) {
                return $addon->pakets->contains(function($paket) {
                    return stripos($paket->kategori_paket, 'Banjir') !== false;
                });
            });
            
            $addonsSalon = $allAddons->filter(function($addon) {
                return $addon->pakets->contains(function($paket) {
                    return stripos($paket->kategori_paket, 'Salon') !== false;
                });
            });
            
            return view('paket_harga.index', compact(
                'pakets',
                'jenisKendaraans',
                'addonsCuci',
                'addonsBanjir',
                'addonsSalon'
            ));
        } catch (\Exception $e) {
            Log::error('Error loading public paket page: ' . $e->getMessage());
            return view('paket_harga.index', [
                'pakets' => collect([]),
                'jenisKendaraans' => collect([]),
                'addonsCuci' => collect([]),
                'addonsBanjir' => collect([]),
                'addonsSalon' => collect([])
            ])->with('error', 'Gagal memuat data paket');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'kategori_paket' => 'required|string|max:100'
            ]);
            
            $paket = Paket::create($validated);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Paket berhasil ditambahkan',
                'data' => $paket
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating paket: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $paket = Paket::findOrFail($id);
            
            $validated = $request->validate([
                'kategori_paket' => 'required|string|max:100'
            ]);
            
            $paket->update($validated);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Paket berhasil diupdate',
                'data' => $paket
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating paket: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $paket = Paket::findOrFail($id);
            $paket->delete();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Paket berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting paket: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}