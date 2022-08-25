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
        Schema::create('mapingpaguppks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pagu_id')->unique();
            $table->uuid('user_id');
            $table->timestamps();
            $table->unique(['pagu_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mapingpaguppks');
    }
};
