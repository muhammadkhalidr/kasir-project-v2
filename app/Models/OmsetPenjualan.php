<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OmsetPenjualan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'omset_penjualans';

    public function produks()
    {
        return $this->belongsTo(Produk::class, 'id_produk',);
    }
}
