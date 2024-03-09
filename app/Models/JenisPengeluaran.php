<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPengeluaran extends Model
{
    use HasFactory;
    protected $table = 'jenis_pengeluarans';

    protected $guarded = ['id'];

    public function pengeluaran()
    {
        return $this->hasMany(Pengeluaran::class, 'id_jenis');
    }

    public function karyawans()
    {
        return $this->hasMany(Karyawan::class, 'id_jenis',);
    }

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class, 'id_jenis');
    }

    public function akuns()
    {
        return $this->hasMany(Akun::class, 'id_akun', 'id_akun');
    }

    public function jurnals()
    {
        return $this->belongsTo(Jurnal::class, 'id_akun', 'id_akun');
    }
}
