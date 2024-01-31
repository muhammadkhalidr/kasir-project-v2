<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    protected $guarded = ['id'];
    protected $table = 'detail_pembelians';

    public function bahans()
    {
        return $this->belongsTo(JenisBahan::class, 'id_bahan');
    }

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }

    public function jenisP()
    {
        return $this->belongsTo(JenisPengeluaran::class, 'id_jenis');
    }
}
