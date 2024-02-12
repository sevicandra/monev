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
        Schema::create('ref_staf_ppks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('satker', 6);
            $table->string('nama');
            $table->string('nip', 18);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_staf_p_p_k_s');
    }
};
