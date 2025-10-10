<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';
    protected $primaryKey = 'id_blog';
    public $timestamps = false; // karena tabel kamu tidak pakai created_at/updated_at

    protected $fillable = [
        'title',
        'deskripsi_singkat',
        'isi',
        'tanggal_upload',
        'gambar',
        'id_user',
        'penulis',
        'status',
        'kategori',
        'tags',
    ];

    // Cast tanggal_upload biar jadi Carbon instance
    protected $casts = [
        'tanggal_upload' => 'datetime',
    ];

    // ❌ Jangan auto isi tanggal_upload selalu, biarkan controller yg atur
    // protected static function boot()
    // {
    //     parent::boot();
    //
    //     static::creating(function ($blog) {
    //         if (empty($blog->tanggal_upload)) {
    //             $blog->tanggal_upload = now();
    //         }
    //     });
    // }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
