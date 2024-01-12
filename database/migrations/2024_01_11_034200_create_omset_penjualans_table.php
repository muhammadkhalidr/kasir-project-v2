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
        Schema::create('omset_penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('notrx');
            $table->integer('id_produk');
            $table->string('jumlah')->nullable();
            $table->string('produk');
            $table->integer('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('omset_penjualans');
    }
};
