<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';
    protected $primaryKey = 'id_invoices'; // Sesuai struktur existing table
    public $incrementing = true;
    protected $keyType = 'bigint';

    // ⚠️ PENTING: Hanya 3 field yang ada di table existing
    protected $fillable = [
        'id_booking',
        'tanggal'
    ];

    protected $dates = ['tanggal', 'created_at', 'updated_at'];

    /**
     * Relationship dengan Booking
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking', 'id_booking');
    }
}