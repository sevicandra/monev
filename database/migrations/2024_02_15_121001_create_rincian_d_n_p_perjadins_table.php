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
        Schema::create('rincian_dnp_perjadins', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('dnp_id');
            $table->string('keterangan')->nullable();
            $table->enum('jenis', ['uangHarian', 'transport', 'transportLain', 'penginapan', 'respresentatif']);
            $table->integer('frekuensi')->nullable();
            $table->double('nilaisatuan', 15,0)->nullable();
            $table->double('nilaiTotal', 15,0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rincian_dnp_perjadins');
    }
};
