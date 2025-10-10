<?php

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

// Landing page
Route::get('/', [AuthController::class, 'welcome'])->name('welcome');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// =========================
// PUBLIC BLOG ROUTES (untuk user/guest)
// =========================
Route::get('/blog', [BlogController::class, 'publicIndex'])->name('blogs.index');
Route::get('/blog/{id_blog}', [BlogController::class, 'show'])->name('blogs.show');

// Protected dashboard routes
Route::middleware('auth')->group(function () {
    
    // Dashboards
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/owner', [AuthController::class, 'ownerDashboard'])->name('dashboard.owner');
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
    // USER Booking routes 
    // =========================
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'storeUserBooking'])->name('bookings.store');

    // =========================
    // ADMIN routes
    // =========================
    Route::prefix('admin')->name('admin.')->group(function () {
        // Dashboard Admin
        Route::get('/dashboard', [AuthController::class, 'adminDashboard'])->name('dashboard');
        
        // Profile Admin
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        
        // **BOOKING ROUTES**
        Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
        Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
        Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
        
        // Booking specific actions
        Route::get('/bookings/{booking}/details', [BookingController::class, 'getBookingDetails'])
            ->name('bookings.details');
        Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])
            ->name('bookings.updateStatus');
        Route::post('/bookings/{booking}/assign-pegawai', [BookingController::class, 'assignPegawai'])
            ->name('bookings.assignPegawai');
        Route::get('/bookings/{booking}/invoice', [BookingController::class, 'invoice'])
            ->name('bookings.invoice');
        Route::post('/bookings/{booking}/send-message', [BookingController::class, 'sendMessage'])
            ->name('bookings.send-message');
        
        // Get unassigned bookings
        Route::get('/bookings-unassigned', [BookingController::class, 'getUnassignedBookings'])
            ->name('bookings.unassigned');

        // User Management
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Blog Management (ADMIN)
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
        
        // Statistik route
        Route::get('/statistik', [PegawaiController::class, 'statistik'])->name('statistik.index');

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
    });

    // Public routes untuk harga paket
    Route::get('/harga/index', [PaketController::class, 'index'])->name('pakets.index.public');
    // Public routes untuk harga paket (untuk user/guest)
Route::get('/paket_harga/index', [PaketController::class, 'publicIndex'])->name('paket.public');
    // API Routes
    Route::prefix('api')->group(function () {
        Route::get('/jenis-kendaraans', [JenisKendaraanController::class, 'getAll'])->name('api.jenis-kendaraans');
        Route::get('/pakets', [PaketController::class, 'getAll'])->name('api.pakets');
        Route::get('/pegawais', [PegawaiController::class, 'getAll'])->name('api.pegawais');
        Route::get('/diskons', [DiskonController::class, 'getAll'])->name('api.diskons');
        Route::get('/tingkatans', [TingkatanController::class, 'getAll'])->name('api.tingkatans');
        
        // API khusus untuk sistem pegawai
        Route::get('/admins', [PegawaiController::class, 'getAdminData'])->name('api.admins');
        Route::get('/statistik-data', [PegawaiController::class, 'getStatistikData'])->name('api.statistik');
        Route::get('/pegawais-dropdown', [PegawaiController::class, 'getPegawaiDropdown'])->name('api.pegawais.dropdown');
        Route::get('/admins-dropdown', [PegawaiController::class, 'getAdminDropdown'])->name('api.admins.dropdown');
        
        // API untuk available pegawai berdasarkan tanggal
        Route::post('/available-pegawai', [BookingController::class, 'getAvailablePegawai'])->name('api.available-pegawai');
    });
});

// ===== ROUTE UNTUK TESTING/DEBUG (HAPUS SETELAH PRODUCTION) =====
Route::get('/test-libur', function() {
    $today = now();
    $dayNumber = $today->dayOfWeek;
    $hariIndonesia = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'][$dayNumber];
    
    $allPegawai = \App\Models\Pegawai::all();
    $allLibur = \App\Models\Libur::with('pegawai')->get();
    $liburToday = \App\Models\Libur::where('hari', $hariIndonesia)
        ->whereNotNull('id_pegawai')
        ->with('pegawai')
        ->get();
    $availablePegawai = \App\Models\Pegawai::availableOnDay($hariIndonesia)->get();
    
    return response()->json([
        'today' => $today->format('Y-m-d H:i:s'),
        'day_number' => $dayNumber,
        'hari_indonesia' => $hariIndonesia,
        'total_pegawai' => $allPegawai->count(),
        'all_pegawai' => $allPegawai->map(function($p) {
            return [
                'id' => $p->id_Pegawai,
                'nama' => $p->nama,
                'libur_days' => $p->liburs->pluck('hari')->toArray()
            ];
        }),
        'all_libur_data' => $allLibur->map(function($l) {
            return [
                'id_libur' => $l->id_libur,
                'id_pegawai' => $l->id_pegawai,
                'pegawai_nama' => $l->pegawai ? $l->pegawai->nama : null,
                'hari' => $l->hari
            ];
        }),
        'pegawai_libur_today' => $liburToday->map(function($l) {
            return [
                'id' => $l->id_pegawai,
                'nama' => $l->pegawai ? $l->pegawai->nama : 'Unknown'
            ];
        }),
        'pegawai_tersedia_today' => $availablePegawai->map(function($p) {
            return [
                'id' => $p->id_Pegawai,
                'nama' => $p->nama
            ];
        })
    ]);
})->name('test.libur');

Route::get('/quick-test', function() {
    $results = [];
    
    $allPegawai = \App\Models\Pegawai::all();
    $results['total_pegawai'] = $allPegawai->count();
    $results['pegawai_list'] = $allPegawai->pluck('nama', 'id_Pegawai');
    
    $allLibur = \App\Models\Libur::with('pegawai')->get();
    $results['total_libur'] = $allLibur->count();
    $results['libur_list'] = $allLibur->map(function($l) {
        return [
            'id_libur' => $l->id_libur,
            'id_pegawai' => $l->id_pegawai,
            'pegawai' => $l->pegawai ? $l->pegawai->nama : 'NULL (Broken FK!)',
            'hari' => $l->hari
        ];
    });
    
    $firstPegawai = \App\Models\Pegawai::first();
    if ($firstPegawai) {
        $results['first_pegawai'] = [
            'id' => $firstPegawai->id_Pegawai,
            'nama' => $firstPegawai->nama,
            'libur_count' => $firstPegawai->liburs->count(),
            'libur_days' => $firstPegawai->liburs->pluck('hari')->toArray()
        ];
    }
    
    $today = now();
    $hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'][$today->dayOfWeek];
    $availableToday = \App\Models\Pegawai::availableOnDay($hari)->get();
    $results['today'] = [
        'date' => $today->format('Y-m-d'),
        'day_name' => $today->format('l'),
        'hari_indonesia' => $hari,
        'available_count' => $availableToday->count(),
        'available_names' => $availableToday->pluck('nama')->toArray()
    ];
    
    $brokenFK = \DB::select("
        SELECT l.id_libur, l.id_pegawai, l.hari
        FROM liburs l
        LEFT JOIN pegawais p ON l.id_pegawai = p.id_Pegawai
        WHERE l.id_pegawai IS NOT NULL AND p.id_Pegawai IS NULL
    ");
    $results['broken_fk'] = count($brokenFK) > 0 ? [
        'count' => count($brokenFK),
        'warning' => 'Ada data libur dengan FK broken! Perlu di-fix.',
        'data' => $brokenFK
    ] : 'OK - No broken FK';
    
    return response()->json($results, 200, [], JSON_PRETTY_PRINT);
})->name('test.quick');

Route::get('/test-date/{date}', function($date) {
    try {
        $carbonDate = \Carbon\Carbon::parse($date);
        $hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'][$carbonDate->dayOfWeek];
        
        $liburOnDate = \App\Models\Libur::where('hari', $hari)
            ->whereNotNull('id_pegawai')
            ->with('pegawai')
            ->get();
            
        $availableOnDate = \App\Models\Pegawai::availableOnDay($hari)->get();
        
        return response()->json([
            'date' => $carbonDate->format('Y-m-d'),
            'day_name' => $carbonDate->format('l'),
            'hari_indonesia' => $hari,
            'pegawai_libur' => $liburOnDate->map(function($l) {
                return [
                    'id' => $l->id_pegawai,
                    'nama' => $l->pegawai ? $l->pegawai->nama : 'Unknown'
                ];
            }),
            'pegawai_tersedia' => $availableOnDate->map(function($p) {
                return [
                    'id' => $p->id_Pegawai,
                    'nama' => $p->nama
                ];
            })
        ], 200, [], JSON_PRETTY_PRINT);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 400);
    }
})->name('test.date');

Route::get('/test-invoice-now', function() {
    try {
        // Ambil booking terakhir
        $booking = \App\Models\Booking::latest('id_booking')->first();
        
        if (!$booking) {
            return 'Tidak ada booking';
        }

        // Test insert dengan created_at & updated_at
        $result = DB::table('invoices')->insert([
            'id_booking' => $booking->id_booking,
            'tanggal' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Cek hasilnya
        $invoice = DB::table('invoices')
            ->where('id_booking', $booking->id_booking)
            ->first();

        return response()->json([
            'status' => $result ? 'INSERT SUCCESS' : 'INSERT FAILED',
            'booking_id' => $booking->id_booking,
            'invoice_found' => $invoice ? 'YES' : 'NO',
            'invoice_data' => $invoice,
            'total_invoices' => DB::table('invoices')->count()
        ], 200, [], JSON_PRETTY_PRINT);

    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'code' => $e->getCode(),
            'line' => $e->getLine()
        ]);
    }
});
Route::get('/test-invoice-now', function() {
    try {
        // Ambil booking terakhir
        $booking = \App\Models\Booking::latest('id_booking')->first();
        
        if (!$booking) {
            return 'Tidak ada booking';
        }

        // Test insert dengan created_at & updated_at
        $result = DB::table('invoices')->insert([
            'id_booking' => $booking->id_booking,
            'tanggal' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Cek hasilnya
        $invoice = DB::table('invoices')
            ->where('id_booking', $booking->id_booking)
            ->first();

        return response()->json([
            'status' => $result ? 'INSERT SUCCESS' : 'INSERT FAILED',
            'booking_id' => $booking->id_booking,
            'invoice_found' => $invoice ? 'YES' : 'NO',
            'invoice_data' => $invoice,
            'total_invoices' => DB::table('invoices')->count()
        ], 200, [], JSON_PRETTY_PRINT);

    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'code' => $e->getCode(),
            'line' => $e->getLine()
        ]);
    }
});