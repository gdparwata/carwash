<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id('id_blog');
            $table->string('title');
            $table->string('deskripsi_singkat');
            $table->text('isi');
            $table->dateTime('tanggal_upload');
            $table->string('gambar');
            $table->foreignId('id_user')->constrained('users', 'id_User');
        });
    }

    public function down()
    {
        Schema::dropIfExists('blogs');
    }
};