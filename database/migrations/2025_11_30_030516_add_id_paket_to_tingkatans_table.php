<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tingkatans', function (Blueprint $table) {
            $table->unsignedBigInteger('id_paket')->nullable()->after('id_Tingkatan');
            $table->foreign('id_paket')->references('id_paket')->on('pakets')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('tingkatans', function (Blueprint $table) {
            $table->dropForeign(['id_paket']);
            $table->dropColumn('id_paket');
        });
    }
};