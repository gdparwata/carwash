<?php

namespace App\Http\Controllers;

use App\Models\Addons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AddonsController extends Controller
{
    /**
     * Display a listing of addons (API)
     */
    public function index()
{
    try {
        // Load addons dengan relasi pakets
        $addons = Addons::with('pakets')->get();
        
        return response()->json($addons, 200);
    } catch (\Exception $e) {
        Log::error('Error fetching addons: ' . $e->getMessage());
        return response()->json([
            'message' => 'Error fetching addons',
            'error' => $e->getMessage()
        ], 500);
    }
}
    /**
     * Store a newly created addon
     */
    public function store(Request $request)
    {
        try {
            Log::info('Addon Store Request:', $request->all());
            
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'harga' => 'required|numeric|min:0'
            ]);
            
            $addon = Addons::create($validated);
            
            // Load relasi untuk response
            $addon->load('pakets');
            
            Log::info('Addon created successfully:', $addon->toArray());
            
            return response()->json($addon, 201);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error:', $e->errors());
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error creating addon: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error creating addon',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified addon
     */
    public function show($id)
    {
        try {
            $addon = Addons::with('pakets')->findOrFail($id);
            return response()->json($addon, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Addon not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error fetching addon: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error fetching addon',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified addon
     */
    public function update(Request $request, $id)
    {
        try {
            Log::info("Addon Update Request for ID {$id}:", $request->all());
            
            $addon = Addons::findOrFail($id);
            
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'harga' => 'required|numeric|min:0'
            ]);
            
            $addon->update($validated);
            
            // Load relasi untuk response
            $addon->load('pakets');
            
            Log::info('Addon updated successfully:', $addon->toArray());
            
            return response()->json($addon, 200);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Addon not found'
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error:', $e->errors());
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error updating addon: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error updating addon',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified addon
     */
    public function destroy($id)
    {
        try {
            Log::info("Addon Delete Request for ID: {$id}");
            
            $addon = Addons::findOrFail($id);
            
            // Detach semua relasi paket sebelum delete
            $addon->pakets()->detach();
            
            $addon->delete();
            
            Log::info('Addon deleted successfully: ' . $id);
            
            return response()->json([
                'message' => 'Addon deleted successfully'
            ], 200);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Addon not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error deleting addon: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error deleting addon',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Attach addon to paket
     */
    public function attachToPaket(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'id_paket' => 'required|exists:pakets,id_Paket'
            ]);
            
            $addon = Addons::findOrFail($id);
            
            // Attach (akan ignore jika sudah ada)
            $addon->pakets()->syncWithoutDetaching([$validated['id_paket']]);
            
            $addon->load('pakets');
            
            return response()->json([
                'message' => 'Addon attached to paket successfully',
                'addon' => $addon
            ], 200);
            
        } catch (\Exception $e) {
            Log::error('Error attaching addon to paket: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error attaching addon to paket',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Detach addon from paket
     */
    public function detachFromPaket(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'id_paket' => 'required|exists:pakets,id_Paket'
            ]);
            
            $addon = Addons::findOrFail($id);
            
            // Detach
            $addon->pakets()->detach($validated['id_paket']);
            
            $addon->load('pakets');
            
            return response()->json([
                'message' => 'Addon detached from paket successfully',
                'addon' => $addon
            ], 200);
            
        } catch (\Exception $e) {
            Log::error('Error detaching addon from paket: ' . $e->getMessage());
            return response()->json([
'message' => 'Error detaching addon from paket',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}