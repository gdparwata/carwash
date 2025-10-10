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

    // Relationship dengan libur
    public function liburs()
    {
        return $this->hasMany(Libur::class, 'id_pegawai', 'id_Pegawai');
    }

    // Relationship dengan bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_pegawai', 'id_Pegawai');
    }

    // Get hari libur pegawai
    public function getHariLiburAttribute()
    {
        return $this->liburs->pluck('hari')->toArray();
    }

    // Check if pegawai libur on specific day
    public function isLiburOnDay($dayName)
    {
        return $this->liburs()->where('hari', $dayName)->exists();
    }

    // Scope untuk filter pegawai yang tidak libur pada hari tertentu
    public function scopeAvailableOnDay($query, $dayName)
    {
        return $query->whereDoesntHave('liburs', function($q) use ($dayName) {
            $q->where('hari', $dayName);
        });
    }

    // Get jumlah booking yang ditangani
    public function getTotalBookingsAttribute()
    {
        return $this->bookings()->count();
    }

    // Get jumlah booking selesai
    public function getCompletedBookingsAttribute()
    {
        return $this->bookings()->where('status', 'Done')->count();
    }

    // Get performance percentage
    public function getPerformanceAttribute()
    {
        $total = $this->total_bookings;
        if ($total === 0) return 0;
        
        $completed = $this->completed_bookings;
        return round(($completed / $total) * 100, 2);
    }
}