<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';
    protected $primaryKey = 'id_Booking';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama',
        'nomor_telepon', 
        'email',
        'alamat',
        'nomor_polisi',
        'status',
        'tanggal',
        'catatan',
        'harga',
        'diskon',
        'metode',
        'jumlah_uang',
        'kembalian',
        'id_paket',
        'id_user',
        'id_Pegawai',
        'id_jenis_kendaraan',
        'id_addons',
        'id_Diskon',
        'id_jenis_penanganan', // 👈 TAMBAHKAN INI (foreign key ke tingkatans)
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'tanggal_booking' => 'datetime',
        'harga' => 'decimal:2',
        'diskon' => 'decimal:2',
        'jumlah_uang' => 'decimal:2',
        'kembalian' => 'decimal:2',
    ];

    public function getRouteKeyName()
    {
        return 'id_Booking';
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('id_Booking', $value)->firstOrFail();
    }

    // ===== RELATIONSHIPS =====

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_User');
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'id_Paket', 'id_Paket');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_Pegawai', 'id_Pegawai');
    }

    public function jenisKendaraan()
    {
        return $this->belongsTo(JenisKendaraan::class, 'id_jenis_kendaraan', 'id_jenis_kendaraan');
    }

    public function addons()
    {
        return $this->belongsTo(Addons::class, 'id_addons', 'id_addons');
    }

    public function diskon()
    {
        return $this->belongsTo(Diskon::class, 'id_Diskon', 'id_Diskon');
    }

    // 🔥 RELASI BARU - DIRECT KE TINGKATAN
    public function tingkatan()
    {
        return $this->belongsTo(Tingkatan::class, 'id_jenis_penanganan', 'id_Tingkatan');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'id_booking', 'id_Booking');
    }

    // ===== SCOPES =====

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByDate($query, $date)
    {
        return $query->whereDate('tanggal', $date);
    }

    public function scopeWithoutPegawai($query)
    {
        return $query->whereNull('id_Pegawai');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('nama', 'like', '%' . $search . '%')
              ->orWhere('nomor_polisi', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%')
              ->orWhereHas('user', function($userQuery) use ($search) {
                  $userQuery->where('name', 'like', '%' . $search . '%');
              });
        });
    }

    // ===== ACCESSORS =====

    public function getFormattedTanggalAttribute()
    {
        return $this->tanggal ? $this->tanggal->format('d/m/Y H:i') : '-';
    }

    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'InProgres' => 'bg-yellow-100 text-yellow-800',
            'Done' => 'bg-green-100 text-green-800',
            'Canceled' => 'bg-red-100 text-red-800',
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getIsUserBookingAttribute()
    {
        return !$this->metode;
    }

    public function getNeedsPegawaiAssignmentAttribute()
    {
        return is_null($this->id_Pegawai) && $this->status === 'InProgres';
    }

    /**
     * Get price breakdown for display
     */
    public function getPriceBreakdownAttribute()
    {
        $breakdown = [];

        if ($this->jenisKendaraan) {
            $breakdown['Jenis Kendaraan'] = [
                'nama' => $this->jenisKendaraan->jenis_kendaraan,
                'harga' => $this->jenisKendaraan->harga ?? 0
            ];
        }

        // 🔥 GUNAKAN relasi tingkatan langsung
        if ($this->tingkatan) {
            $breakdown['Paket Penanganan'] = [
                'nama' => $this->tingkatan->Tingkatan,
                'harga' => $this->tingkatan->harga ?? 0
            ];
        }

        if ($this->addons) {
            $breakdown['Addons'] = [
                'nama' => $this->addons->nama,
                'harga' => $this->addons->harga ?? 0
            ];
        }

        return $breakdown;
    }

    /**
     * Get total price before discount
     */
    public function getSubtotalAttribute()
    {
        $subtotal = 0;

        if ($this->jenisKendaraan) {
            $subtotal += $this->jenisKendaraan->harga ?? 0;
        }

        // 🔥 GUNAKAN relasi tingkatan langsung
        if ($this->tingkatan) {
            $subtotal += $this->tingkatan->harga ?? 0;
        }

        if ($this->addons) {
            $subtotal += $this->addons->harga ?? 0;
        }

        return round($subtotal, 2);
    }

    /**
     * Get discount amount
     */
    public function getDiscountAmountAttribute()
    {
        if ($this->diskon > 0) {
            return round(($this->subtotal * $this->diskon) / 100, 2);
        }
        return 0;
    }
}