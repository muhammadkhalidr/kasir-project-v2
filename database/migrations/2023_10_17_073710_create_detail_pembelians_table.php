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
        Schema::create('detail_pembelians', function (Blueprint $table) {
            $table->id();
            $table->string('id_pembelian_generate');
            $table->string('id_generate');
            $table->integer('id_supplier');
            $table->integer('id_jenis');
            $table->integer('id_bahan');
            $table->integer('id_bank')->nullable();
            $table->text('keterangan');
            $table->integer('jumlah');
            $table->integer('total');
            $table->integer('subtotal');
            $table->string('satuan');
            $table->integer('id_user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pembelians');
    }
};
