<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('liburs', function (Blueprint $table) {
            $table->id('id_libur');
            $table->foreignId('id_pegawai')->constrained('pegawais', 'id_Pegawai');
            $table->foreignId('id_user')->constrained('users', 'id_User');
            $table->dateTime('hari');
        });
    }

    public function down()
    {
        Schema::dropIfExists('liburs');
    }
};
