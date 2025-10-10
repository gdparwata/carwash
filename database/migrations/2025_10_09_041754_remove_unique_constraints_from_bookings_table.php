<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Hanya drop unique constraint untuk email
            try {
                $table->dropUnique('bookings_email_unique');
            } catch (\Exception $e) {
                // Jika nama index berbeda, coba cara lain
            }
        });
        
        // Alternatif dengan raw SQL jika cara di atas gagal
        try {
            DB::statement('ALTER TABLE bookings DROP INDEX bookings_email_unique');
        } catch (\Exception $e) {
            // Ignore if already dropped
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Restore unique constraint untuk email jika rollback
            $table->unique('email', 'bookings_email_unique');
        });
    }
};