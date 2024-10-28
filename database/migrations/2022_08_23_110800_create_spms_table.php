<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nomor_spm', 5);
            $table->date('tanggal_spm');
            $table->string('nomor_sp2d', 15)->unique();
            $table->date('tanggal_sp2d');
            $table->year('tahun');
            $table->string('kd_satker', 6);
            $table->string('deskripsi');
            $table->string('jenis_spm', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spms');
    }
};
