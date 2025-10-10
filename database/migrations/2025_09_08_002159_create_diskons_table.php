<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('diskons', function (Blueprint $table) {
            $table->id('id_Diskon');
            $table->string('nama');
            $table->decimal('persen', 5, 2);
            $table->dateTime('Berlaku_dari');
            $table->dateTime('Berlaku_sampai');
            $table->string('dibuat_oleh');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('diskons');
    }
};