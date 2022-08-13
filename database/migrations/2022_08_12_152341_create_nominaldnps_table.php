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
        Schema::create('nominaldnps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('dnp_id')->unique();
            $table->double('bruto', 15,0);
            $table->double('pph', 15,0);
            $table->double('netto', 15,0);
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
        Schema::dropIfExists('nominaldnps');
    }
};
