<?php
// app/Models/Tingkatan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tingkatan extends Model
{
    use HasFactory;
    
    protected $table = 'tingkatans';
    protected $primaryKey = 'id_Tingkatan';
    public $timestamps = true;

    protected $fillable = [
        'Tingkatan',
        'deskripsi',
        'harga'
    ];
    
    protected $casts = [
        'harga' => 'decimal:2'
    ];
    
    public function pakets()
    {
        return $this->hasMany(Paket::class, 'id_Tingkatan', 'id_Tingkatan');
    }
}