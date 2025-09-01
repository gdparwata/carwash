<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('users', function (Blueprint $table) {
    $table->id('id_User'); // atau pakai id() aja
    $table->string('name', 100);
    $table->string('email', 150)->unique();
    $table->string('password', 255); // PENTING: minimal 255 karakter
    $table->enum('role', ['admin', 'user', 'owner'])->default('user');
    // atau: $table->string('role', 50)->default('user');
    $table->timestamps(); // created_at & updated_at
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
