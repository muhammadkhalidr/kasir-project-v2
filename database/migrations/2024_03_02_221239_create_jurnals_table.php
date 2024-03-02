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
        Schema::create('jurnals', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->integer('id_user');
            $table->integer('no_reff');
            $table->string('reff');
            $table->timestamp('tgl_transaksi');
            $table->enum('tipe', ['debit', 'kredit']);
            $table->integer('nominal');
            $table->string('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnals');
    }
};
