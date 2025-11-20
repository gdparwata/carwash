<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawais';
    protected $primaryKey = 'id_Pegawai';
    
    protected $fillable = [
        'nama',
        'email',
        'nomor_telepon',
    ];

    public $timestamps = false;

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'id_Pegawai';
    }

    // ========================================
    // RELATIONSHIPS
    // ========================================

    /**
     * Relationship dengan libur
     */
    public function liburs()
    {
        return $this->hasMany(Libur::class, 'id_pegawai', 'id_Pegawai');
    }

    /**
     * Relationship dengan bookings
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_pegawai', 'id_Pegawai');
    }

    // ========================================
    // ATTRIBUTES & HELPERS
    // ========================================

    /**
     * Get jumlah mobil yang dikerjakan
     * Method ini akan di-override oleh Controller yang menggunakan LEFT JOIN
     */
    public function getJumlahMobilAttribute()
    {
        // Jika ada attribute jumlah_mobil dari query (LEFT JOIN di Controller)
        if (isset($this->attributes['jumlah_mobil'])) {
            return $this->attributes['jumlah_mobil'];
        }
        
        // Fallback: hitung dari relationship
        return $this->bookings()->count();
    }

    /**
     * Get hari libur pegawai
     */
    public function getHariLiburAttribute()
    {
        return $this->liburs->pluck('hari')->toArray();
    }

    /**
     * Get hari cuti (untuk kompatibilitas dengan view lama)
     */
    public function getHariCutiAttribute()
    {
        // Jika ada dari query JOIN
        if (isset($this->attributes['hari_cuti'])) {
            return $this->attributes['hari_cuti'];
        }
        
        // Fallback: hitung libur
        return $this->liburs()->count();
    }

    // ========================================
    // QUERY METHODS
    // ========================================

    /**
     * Check if pegawai libur on specific day
     */
    public function isLiburOnDay($dayName)
    {
        return $this->liburs()->where('hari', $dayName)->exists();
    }

    /**
     * Scope untuk filter pegawai yang tidak libur pada hari tertentu
     */
    public function scopeAvailableOnDay($query, $dayName)
    {
        return $query->whereDoesntHave('liburs', function($q) use ($dayName) {
            $q->where('hari', $dayName);
        });
    }

    /**
     * Scope untuk pegawai aktif (punya email)
     */
    public function scopeActive($query)
    {
        return $query->whereNotNull('email');
    }

    // ========================================
    // BOOKING STATISTICS
    // ========================================

    /**
     * Get jumlah booking yang ditangani
     */
    public function getTotalBookingsAttribute()
    {
        return $this->bookings()->count();
    }

    /**
     * Get jumlah booking selesai
     */
    public function getCompletedBookingsAttribute()
    {
        return $this->bookings()->where('status', 'Done')->count();
    }

    /**
     * Get jumlah booking pending
     */
    public function getPendingBookingsAttribute()
    {
        return $this->bookings()->where('status', 'Pending')->count();
    }

    /**
     * Get jumlah booking in progress
     */
    public function getInProgressBookingsAttribute()
    {
        return $this->bookings()->where('status', 'In Progress')->count();
    }

    /**
     * Get performance percentage
     */
    public function getPerformanceAttribute()
    {
        $total = $this->total_bookings;
        if ($total === 0) return 0;
        
        $completed = $this->completed_bookings;
        return round(($completed / $total) * 100, 2);
    }

    /**
     * Get total revenue (simulasi - sesuaikan dengan bisnis logic)
     */
    public function getTotalRevenueAttribute()
    {
        return $this->bookings()
            ->where('status', 'Done')
            ->sum('total_harga');
    }

    // ========================================
    // HELPER METHODS
    // ========================================

    /**
     * Check if pegawai tersedia untuk booking pada tanggal tertentu
     */
    public function isAvailableOn($date)
    {
        // Convert date to day name
        $carbon = \Carbon\Carbon::parse($date);
        $hariIndonesia = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'][$carbon->dayOfWeek];
        
        // Cek apakah libur di hari tersebut
        if ($this->isLiburOnDay($hariIndonesia)) {
            return false;
        }
        
        // Cek apakah sudah ada booking di tanggal tersebut (max 5 booking per hari misalnya)
        $bookingCount = $this->bookings()
            ->whereDate('tanggal_booking', $date)
            ->whereIn('status', ['Pending', 'In Progress'])
            ->count();
        
        return $bookingCount < 5; // Max 5 booking per hari
    }

    /**
     * Get avatar URL
     */
    public function getAvatarUrlAttribute()
    {
        // Jika ada foto di database
        if (isset($this->attributes['foto'])) {
            return asset('storage/' . $this->attributes['foto']);
        }
        
        // Default avatar
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama) . '&size=200&background=14b8a6&color=fff';
    }
}