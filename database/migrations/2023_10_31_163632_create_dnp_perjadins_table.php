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
            $table->string('nama');
            $table->string('nip', 18);
            $table->string('unit');
            $table->string('st');
            $table->string('lokasi');
            $table->string('durasi');
            $table->double('norek');
            $table->string('namarek');
            $table->double('bank');
            $table->json('uangharian')->nullable();
            $table->json('penginapan')->nullable();
            $table->json('representatif')->nullable();
            $table->json('transport')->nullable();
            $table->json('transportLain')->nullable();
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
