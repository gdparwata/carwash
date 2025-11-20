<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // FIX: Force default periode if not provided
        $periode = $request->input('periode', 'bulan_ini');
        
        // Ensure periode is valid
        if (!in_array($periode, ['bulan_ini', 'tahun_ini', 'all'])) {
            $periode = 'bulan_ini';
        }
        
        // Log untuk debugging
        \Log::info('========== DASHBOARD LOAD ==========');
        \Log::info('Requested periode: ' . $periode);
        \Log::info('Current date: ' . now()->toDateTimeString());
        
        // Initialize default values
        $stats = ['total_pendapatan' => 0, 'total_pesanan' => 0, 'pendapatan_bersih' => 0];
        $paket_populer = collect([]);
        $max_pesanan = 1;
        $trend = collect([]);
        $aktivitas = collect([]);
        $layanan_performa = collect([]);
        $users = collect([]);
        
        try {
            // Debug: Cek total booking di database
            $totalBookings = Booking::count();
            \Log::info('Total bookings in database: ' . $totalBookings);
            
            if ($totalBookings > 0) {
                $latestBooking = Booking::latest()->first();
                \Log::info('Latest booking date: ' . $latestBooking->created_at);
            }
            
            // STATS CARDS
            $statsQuery = Booking::query();
            
            if ($periode == 'bulan_ini') {
                $statsQuery->whereYear('created_at', now()->year)
                          ->whereMonth('created_at', now()->month);
                          
                $countCheck = $statsQuery->count();
                \Log::info('Bookings found for bulan_ini: ' . $countCheck);
                
                if ($countCheck == 0) {
                    \Log::warning('⚠ NO DATA for current month!');
                    \Log::info('Current month: ' . now()->month . ', Year: ' . now()->year);
                }
            } elseif ($periode == 'tahun_ini') {
                $statsQuery->whereYear('created_at', now()->year);
            }
            // For 'all' periode, no filter applied
            
            $stats['total_pendapatan'] = (int) $statsQuery->sum('harga');
            $stats['total_pesanan'] = (int) $statsQuery->count();
            
            $totalDiskon = $statsQuery->get()->sum(function($booking) {
                return ($booking->harga * $booking->diskon) / 100;
            });
            $stats['pendapatan_bersih'] = $stats['total_pendapatan'] - $totalDiskon;
            
            \Log::info('✓ Stats calculated: ' . json_encode($stats));
            
            // PAKET TERPOPULER
            $paketQuery = Booking::select('pakets.kategori_paket', DB::raw('COUNT(*) as total'))
                ->join('pakets', 'bookings.id_Paket', '=', 'pakets.id_Paket')
                ->where('bookings.status', '!=', 'Canceled');
            
            if ($periode == 'bulan_ini') {
                $paketQuery->whereYear('bookings.created_at', now()->year)
                          ->whereMonth('bookings.created_at', now()->month);
            } elseif ($periode == 'tahun_ini') {
                $paketQuery->whereYear('bookings.created_at', now()->year);
            }
            
            $paket_populer = $paketQuery->groupBy('pakets.kategori_paket')
                ->orderBy('total', 'desc')->limit(5)->get()
                ->map(function($item) {
                    return ['nama' => $item->kategori_paket, 'total' => $item->total];
                });
            
            $max_pesanan = $paket_populer->max('total') ?: 1;
            
            \Log::info('✓ Paket populer: ' . $paket_populer->count() . ' items');
            
            // TREND PENDAPATAN - ALWAYS GENERATE DATA
            $trend = $this->generateTrendData($periode);
            
            \Log::info('✓ Trend generated: ' . $trend->count() . ' points');
            \Log::info('Non-zero points: ' . $trend->where('pendapatan', '>', 0)->count());
            
            // LAYANAN DAN PERFORMA
            $layananPerformaQuery = Booking::select('pakets.kategori_paket')
                ->selectRaw('COUNT(bookings.id_Booking) as total_pesanan')
                ->join('pakets', 'bookings.id_paket', '=', 'pakets.id_Paket')
                ->where('bookings.status', '!=', 'Canceled');
            
            if ($periode == 'bulan_ini') {
                $layananPerformaQuery->whereYear('bookings.created_at', now()->year)
                                    ->whereMonth('bookings.created_at', now()->month);
            } elseif ($periode == 'tahun_ini') {
                $layananPerformaQuery->whereYear('bookings.created_at', now()->year);
            }
            
            $layanan_performa = $layananPerformaQuery
                ->groupBy('pakets.id_Paket', 'pakets.kategori_paket')
                ->orderBy('total_pesanan', 'desc')
                ->limit(4)
                ->get()
                ->map(function($item) {
                    return (object)['nama' => $item->kategori_paket, 'total_pesanan' => $item->total_pesanan];
                });
            
            \Log::info('✓ Layanan performa: ' . $layanan_performa->count() . ' items');
            
            // AKTIVITAS TERBARU
            $aktivitas = Booking::with(['user', 'paket'])
                ->latest('created_at')->limit(7)->get()
                ->map(function($activity) {
                    $userFoto = asset('images/default-avatar.png');
                    if ($activity->user && $activity->user->foto_profile) {
                        $fotoPath = storage_path('app/public/' . $activity->user->foto_profile);
                        if (file_exists($fotoPath)) {
                            $userFoto = asset('storage/' . $activity->user->foto_profile);
                        }
                    }
                    
                    $activity->user_foto_url = $userFoto;
                    $activity->user_name = $activity->user ? ($activity->user->nama_belakang ?? $activity->user->name) : ($activity->nama ?? 'Unknown');
                    $activity->paket_name = $activity->paket ? $activity->paket->kategori_paket : 'Paket tidak tersedia';
                    return $activity;
                });
            
            \Log::info('✓ Aktivitas: ' . $aktivitas->count() . ' items');
            
            // DAFTAR USER
            $users = User::where('role', 'user')->latest()->limit(10)->get()
                ->map(function($user) {
                    $userFoto = asset('images/default-avatar.png');
                    if ($user->foto_profile) {
                        $fotoPath = storage_path('app/public/' . $user->foto_profile);
                        if (file_exists($fotoPath)) {
                            $userFoto = asset('storage/' . $user->foto_profile);
                        }
                    }
                    
                    $user->foto_profile_url = $userFoto;
                    $user->display_name = $user->nama_belakang ?? $user->name ?? 'Unknown';
                    return $user;
                });
            
            \Log::info('✓ Users: ' . $users->count() . ' items');
            \Log::info('========== DASHBOARD LOAD COMPLETE ==========');
            
        } catch (\Exception $e) {
            \Log::error('❌ Dashboard Owner Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
        }
        
        // Cek apakah view ada di dashboard.owner atau owner.dashboard
        $viewName = view()->exists('dashboard.owner') ? 'dashboard.owner' : 'owner.dashboard';
        
        return view($viewName, compact(
            'stats', 'paket_populer', 'trend', 'aktivitas', 
            'layanan_performa', 'periode', 'users', 'max_pesanan'
        ));
    }
    
    /**
     * Generate trend data based on periode
     */
    private function generateTrendData($periode)
    {
        $trend = collect([]);
        
        if ($periode == 'bulan_ini') {
            \Log::info('=== GENERATING TREND BULAN INI ===');
            
            // Get all bookings for current month
            $bookings = Booking::select('created_at', 'harga')
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->get();
            
            \Log::info('Bookings for current month: ' . $bookings->count());
            
            // Group by date
            $groupedByDate = $bookings->groupBy(function($booking) {
                return Carbon::parse($booking->created_at)->format('Y-m-d');
            })->map(function($dayBookings) {
                return $dayBookings->sum('harga');
            });
            
            // Generate all days in month
            $daysInMonth = now()->daysInMonth;
            
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = Carbon::create(now()->year, now()->month, $day);
                $dateStr = $date->format('Y-m-d');
                $pendapatan = (int) ($groupedByDate->get($dateStr, 0));
                
                $trend->push([
                    'tanggal' => $dateStr,
                    'pendapatan' => $pendapatan
                ]);
            }
            
        } elseif ($periode == 'tahun_ini') {
            \Log::info('=== GENERATING TREND TAHUN INI ===');
            
            $bookings = Booking::select('created_at', 'harga')
                ->whereYear('created_at', now()->year)
                ->get();
            
            $groupedByMonth = $bookings->groupBy(function($booking) {
                return Carbon::parse($booking->created_at)->month;
            })->map(function($monthBookings) {
                return $monthBookings->sum('harga');
            });
            
            $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            
            for ($month = 1; $month <= 12; $month++) {
                $monthDate = Carbon::create(now()->year, $month, 1);
                
                $trend->push([
                    'tanggal' => $monthDate->format('Y-m-d'),
                    'pendapatan' => (int) $groupedByMonth->get($month, 0),
                    'bulan' => $monthNames[$month - 1]
                ]);
            }
            
        } else { // all time
            \Log::info('=== GENERATING TREND ALL TIME ===');
            
            $firstBooking = Booking::orderBy('created_at', 'asc')->first();
            
            if ($firstBooking) {
                $startDate = Carbon::parse($firstBooking->created_at)->startOfMonth();
                $endDate = now();
                $totalMonths = $startDate->diffInMonths($endDate) + 1;
                
                \Log::info('All time range: ' . $startDate->format('Y-m-d') . ' to ' . $endDate->format('Y-m-d'));
                
                if ($totalMonths > 24) {
                    // Group by year
                    $bookings = Booking::select('created_at', 'harga')->get();
                    
                    $groupedByYear = $bookings->groupBy(function($booking) {
                        return Carbon::parse($booking->created_at)->year;
                    })->map(function($yearBookings) {
                        return $yearBookings->sum('harga');
                    });
                    
                    $startYear = $startDate->year;
                    $endYear = $endDate->year;
                    
                    for ($year = $startYear; $year <= $endYear; $year++) {
                        $trend->push([
                            'tanggal' => "$year-01-01",
                            'pendapatan' => (int) $groupedByYear->get($year, 0),
                            'tahun' => $year
                        ]);
                    }
                } else {
                    // Group by month
                    $bookings = Booking::select('created_at', 'harga')
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->get();
                    
                    $groupedByYearMonth = $bookings->groupBy(function($booking) {
                        $date = Carbon::parse($booking->created_at);
                        return $date->year . '-' . $date->month;
                    })->map(function($monthBookings) {
                        return $monthBookings->sum('harga');
                    });
                    
                    $currentDate = $startDate->copy();
                    
                    while ($currentDate->lte($endDate)) {
                        $key = $currentDate->year . '-' . $currentDate->month;
                        
                        $trend->push([
                            'tanggal' => $currentDate->format('Y-m-d'),
                            'pendapatan' => (int) $groupedByYearMonth->get($key, 0),
                            'bulan' => $currentDate->format('M Y')
                        ]);
                        
                        $currentDate->addMonth();
                    }
                }
            } else {
                \Log::warning('No bookings found for all time');
            }
        }
        
        return $trend;
    }
    
    public function refresh(Request $request)
    {
        try {
            $periode = $request->get('periode', 'bulan_ini');
            $query = Booking::query();
            
            if ($periode == 'bulan_ini') {
                $query->whereYear('created_at', now()->year)
                     ->whereMonth('created_at', now()->month);
            } elseif ($periode == 'tahun_ini') {
                $query->whereYear('created_at', now()->year);
            }
            
            $total_pendapatan = (int) $query->sum('harga');
            
            $totalDiskon = $query->get()->sum(function($booking) {
                return ($booking->harga * $booking->diskon) / 100;
            });
            
            $stats = [
                'total_pendapatan' => number_format($total_pendapatan, 0, ',', '.'),
                'total_pesanan' => $query->count(),
                'pendapatan_bersih' => number_format($total_pendapatan - $totalDiskon, 0, ',', '.'),
            ];
            
            $aktivitas = Booking::with(['user', 'paket'])
                ->latest('created_at')->limit(7)->get()
                ->map(function($item) {
                    $userFoto = asset('images/default-avatar.png');
                    if ($item->user && $item->user->foto_profile) {
                        $fotoPath = storage_path('app/public/' . $item->user->foto_profile);
                        if (file_exists($fotoPath)) {
                            $userFoto = asset('storage/' . $item->user->foto_profile);
                        }
                    }
                    
                    return [
                        'user_name' => $item->user ? ($item->user->nama_belakang ?? $item->user->name) : ($item->nama ?? 'Unknown'),
                        'user_foto' => $userFoto,
                        'user_initial' => strtoupper(substr($item->user ? ($item->user->name ?? 'U') : 'U', 0, 1)),
                        'paket_nama' => $item->paket ? $item->paket->kategori_paket : 'Paket tidak tersedia',
                        'time' => $item->created_at->diffForHumans(),
                    ];
                });
            
            return response()->json(['success' => true, 'stats' => $stats, 'aktivitas' => $aktivitas]);
            
        } catch (\Exception $e) {
            \Log::error('Refresh Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
    
    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            
            if (in_array($user->role, ['owner', 'admin'])) {
                return response()->json(['success' => false, 'message' => 'Tidak bisa menghapus user dengan role owner/admin'], 403);
            }
            
            $user->delete();
            return response()->json(['success' => true, 'message' => 'User berhasil dihapus']);
            
        } catch (\Exception $e) {
            \Log::error('Delete User Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menghapus user'], 500);
        }
    }
}