<?php

use App\Http\Controllers\Owner\DashboardController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\JenisKendaraanController;
use App\Http\Controllers\TingkatanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AddonsController;  
use App\Http\Controllers\AboutUsController;

// =========================
// LANDING PAGE
// =========================
Route::get('/', [AuthController::class, 'welcome'])->name('welcome');

// =========================
// AUTH ROUTES
// =========================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// =========================
// PUBLIC BLOG ROUTES
// =========================
Route::get('/blog', action: [BlogController::class, 'publicIndex'])->name('blogs.index');
Route::get('/blog/{id_blog}', [BlogController::class, 'show'])->name('blogs.show');

Route::get('/cucimobil', function () {
    return view('viewpaket.cucimobil');
})->name('cucimobil');

Route::get('/paketbanjir', function () {
    return view('viewpaket.paketbanjir');
})->name('paketbanjir');

Route::get('/salonmobil', function () {
    return view('viewpaket.salonmobil');
})->name('salonmobil');

Route::get('/aboutus', function () {
    return view('aboutus');
})->name('aboutus');

// =========================
// PROTECTED DASHBOARD ROUTES
// =========================
Route::middleware('auth')->group(function () {

    Route::get('/pakets', [PaketController::class, 'apiIndex']);
    Route::get('/diskons', [DiskonController::class, 'apiIndex']);
    Route::get('/tingkatans', [TingkatanController::class, 'apiIndex']);

    // ============================================
    // MAIN DASHBOARD ROUTE - REDIRECT BASED ON ROLE
    // ============================================
    Route::get('/dashboard', function() {
        $user = auth()->user();
        $periode = request('periode', 'bulan_ini');
        
        switch ($user->role) {
            case 'owner':
                return redirect()->route('owner.dashboard', ['periode' => $periode]);
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'user':
                return redirect()->route('dashboard.user');
            default:
                return redirect()->route('welcome');
        }
    })->name('dashboard');

    // ============================================
    // SPECIFIC ROLE DASHBOARDS
    // ============================================
    // Owner Dashboard - LANGSUNG DI SINI (Sebelum middleware owner)
    Route::get('/dashboard/owner', [DashboardController::class, 'index'])
        ->middleware('role:owner')
        ->name('dashboard.owner');
    
    // Admin & User Dashboards
    Route::get('/dashboard/admin', [AuthController::class, 'adminDashboard'])->name('dashboard.admin');
    Route::get('/dashboard/user', [AuthController::class, 'userDashboard'])->name('dashboard.user');

    // =========================
    // PROFILE ROUTES
    // =========================
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');

    // =========================
    // USER BOOKING ROUTES
    // =========================
  Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/bookings', [BookingController::class, 'storeUserBooking'])->name('bookings.store');

    // =========================
    // API ROUTES (Inside Auth Middleware)
    // =========================
    Route::prefix('api')->group(function () {
        Route::get('/jenis-kendaraans', [JenisKendaraanController::class, 'getAll'])->name('api.jenis-kendaraans');
        Route::get('/pakets', [PaketController::class, 'getAll'])->name('api.pakets');
        Route::get('/pegawais', [PegawaiController::class, 'getAll'])->name('api.pegawais');
        Route::get('/diskons', [DiskonController::class, 'getAll'])->name('api.diskons');
        Route::get('/tingkatans', [TingkatanController::class, 'getAll'])->name('api.tingkatans');

         Route::get('/addons', [AddonsController::class, 'index'])->name('api.addons.index');
        Route::get('/addons/{id}', [AddonsController::class, 'show'])->name('api.addons.show');
        Route::post('/addons', [AddonsController::class, 'store'])->name('api.addons.store');
        Route::put('/addons/{id}', [AddonsController::class, 'update'])->name('api.addons.update');
        Route::delete('/addons/{id}', [AddonsController::class, 'destroy'])->name('api.addons.destroy');

         Route::post('/addons/{id}/attach-paket', [AddonsController::class, 'attachToPaket']);
    Route::post('/addons/{id}/detach-paket', [AddonsController::class, 'detachFromPaket']);
        
        
        // API khusus untuk sistem pegawai
        Route::get('/admins', [PegawaiController::class, 'getAdminData'])->name('api.admins');
        Route::get('/statistik-data', [PegawaiController::class, 'getStatistikData'])->name('api.statistik');
        Route::get('/pegawais-dropdown', [PegawaiController::class, 'getPegawaiDropdown'])->name('api.pegawais.dropdown');
        Route::get('/admins-dropdown', [PegawaiController::class, 'getAdminDropdown'])->name('api.admins.dropdown');
        
        // API untuk available pegawai berdasarkan tanggal
        Route::post('/available-pegawai', [BookingController::class, 'getAvailablePegawai'])->name('api.available-pegawai');
    });

    // =========================
    // ADMIN AREA (Admin + Owner bisa akses)
    // =========================
    Route::middleware(['role:admin,owner'])->prefix('admin')->name('admin.')->group(function () {
        
        // Dashboard Admin
        Route::get('/dashboard', [AuthController::class, 'adminDashboard'])->name('dashboard');
        Route::get('/dashboard-real', [AdminController::class, 'index'])->name('dashboard.real');

        // Profile Admin
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

        // Booking Management
        Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
        Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
        Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
        Route::get('/bookings/{booking}/details', [BookingController::class, 'getBookingDetails'])->name('bookings.details');
        Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
        Route::post('/bookings/{booking}/assign-pegawai', [BookingController::class, 'assignPegawai'])->name('bookings.assignPegawai');
        Route::get('/bookings/{booking}/invoice', [BookingController::class, 'invoice'])->name('bookings.invoice');
        Route::post('/bookings/{booking}/send-message', [BookingController::class, 'sendMessage'])->name('bookings.send-message');
        Route::get('/bookings-unassigned', [BookingController::class, 'getUnassignedBookings'])->name('bookings.unassigned');
        // Tambahkan di dalam grup admin

        Route::get('/aboutus', [AboutUsController::class, 'index'])->name('aboutus.index');
        Route::get('/aboutus/create', [AboutUsController::class, 'create'])->name('aboutus.create');
        Route::post('/aboutus', [AboutUsController::class, 'store'])->name('aboutus.store');
        Route::get('/aboutus/{id}/edit', [AboutUsController::class, 'edit'])->name('aboutus.edit');
        Route::put('/aboutus/{id}', [AboutUsController::class, 'update'])->name('aboutus.update');
        Route::delete('/aboutus/{id}', [AboutUsController::class, 'destroy'])->name('aboutus.destroy');
       

        // User Management
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // User Management - Restore & Force Delete  
        Route::get('/users/trashed', [UserController::class, 'trashed'])->name('users.trashed');
        Route::post('/users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
        Route::delete('/users/{user}/force', [UserController::class, 'forceDelete'])->name('users.force-delete');

        // Blog Management
        Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
        Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
        Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
        Route::put('/blogs/{blog}', [BlogController::class, 'update'])->name('blogs.update');
        Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');

        // Paket Management
        Route::get('/pakets', [PaketController::class, 'index'])->name('pakets.index');
        Route::post('/pakets', [PaketController::class, 'store'])->name('pakets.store');
        Route::put('/pakets/{paket}', [PaketController::class, 'update'])->name('pakets.update');
        Route::delete('/pakets/{paket}', [PaketController::class, 'destroy'])->name('pakets.destroy');
        Route::patch('/pakets/{paket}/toggle-status', [PaketController::class, 'toggleStatus'])->name('pakets.toggle-status');

        // Diskon Management
        Route::get('/diskons', [DiskonController::class, 'index'])->name('diskons.index');
        Route::post('/diskons', [DiskonController::class, 'store'])->name('diskons.store');
        Route::put('/diskons/{diskon}', [DiskonController::class, 'update'])->name('diskons.update');
        Route::delete('/diskons/{diskon}', [DiskonController::class, 'destroy'])->name('diskons.destroy');
        Route::patch('/diskons/{diskon}/toggle-status', [DiskonController::class, 'toggleStatus'])->name('diskons.toggle-status');

        // Jenis Kendaraan Management
        Route::get('/jenis-kendaraans', [JenisKendaraanController::class, 'index'])->name('jenis-kendaraans.index');
        Route::post('/jenis-kendaraans', [JenisKendaraanController::class, 'store'])->name('jenis-kendaraans.store');
        Route::put('/jenis-kendaraans/{jenisKendaraan}', [JenisKendaraanController::class, 'update'])->name('jenis-kendaraans.update');
        Route::delete('/jenis-kendaraans/{jenisKendaraan}', [JenisKendaraanController::class, 'destroy'])->name('jenis-kendaraans.destroy');

        // Tingkatan Management
        Route::get('/tingkatans', [TingkatanController::class, 'index'])->name('tingkatans.index');
        Route::post('/tingkatans', [TingkatanController::class, 'store'])->name('tingkatans.store');
        Route::put('/tingkatans/{tingkatan}', [TingkatanController::class, 'update'])->name('tingkatans.update');
        Route::delete('/tingkatans/{tingkatan}', [TingkatanController::class, 'destroy'])->name('tingkatans.destroy');

         // 🆕 Addons Management
    Route::get('/addons', [\App\Http\Controllers\AddonsController::class, 'index'])->name('addons.index');
    Route::post('/addons', [\App\Http\Controllers\AddonsController::class, 'store'])->name('addons.store');
    Route::put('/addons/{id}', [\App\Http\Controllers\AddonsController::class, 'update'])->name('addons.update');
    Route::delete('/addons/{id}', [\App\Http\Controllers\AddonsController::class, 'destroy'])->name('addons.destroy');
    });
      Route::post('/api/available-pegawai', [BookingController::class, 'getAvailablePegawai']);
    Route::post('/api/tingkatan-by-paket', [BookingController::class, 'getTingkatanByPaket']);
        Route::post('api/addons-by-paket', [BookingController::class, 'getAddonsByPaket']); // ← TAMBAH INI

    // =========================
    // OWNER EXCLUSIVE AREA (Hanya Owner)
    // =========================
    Route::middleware(['role:owner'])->prefix('owner')->name('owner.')->group(function () {

        // ============================================
        // DASHBOARD OWNER - DENGAN PERIODE SUPPORT
        // ============================================
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/refresh', [DashboardController::class, 'refresh'])->name('dashboard.refresh');

        // Pegawai Management
        Route::get('/pegawais', [PegawaiController::class, 'index'])->name('pegawais.index');
        Route::post('/pegawais', [PegawaiController::class, 'store'])->name('pegawais.store');
        Route::get('/pegawais/{id}/edit', [PegawaiController::class, 'edit'])->name('pegawais.edit');
        Route::put('/pegawais/{id}', [PegawaiController::class, 'update'])->name('pegawais.update');
        Route::delete('/pegawais/{id}', [PegawaiController::class, 'destroy'])->name('pegawais.destroy');

        // Admin User Management
        Route::get('/admins', [PegawaiController::class, 'adminIndex'])->name('admins.index');
        Route::post('/admins', [PegawaiController::class, 'storeAdmin'])->name('admins.store');
        Route::get('/admins/{id}/edit', [PegawaiController::class, 'editAdmin'])->name('admins.edit');
        Route::put('/admins/{id}', [PegawaiController::class, 'updateAdmin'])->name('admins.update');
        Route::delete('/admins/{id}', [PegawaiController::class, 'destroyAdmin'])->name('admins.destroy');

        // Libur Management
        Route::get('/liburs', [PegawaiController::class, 'liburIndex'])->name('liburs.index');
        Route::post('/liburs', [PegawaiController::class, 'storeLibur'])->name('liburs.store');
        Route::get('/liburs/{id}/edit', [PegawaiController::class, 'editLibur'])->name('liburs.edit');
        Route::put('/liburs/{id}', [PegawaiController::class, 'updateLibur'])->name('liburs.update');
        Route::delete('/liburs/{id}', [PegawaiController::class, 'destroyLibur'])->name('liburs.destroy');

        // User Management (untuk delete user dari dashboard owner)
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Statistik
        Route::get('/statistik', [PegawaiController::class, 'statistik'])->name('statistik.index');
    });

}); // <- Penutup middleware('auth')

// =========================
// PUBLIC AREA
// =========================
Route::get('/harga/index', [PaketController::class, 'index'])->name('pakets.index.public');
Route::get('/paket_harga/index', [PaketController::class, 'publicIndex'])->name('paket.public');
Route::get('/aboutus', [AboutUsController::class, 'show'])->name('aboutus');