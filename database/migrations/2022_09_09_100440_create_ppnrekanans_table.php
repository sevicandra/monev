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
        Schema::create('ppnrekanans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('rekanan_id');
            $table->uuid('tagihan_id');
            $table->string('nomorfaktur');
            $table->date('tanggalfaktur');
            $table->double('tarif',3,2);
            $table->double('ppn',16,2);
            $table->string('ntpn',16)->nullable();
            $table->date('tanggalntpn')->nullable();
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
        Schema::dropIfExists('ppnrekanans');
    }
};
