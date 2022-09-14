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
        Schema::create('rekanantagihan', function (Blueprint $table) {
            $table->uuid('rekanan_id');
            $table->uuid('tagihan_id');
            $table->primary(['rekanan_id', 'tagihan_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekanantagihan');
    }
};
