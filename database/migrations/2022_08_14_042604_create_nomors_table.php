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
        Schema::create('nomors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('nomor');
            $table->string('ekstensi');
            $table->string('tahun',4);
            $table->string('kodesatker',6); 
            $table->timestamps();
            $table->unique('tahun', 'kodesatker');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nomors');
    }
};
