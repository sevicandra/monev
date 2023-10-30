<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ref_rekenings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode');
            $table->string('nama');
            $table->string('bank', 50);
            $table->string('otherbank', 50)->nullable();
            $table->string('norek', 50);
            $table->string('kdsatker', 6);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_rekenings');
    }
};
