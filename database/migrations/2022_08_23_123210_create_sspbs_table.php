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
        Schema::create('sspbs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('realisasi_id');
            $table->uuid('pagu_id');
            $table->date('tanggal_sspb');
            $table->double('nominal_sspb', 15, 0);
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
        Schema::dropIfExists('sspbs');
    }
};
