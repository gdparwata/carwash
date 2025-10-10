<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pakets', function (Blueprint $table) {
            $table->id('id_Paket');
            $table->string('kategori_paket');
            $table->foreignId('id_Tingkatan')->constrained('tingkatans', 'id_Tingkatan');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pakets');
    }
};
