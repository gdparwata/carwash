<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    /**
     * Display the about us page for users (public view)
     */
    public function show()
    {
        $profils = AboutUs::orderBy('id', 'asc')->get();
        return view('aboutus', compact('profils'));
    }

    /**
     * Display the admin management page
     */
    public function index()
    {
        $profils = AboutUs::orderBy('id', 'asc')->get();
        return view('admin.aboutus.index', compact('profils'));
    }

    /**
     * Store a new article
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'judul' => $request->judul,
            'isi' => $request->isi
        ];

        // PERBAIKAN: Simpan langsung ke folder 'aboutus'
        if ($request->hasFile('foto')) {
            // Method 1: Auto-generated filename (lebih aman)
            $path = $request->file('foto')->store('aboutus', 'public');
            // Hasil: aboutus/randomstring.jpg
            
            // Method 2: Custom filename (jika ingin pakai timestamp)
            // $filename = time() . '_' . $request->file('foto')->getClientOriginalName();
            // $path = $request->file('foto')->storeAs('aboutus', $filename, 'public');
            // Hasil: aboutus/timestamp_filename.jpg
            
            $data['foto'] = $path;
        }

        AboutUs::create($data);

        return redirect()->route('admin.aboutus.index')
            ->with('success', 'Artikel berhasil ditambahkan!');
    }

    /**
     * Update an existing article
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $profil = AboutUs::findOrFail($id);

        $data = [
            'judul' => $request->judul,
            'isi' => $request->isi
        ];

        // PERBAIKAN: Handle upload dengan benar
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($profil->foto && Storage::disk('public')->exists($profil->foto)) {
                Storage::disk('public')->delete($profil->foto);
            }

            // Upload foto baru
            $path = $request->file('foto')->store('aboutus', 'public');
            $data['foto'] = $path;
        }

        $profil->update($data);

        return redirect()->route('admin.aboutus.index')
            ->with('success', 'Artikel berhasil diperbarui!');
    }

    /**
     * Delete an article
     */
    public function destroy($id)
    {
        $profil = AboutUs::findOrFail($id);

        // Delete image if exists
        if ($profil->foto && Storage::disk('public')->exists($profil->foto)) {
            Storage::disk('public')->delete($profil->foto);
        }

        $profil->delete();

        return redirect()->route('admin.aboutus.index')
            ->with('success', 'Artikel berhasil dihapus!');
    }
}