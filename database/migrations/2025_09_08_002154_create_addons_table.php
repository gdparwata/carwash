<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('addons', function (Blueprint $table) {
            $table->id('id_addons');
            $table->string('nama');
            $table->decimal('harga', 10, 2);
        });
    }

    public function down()
    {
        Schema::dropIfExists('addons');
    }
};
