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
        Schema::create('pagus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('program');
            $table->string('kegiatan');
            $table->string('kro');
            $table->string('ro');
            $table->string('komponen');
            $table->string('subkomponen');
            $table->string('akun');
            $table->double('anggaran', 15,0);
            $table->string('kodesatker');
            $table->uuid('kodeunit')->nullable();
            $table->string('tahun', 4);
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
        Schema::dropIfExists('pagus');
    }
};
