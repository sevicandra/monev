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
        Schema::create('dnp_perjadins', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tagihan_id');
            $table->uuid('nama');
            $table->uuid('nip');
            $table->uuid('golongan');
            $table->uuid('provinsi');
            $table->double('frekuensi',3,0);
            $table->double('uangharian');
            $table->double('hotel');
            $table->double('transport');
            $table->double('transportdalkot');
            $table->double('norek');
            $table->double('bank');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dnp_perjadins');
    }
};
