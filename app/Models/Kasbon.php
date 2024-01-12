<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasbon extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'kasbons';

    public function karyawans()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }

    public function gajikaryawanv2()
    {
        return $this->belongsTo(GajiKaryawanV2::class, 'id_karyawan');
    }

    public function pengeluarans()
    {
        return $this->hasMany(Pengeluaran::class, 'id');
    }

    public function jenis()
    {
        return $this->belongsTo(JenisPengeluaran::class, 'id_jenis');
    }
}
