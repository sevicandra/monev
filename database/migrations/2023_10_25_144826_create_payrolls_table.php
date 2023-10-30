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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tagihan_id');
            $table->string('nama');
            $table->string('bank', 50);
            $table->string('norek', 50);
            $table->double('bruto', 15,0)->nullable();
            $table->double('pajak', 15,0)->nullable();
            $table->double('admin', 15,0)->nullable();
            $table->double('netto', 15,0)->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
