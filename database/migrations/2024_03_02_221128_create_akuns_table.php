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
        Schema::create('akuns', function (Blueprint $table) {
            $table->id('id');
            $table->integer('id_akun');
            $table->integer('id_user');
            $table->string('nama_reff');
            $table->string('keterangan');
            $table->enum('aktif', ['Y', 'N']);
            $table->integer('aktiva');
            $table->integer('pasiva');
            $table->integer('laba_rugi');
            $table->integer('kewajiban');
            $table->integer('beban');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akuns');
    }
};
