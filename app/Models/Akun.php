<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    use HasFactory;

    // Nama table tidak ikuti Convention Laravel
    protected $table = 'akuns';

    // kolom tabel untuk Mass Assingment
    protected $guarded = ['id'];

    // relasi 1-N dengan Jurnal
    public function jurnal()
    {
        return $this->belongsTo(Jurnal::class, 'no_reff', 'id_akun');
    }

    public function jenisP()
    {
        return $this->hasMany(JenisPengeluaran::class, 'id_akun', 'id_akun');
    }

    // Non-aktifkan Timestamp
    public $timestamps = true;
}
