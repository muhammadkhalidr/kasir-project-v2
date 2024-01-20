<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelunasanOrderan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'pelunasan_orderans';

    public function pelanggans()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    public function rekenings()
    {
        return $this->belongsTo(Rekening::class, 'bank');
    }

    public function orderans()
    {
        return $this->belongsTo(DetailOrderan::class, 'id');
    }
}
