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
        Schema::create('tagihans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('notagihan',5);
            $table->uuid('jnstagihan');
            $table->uuid('kodeunit');
            $table->uuid('kodedokumen');
            $table->tinyInteger('status');
            $table->date('tgltagihan');
            $table->string('kodesatker',6);
            $table->string('tahun',4);
            $table->string('uraian');
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
        Schema::dropIfExists('tagihans');
    }
};
