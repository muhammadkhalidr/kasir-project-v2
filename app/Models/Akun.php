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
    protected $fillable = ['no_reff', 'id_user', 'nama_reff', 'keterangan', 'aktif'];

    // relasi 1-N dengan Jurnal
    public function jurnal()
    {
        return $this->hasMany(Jurnal::class, 'id_akun');
    }

    // Non-aktifkan Timestamp
    public $timestamps = true;
}
