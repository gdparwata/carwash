<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addons extends Model
{
    use HasFactory;
    
    protected $table = 'addons';
    protected $primaryKey = 'id_addons';
    
    protected $fillable = [
        'nama',
        'harga'
    ];
    
    protected $casts = [
        'harga' => 'decimal:2'
    ];
    
    public function bookings()
    {
        // PERBAIKAN: gunakan id_addons, bukan id_Addons
        return $this->hasMany(Booking::class, 'id_addons', 'id_addons');
    }
}
