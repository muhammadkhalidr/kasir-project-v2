<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    protected $guarded = ['id'];
    protected $table = 'detail_pembelians';

    // Sesuaikan dengan atribut yang ada pada formulir
    protected $fillable = [
        'id_pembelian_generate',
        'id_generate',
        'id_supplier',
        'id_jenis',
        'id_bahan',
        'id_bank',
        'keterangan',
        'jumlah',
        'satuan',
        'total',
    ];
}
