<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JenisBahan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'jenis_bahans';


    public function kategories()
    {
        return $this->belongsTo(KategoriBahan::class, 'id_kategori');
    }

    public function produks()
    {
        return $this->belongsTo(Produk::class, 'id');
    }
}
