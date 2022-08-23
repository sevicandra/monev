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
            $table->uuid('tagihan_id');
            $table->date('tanggal_spm');
            $table->string('nomor_sp2d')->nullable();
            $table->date('tanggal_sp2d')->nullable();
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
