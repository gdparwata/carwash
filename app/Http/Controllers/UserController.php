<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Tampilkan daftar user
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'user'); // Filter hanya role user

        // Filter pencarian nama / email
        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->q}%")
                  ->orWhere('email', 'like', "%{$request->q}%");
            });
        }

        // Filter tanggal daftar
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // PENTING: Gunakan paginate() agar links() bisa digunakan
        $users = $query->latest()->paginate(10);

        // Statistik - hanya user dengan role 'user'
        $totalUser = User::where('role', 'user')->count();
        $activeUser = User::where('role', 'user')->count();
        $newUser = User::where('role', 'user')->whereDate('created_at', Carbon::today())->count();

        return view('admin.users.index', compact('users', 'totalUser', 'activeUser', 'newUser'));
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'nama_belakang'   => 'nullable|string|max:255',
            'email'           => 'required|string|email|unique:users,email',
            'no_telepon'      => 'nullable|string|max:20',
            'alamat'          => 'nullable|string',
            'password'        => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name'            => $request->name,
            'nama_belakang'   => $request->nama_belakang,
            'email'           => $request->email,
            'no_telepon'      => $request->no_telepon,
            'alamat'          => $request->alamat,
            'password'        => Hash::make($request->password),
            'role'            => 'user', // Set default role
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat!');
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'nama_belakang'   => 'nullable|string|max:255',
            'email'           => 'required|string|email|unique:users,email,' . $user->id_User . ',id_User',
            'no_telepon'      => 'nullable|string|max:20',
            'alamat'          => 'nullable|string',
            'password'        => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name'            => $request->name,
            'nama_belakang'   => $request->nama_belakang,
            'email'           => $request->email,
            'no_telepon'      => $request->no_telepon,
            'alamat'          => $request->alamat,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Hapus user (Soft Delete)
     */
    public function destroy(User $user)
    {
        // Pastikan tidak menghapus diri sendiri
        if ($user->id_User === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        // Soft delete
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }

    /**
     * Tampilkan user yang dihapus (Trashed)
     */
    public function trashed()
    {
        $users = User::where('role', 'user')
            ->onlyTrashed()
            ->latest()
            ->paginate(10);
        
        $totalTrashed = User::where('role', 'user')->onlyTrashed()->count();
        
        return view('admin.users.trashed', compact('users', 'totalTrashed'));
    }

    /**
     * Restore user yang dihapus
     */
    public function restore(User $user)
    {
        $user->restore();
        
        return redirect()->route('admin.users.trashed')
            ->with('success', 'User berhasil dipulihkan!');
    }

    /**
     * Hapus permanen user
     */
    public function forceDelete(User $user)
    {
        // Pastikan user sudah di-soft delete
        if (!$user->trashed()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'User harus dihapus terlebih dahulu sebelum dihapus permanen!');
        }

        $user->forceDelete();
        
        return redirect()->route('admin.users.trashed')
            ->with('success', 'User berhasil dihapus permanen!');
    }

}