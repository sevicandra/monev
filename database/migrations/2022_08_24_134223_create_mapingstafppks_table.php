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
        Schema::create('mapingstafppks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('ppk_id');
            $table->uuid('staf_id')->unique();
            $table->timestamps();
            $table->unique(['ppk_id', 'staf_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mapingstafppks');
    }
};
