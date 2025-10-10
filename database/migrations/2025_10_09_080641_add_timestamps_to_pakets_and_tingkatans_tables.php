<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tambahkan timestamps ke tabel pakets
        Schema::table('pakets', function (Blueprint $table) {
            $table->timestamps(); // menambah created_at dan updated_at
        });

        // Tambahkan timestamps ke tabel tingkatans
        Schema::table('tingkatans', function (Blueprint $table) {
            $table->timestamps(); // menambah created_at dan updated_at
        });
    }

    public function down(): void
    {
        // Jika di-rollback, hapus timestamps dari kedua tabel
        Schema::table('pakets', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('tingkatans', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
};
