<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Addons extends Model
{
    protected $table = 'addons';
    protected $primaryKey = 'id_addons';
    public $timestamps = true;

    protected $fillable = ['nama', 'harga'];

    // ✅ RELASI BALIK KE PAKET
   public function pakets()
{
    return $this->belongsToMany(
        Paket::class,  // ✅ Ganti dari Pakets ke Paket
        'paket_addons',
        'id_addons',
        'id_paket'
    );
}

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_Addons', 'id_addons');
    }
}