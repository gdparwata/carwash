<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';
    protected $primaryKey = 'id_User';

    protected $fillable = [
        'name',
        'nama_belakang',
        'email',
        'password',
        'no_telepon',
        'alamat',
        'foto_profile',
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

    // 👇 TAMBAHKAN INI
    /**
     * Get nama lengkap (gabungan name + nama_belakang)
     */
    public function getNamaLengkapAttribute()
    {
        $fullName = trim($this->name . ' ' . $this->nama_belakang);
        return $fullName ?: $this->name; // Fallback ke name jika kosong
    }

    /**
     * Get foto profile URL with fallback to UI Avatars
     */
    public function getFotoProfileUrlAttribute()
    {
        if ($this->foto_profile && file_exists(public_path('storage/' . $this->foto_profile))) {
            return asset('storage/' . $this->foto_profile);
        }
        
        // Fallback ke UI Avatars dengan nama lengkap
        $name = $this->nama_lengkap ?: 'User';
        return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=3B82F6&color=fff&size=200';
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'id_User';
    }

    // Relasi bookings jika ada
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_User', 'id_User');
    }
}