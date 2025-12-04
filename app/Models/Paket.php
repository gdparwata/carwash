<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $table = 'pakets';
    protected $primaryKey = 'id_Paket';
    public $timestamps = true;

    protected $fillable = [
        'kategori_paket'
    ];

    // Relasi ke Tingkatan (One to Many)
    public function tingkatans()
    {
        return $this->hasMany(Tingkatan::class, 'id_paket', 'id_Paket');
    }

    // Relasi ke satu tingkatan (untuk display)
    public function tingkatan()
    {
        return $this->hasOne(Tingkatan::class, 'id_paket', 'id_Paket');
    }

    // Relasi Many-to-Many dengan Addons
    public function addons()
    {
        return $this->belongsToMany(
            Addons::class,
            'paket_addons',
            'id_paket',
            'id_addons'
        );
    }
}