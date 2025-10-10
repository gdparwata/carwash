<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\Tingkatan;
use App\Models\Paket;
use App\Models\Addons;
use App\Models\JenisKendaraan;
use App\Models\Diskon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        User::create([
            'nama' => 'Admin',
            'email' => 'admin@carwash.com'
        ]);

        // Pegawai
        Pegawai::create([
            'nama' => 'Budi',
            'email' => 'budi@carwash.com',
            'nomor_telepon' => '081234567890'
        ]);

        Pegawai::create([
            'nama' => 'Andi',
            'email' => 'andi@carwash.com',
            'nomor_telepon' => '081234567891'
        ]);

        // Tingkatan
        $basic = Tingkatan::create([
            'Tingkatan' => 'Basic',
            'deskripsi' => 'Cuci standar',
            'harga' => 25000
        ]);

        $premium = Tingkatan::create([
            'Tingkatan' => 'Premium',
            'deskripsi' => 'Cuci + poles',
            'harga' => 50000
        ]);

        $deluxe = Tingkatan::create([
            'Tingkatan' => 'Deluxe',
            'deskripsi' => 'Cuci + poles + wax',
            'harga' => 75000
        ]);

        // Paket
        $mobilBasic = Paket::create([
            'kategori_paket' => 'Cuci Mobil',
            'id_Tingkatan' => $basic->id_Tingkatan
        ]);

        $mobilPremium = Paket::create([
            'kategori_paket' => 'Cuci Mobil',
            'id_Tingkatan' => $premium->id_Tingkatan
        ]);

        $motorBasic = Paket::create([
            'kategori_paket' => 'Cuci Motor',
            'id_Tingkatan' => $basic->id_Tingkatan
        ]);

        // Jenis Kendaraan
        JenisKendaraan::create([
            'jenis_kendaraan' => 'Mobil',
            'nama_kendaraan' => 'Sedan',
            'id_Paket' => $mobilBasic->id_Paket
        ]);

        JenisKendaraan::create([
            'jenis_kendaraan' => 'Mobil',
            'nama_kendaraan' => 'SUV',
            'id_Paket' => $mobilPremium->id_Paket
        ]);

        JenisKendaraan::create([
            'jenis_kendaraan' => 'Motor',
            'nama_kendaraan' => 'Sport',
            'id_Paket' => $motorBasic->id_Paket
        ]);

        // Addons
        Addons::create([
            'nama' => 'Wax Premium',
            'harga' => 25000
        ]);

        Addons::create([
            'nama' => 'Cuci Jok',
            'harga' => 15000
        ]);

        Addons::create([
            'nama' => 'Vacuum',
            'harga' => 10000
        ]);

        // Diskon
        Diskon::create([
            'nama' => 'Promo Akhir Tahun',
            'persen' => 20,
            'Berlaku_dari' => now(),
            'Berlaku_sampai' => now()->addMonths(2),
            'dibuat_oleh' => 'admin'
        ]);

        Diskon::create([
            'nama' => 'Member Discount',
            'persen' => 10,
            'Berlaku_dari' => now(),
            'Berlaku_sampai' => now()->addYear(),
            'dibuat_oleh' => 'admin'
        ]);
    }
}