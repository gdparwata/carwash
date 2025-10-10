<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKendaraan extends Model
{
    use HasFactory;
    
    protected $table = 'jenis_kendaraans';
    protected $primaryKey = 'id_jenis_kendaraan';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'jenis_kendaraan',
        'nama_kendaraan',
        'harga',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];
    
    // ===== RELATIONSHIPS =====

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_jenis_kendaraan', 'id_jenis_kendaraan');
    }
    

    // ===== ACCESSORS =====

    /**
     * Get formatted price for display
     */
    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga ?? 0, 0, ',', '.');
    }

    /**
     * Get full name with price
     */
    public function getFullNameAttribute()
    {
        return $this->jenis_kendaraan . ' - ' . $this->nama_kendaraan . ' (' . $this->formatted_harga . ')';
    }
}