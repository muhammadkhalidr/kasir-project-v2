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
        Schema::table('detail_orderans', function (Blueprint $table) {
            $table->integer('id_pelunasan')->after('id_produk')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_orderans', function (Blueprint $table) {
            $table->dropColumn('id_pelunasan');
        });
    }
};
