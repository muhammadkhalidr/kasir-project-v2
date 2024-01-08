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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kategori');
            $table->string('id_bahan');
            $table->string('barcode')->nullable();
            $table->string('judul');
            $table->integer('harga_beli');
            $table->integer('harga_jual');
            $table->integer('harga_grosir');
            $table->string('ukuran');
            $table->string('public');
            $table->enum('status', ['Y', 'N']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
