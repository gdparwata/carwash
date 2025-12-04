<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Diskon extends Model
{
    protected $table = 'diskons';
    protected $primaryKey = 'id_Diskon'; // Primary key asli
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
        'Berlaku_dari' => 'datetime',
        'Berlaku_sampai' => 'datetime',
        'persen' => 'decimal:2',
    ];

    // 🆕 TAMBAHKAN INI - Accessor untuk compatibility
    protected $appends = ['id_diskon'];

    public function getIdDiskonAttribute()
    {
        return $this->attributes['id_Diskon'];
    }

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
}