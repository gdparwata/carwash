<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil pengguna.
     */
    public function show()
    {
        $user = Auth::user();
        
        // Arahkan berdasarkan role
        if (in_array($user->role, ['admin', 'owner'])) {
            return view('admin.profile.show', compact('user'));
        }
        
        return view('profile.show', compact('user'));
    }

    /**
     * Perbarui informasi profil pengguna.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nama_belakang' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id_User . ',id_User',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Perbarui password pengguna.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'password.required' => 'Password baru wajib diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        $user = Auth::user();

        // Cek apakah password saat ini benar
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }

    /**
     * Perbarui foto profil.
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'photo.required' => 'Foto wajib dipilih',
            'photo.image' => 'File harus berupa gambar',
            'photo.mimes' => 'Format foto harus jpeg, png, atau jpg',
            'photo.max' => 'Ukuran foto maksimal 2MB',
        ]);

        $user = Auth::user();

        // Hapus foto lama jika ada
        if ($user->foto_profile && Storage::disk('public')->exists($user->foto_profile)) {
            Storage::disk('public')->delete($user->foto_profile);
        }

        // Simpan foto baru
        $path = $request->file('photo')->store('profile-photos', 'public');

        $user->update([
            'foto_profile' => $path
        ]);

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    /**
     * Hapus foto profil.
     */
    public function deletePhoto()
    {
        $user = Auth::user();

        if ($user->foto_profile && Storage::disk('public')->exists($user->foto_profile)) {
            Storage::disk('public')->delete($user->foto_profile);
        }

        $user->update([
            'foto_profile' => null
        ]);

        return back()->with('success', 'Foto profil berhasil dihapus!');
    }
}