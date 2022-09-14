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
        Schema::create('objekpajaks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode', 9);
            $table->string('nama');
            $table->string('jenis');
            $table->double('tarif', 5,2);
            $table->double('tarifnonnpwp', 5,2);
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
        Schema::dropIfExists('objekpajaks');
    }
};
