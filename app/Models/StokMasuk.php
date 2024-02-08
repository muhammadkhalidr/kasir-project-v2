<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokMasuk extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'stok_masuks';

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class, 'stok_masuk_id');
    }

    public function bahans()
    {
        return $this->belongsTo(JenisBahan::class, 'id_bahan');
    }

    public function stokkeluars()
    {
        return $this->hasMany(StokKeluar::class, 'id_stok_masuk');
    }
}
