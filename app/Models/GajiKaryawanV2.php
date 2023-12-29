<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GajiKaryawanV2 extends Model
{
    use HasFactory;

    protected $table = 'gaji_karyawan_v2_s';
    protected $guarded = ['id_karyawan'];
    protected $primaryKey = 'id_karyawan';
    protected $appends = ['sisa_gaji'];

    public function karyawans()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }

    public function jenisp()
    {
        return $this->belongsTo(JenisPengeluaran::class, 'id_jenis');
    }

    public function pengeluarans()
    {
        return $this->hasMany(Pengeluaran::class, 'id_karyawan');
    }

    public function kasbons()
    {
        return $this->hasMany(Kasbon::class, 'id_karyawan');
    }
}
