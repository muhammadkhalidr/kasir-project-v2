<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;


    protected $guarded = ['id'];
    protected $primaryKey = 'id_pengeluaran';

    protected $table = 'pengeluarans';

    public $incrementing = false;
    public $timestamps = true;

    public function kasMasuk()
    {
        return $this->hasOne(KasMasuk::class, 'id_generate', 'total');
    }

    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'id', 'id');
    }

    public function jenisp()
    {
        return $this->belongsTo(JenisPengeluaran::class, 'id_jenis', 'id_jenis');
    }

    public function karyawans()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan',);
    }

    public function gajikaryawans()
    {
        return $this->hasMany(GajiKaryawanV2::class, 'id_karyawan',);
    }

    public function kasbons()
    {
        return $this->hasMany(Kasbon::class, 'id');
    }
}
