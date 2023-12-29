<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $karyawans;
    protected $primaryKey = 'id_karyawan';

    protected $guarded = ['id_karyawan'];

    public $incrementing = false;
    public $timestamps = true;

    public function gajis()
    {
        return $this->hasMany(GajiKaryawanV2::class, 'id_karyawan');
    }

    public function pengeluarans()
    {
        return $this->hasMany(Pengeluaran::class, 'id_karyawan');
    }
}
