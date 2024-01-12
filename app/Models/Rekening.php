<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    use HasFactory;

    protected $rekenings;

    protected $primaryKey = 'id';

    protected $fillable = [
        'no_rekening',
        'atas_nama',
        'bank',
        'no_refferensi',
    ];

    public function pengeluaran()
    {
        return $this->hasMany(Pengeluaran::class, 'id_bank', 'id');
    }

    public function kasMasuk()
    {
        return $this->hasMany(KasMasuk::class, 'bank', 'id');
    }

    public function pelunasans()
    {
        return $this->hasMany(PelunasanOrderan::class, 'id');
    }
}
