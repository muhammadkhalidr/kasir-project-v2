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
        Schema::create('gaji_karyawan_v2_s', function (Blueprint $table) {
            $table->id('id_gaji')->autoIncrement();
            $table->unsignedBigInteger('id_karyawan');
            $table->bigInteger('jumlah_gaji');
            $table->bigInteger('persen_bonus')->nullable();
            $table->bigInteger('bonus')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaji_karyawan_v2_s');
    }
};
