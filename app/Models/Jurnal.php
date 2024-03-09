<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;

    // nama table tidak mengikuti konvensi laravel
    protected $table = 'jurnals';

    protected $primaryKey = 'id_transaksi';

    // kolom tabel untuk Mass Assingment
    protected $fillable = ['keterangan', 'waktu_transaksi', 'nominal', 'tipe', 'id_akun'];

    // kolom akan disembunyikan dalam array
    protected $hidden = [''];

    // Relasi N-1 antara akun dengan jurnal
    public function akuns()
    {
        return $this->hasMany(Akun::class, 'id_akun', 'no_reff');
    }

    public function jenisP()
    {
        return $this->hasMany(JenisPengeluaran::class, 'id_akun', 'no_reff');
    }
}
