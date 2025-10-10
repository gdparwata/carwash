<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_User';

    protected $fillable = [
        'name',
        'nama_belakang',      // TAMBAH INI
        'email',
        'password',
        'no_telepon',         // TAMBAH INI
        'alamat',             // TAMBAH INI
        'foto_profile',       // TAMBAH INI
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Get jumlah mobil dicuci untuk admin (simulasi)
    public function getJumlahMobilAttribute()
    {
        // Simulasi performance berdasarkan ID atau random
        return rand(50, 1000);
    }

    // Helper untuk mendapatkan URL foto profil
    public function getFotoProfileUrlAttribute()
    {
        if ($this->foto_profile) {
            return asset('storage/' . $this->foto_profile);
        }
        
        // Default avatar jika tidak ada foto
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&size=200&background=667eea&color=fff';
    }

    // Helper untuk mendapatkan nama lengkap
    public function getNamaLengkapAttribute()
    {
        return $this->name . ($this->nama_belakang ? ' ' . $this->nama_belakang : '');
    }
}