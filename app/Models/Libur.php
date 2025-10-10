<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libur extends Model
{
    use HasFactory;
    
    protected $table = 'liburs';
    protected $primaryKey = 'id_libur';
    public $timestamps = false;
    
    protected $fillable = [
        'id_pegawai',
        'id_user', 
        'hari'
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'id_libur';
    }

    // Relationships
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_Pegawai');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_User');
    }

    // Accessors
    public function getPersonNameAttribute()
    {
        if ($this->pegawai) {
            return $this->pegawai->nama;
        }
        if ($this->user) {
            return $this->user->name;
        }
        return '-';
    }

    public function getPersonTypeAttribute()
    {
        if ($this->pegawai) {
            return 'Pegawai';
        }
        if ($this->user) {
            return 'Admin';
        }
        return '-';
    }

    // Scopes
    public function scopeForPegawai($query, $pegawaiId)
    {
        return $query->where('id_pegawai', $pegawaiId);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('id_user', $userId);
    }

    public function scopeOnDay($query, $dayName)
    {
        return $query->where('hari', $dayName);
    }

    // Validation helper
    public static function isValid($data)
    {
        $validDays = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        
        if (!in_array($data['hari'], $validDays)) {
            return false;
        }

        // Harus ada salah satu: pegawai atau user, tapi tidak boleh keduanya
        $hasPegawai = !empty($data['id_pegawai']);
        $hasUser = !empty($data['id_user']);
        
        return ($hasPegawai XOR $hasUser); // XOR: hanya satu yang boleh true
    }
}