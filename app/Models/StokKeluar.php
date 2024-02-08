<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokKeluar extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'stok_keluars';

    public function stokmasuks()
    {
        return $this->belongsTo(StokMasuk::class, 'id_stok_masuk');
    }

    public function bahans()
    {
        return $this->belongsTo(JenisBahan::class, 'id_bahan');
    }
}
