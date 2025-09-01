<?php
// routes/web.php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Landing page
Route::get('/', [AuthController::class, 'welcome'])->name('welcome');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Protected dashboard routes
Route::middleware('auth')->group(function () {
    
    // General dashboard (auto redirect berdasarkan role)
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    
    // Specific role dashboards
    Route::get('/dashboard/owner', [AuthController::class, 'ownerDashboard'])->name('dashboard.owner');
    Route::get('/dashboard/admin', [AuthController::class, 'adminDashboard'])->name('dashboard.admin');
    Route::get('/dashboard/user', [AuthController::class, 'userDashboard'])->name('dashboard.user');
    
});