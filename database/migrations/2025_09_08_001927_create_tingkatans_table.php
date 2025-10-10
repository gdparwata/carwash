<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tingkatans', function (Blueprint $table) {
            $table->id('id_Tingkatan');
            $table->string('Tingkatan');
            $table->string('deskripsi');
            $table->decimal('harga', 10, 2);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tingkatans');
    }
};