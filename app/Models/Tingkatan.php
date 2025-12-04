<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tingkatan extends Model
{
    protected $table = 'tingkatans';
    protected $primaryKey = 'id_Tingkatan';
    public $timestamps = true;

    protected $fillable = [
        'id_paket',
        'Tingkatan',
        'deskripsi',
        'harga'
    ];

    // Relasi ke Paket
    public function paket()
{
    return $this->belongsTo(Paket::class, 'id_paket', 'id_Paket');
}

    // Relasi ke Booking
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_jenis_penanganan', 'id_Tingkatan');
    }
}