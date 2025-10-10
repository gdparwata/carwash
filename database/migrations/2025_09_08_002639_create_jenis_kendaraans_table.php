<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jenis_kendaraans', function (Blueprint $table) {
            $table->id('id_jenis_kendaraan');
            $table->string('jenis_kendaraan');
            $table->string('nama_kendaraan');
            $table->foreignId('id_Paket')->constrained('pakets', 'id_Paket');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jenis_kendaraans');
    }
};