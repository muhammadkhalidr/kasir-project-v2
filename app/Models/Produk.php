<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "produks";

    public function kategories()
    {
        return $this->belongsTo(KategoriBahan::class, 'id_kategori');
    }
    public function bahans()
    {
        return $this->belongsTo(JenisBahan::class, 'id_bahan');
    }

    public function orderans()
    {
        return $this->hasMany(DetailOrderan::class, 'id_produk');
    }

    
}
