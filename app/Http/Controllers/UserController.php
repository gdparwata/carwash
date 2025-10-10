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

        $users = $query->latest()->paginate(10);

        // Statistik - hanya user dengan role 'user'
        $totalUser = User::where('role', 'user')->count();
        $activeUser = User::where('role', 'user')->count();
        $newUser = User::where('role', 'user')->whereDate('created_at', Carbon::today())->count();

        return view('admin.users.index', compact('users', 'totalUser', 'activeUser', 'newUser'));
    }

    /**
     * Form create user
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat!');
    }

    /**
     * Form edit user
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Hapus user
     */
  public function destroy(User $user)
{
    $user->delete(); // Gunakan parameter $user yang sudah di-inject
    return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
}
}