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
        Schema::create('pegawainondjkns', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nip');
            $table->string('nama');
            $table->string('kodegolongan', 2);
            $table->string('rekening');
            $table->string('namabank');
            $table->string('namarekening');
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
        Schema::dropIfExists('pegawainondjkns');
    }
};
