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
        Schema::create('dnp_honorariums', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tagihan_id');
            $table->string('nama');
            $table->string('nip');
            $table->string('dasar');
            $table->string('jabatan');
            $table->string('gol');
            $table->string('npwp');
            $table->string('frekuensi');
            $table->double('nilai', 15, 0);
            $table->double('bruto', 15, 0);
            $table->double('pajak', 15, 0);
            $table->double('netto', 15, 0);
            $table->string('norek');
            $table->string('namarek');
            $table->string('bank');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dnp_honorariums');
    }
};
