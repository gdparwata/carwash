<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('status', ['done', 'canceled', 'inprogress'])
                  ->default('inprogress')
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Balikin ke varchar biar rollback aman
            $table->string('status')->default('pending')->change();
        });
    }
};
