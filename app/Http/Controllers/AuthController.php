<?php
// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Landing page
    public function welcome()
    {
        return view('welcome');
    }

    // Show login form
    public function showLogin()
    {
        // Redirect jika sudah login
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }
        
        return view('auth.login');
    }

    // Process login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:3',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 3 karakter',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->redirectToDashboard();
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Dashboard berdasarkan role
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Redirect berdasarkan role
        switch ($user->role) {
            case 'owner':
                return view('dashboard.owner', compact('user'));
            case 'admin':
                return view('dashboard.admin', compact('user'));
            default:
                return view('dashboard.user', compact('user'));
        }
    }

    // Owner dashboard
    public function ownerDashboard()
    {
        if (!Auth::check() || Auth::user()->role !== 'owner') {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();
        
        // Data statistik dummy
        $stats = [
            'total_revenue' => 15500000,
            'orders_today' => 25,
            'active_users' => User::where('role', 'user')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_users' => User::count(),
        ];

        return view('dashboard.owner', compact('user', 'stats'));
    }

    // Admin dashboard - FIXED VERSION
    public function adminDashboard()
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'owner'])) {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();
        
        // ✅ Ambil 5 user terbaru untuk dashboard
        $users = User::where('role', 'user')
            ->latest()
            ->take(5)
            ->get();
        
        // ✅ Hitung statistik real
        $totalUser = User::where('role', 'user')->count();
        $activeUser = User::where('role', 'user')->count(); // Bisa disesuaikan dengan logic "active"
        $newUser = User::where('role', 'user')
            ->whereDate('created_at', \Carbon\Carbon::today())
            ->count();
        
        // Check apakah total user lebih dari 5 (untuk tombol "Lihat Selengkapnya")
        $hasMoreUsers = $totalUser > 5;
        
        // Data untuk admin
        $data = [
            'total_users' => $totalUser,
            'total_orders' => 142, // dummy data - bisa diganti dengan query real
            'pending_orders' => 8,  // dummy data - bisa diganti dengan query real
        ];

        // ✅ Kirim semua variabel ke view
        return view('dashboard.admin', compact('user', 'data', 'users', 'totalUser', 'activeUser', 'newUser', 'hasMoreUsers'));
    }

    // User dashboard
    public function userDashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Data untuk user biasa
        $userStats = [
            'total_bookings' => 5,  // dummy data
            'last_service' => '2025-08-25', // dummy data
            'loyalty_points' => 150, // dummy data
        ];

        return view('dashboard.user', compact('user', 'userStats'));
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('welcome')->with('success', 'Berhasil logout');
    }

    // Helper method untuk redirect setelah login
    private function redirectToDashboard()
    {
        $user = Auth::user();
        
        switch ($user->role) {
            case 'owner':
                return redirect()->route('dashboard.owner');
            case 'admin':
                return redirect()->route('dashboard.admin');
            default:
                return redirect()->route('dashboard.user');
        }
    }

    // Tampilkan form register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')
                         ->with('success', 'Registrasi berhasil! Silakan login.');
    }
}