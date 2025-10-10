<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model Paket
class Paket extends Model
{
    use HasFactory;
    
    protected $table = 'pakets';
    protected $primaryKey = 'id_Paket';
    public $timestamps = true;
    
    protected $fillable = [
        'kategori_paket',
        'id_Tingkatan'
    ];
    
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_Paket', 'id_Paket');
    }
    
    public function tingkatan()
    {
        return $this->belongsTo(Tingkatan::class, 'id_Tingkatan', 'id_Tingkatan');
    }
}