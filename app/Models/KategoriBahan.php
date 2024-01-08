<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBahan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'kategori_bahans';


    public function kategories()
    {
        return $this->hasMany(JenisBahan::class, 'id');
    }

    public function produks()
    {
        return $this->hasMany(Produk::class, 'id');
    }
}
