<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    protected $table = 'diskons'; // atau 'id_Diskon' jika nama tabelnya
    protected $primaryKey = 'id_Diskon'; // PENTING: Primary key yang benar
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama',
        'persen',
        'Berlaku_dari',
        'Berlaku_sampai',
        'dibuat_oleh',
    ];

    protected $casts = [
        'Berlaku_dari' => 'date',
        'Berlaku_sampai' => 'date',
        'persen' => 'decimal:2',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'id_Diskon';
    }

    // Relationships
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_Diskon', 'id_Diskon');
    }

    public function getNilaiFormatAttribute()
    {
        if ($this->tipe === 'persentase') {
            return $this->nilai . '%';
        }
        return 'Rp ' . number_format($this->nilai, 0, ',', '.');
    }

    public function getStatusAktifAttribute()
    {
        $now = Carbon::now()->toDateString();
        return $this->status && 
               $this->tanggal_mulai <= $now && 
               $this->tanggal_selesai >= $now &&
               ($this->kuota === null || $this->terpakai < $this->kuota);
    }
}