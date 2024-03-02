<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;

    // nama table tidak mengikuti konvensi laravel
    protected $table = 'jurnals';

    // Non-aktifkan Timestamp
    public $timestamps = true;

    // kolom tabel untuk Mass Assingment
    protected $guarded = ['id_transaksi'];

    // kolom akan disembunyikan dalam array
    protected $hidden = [''];

    // Relasi N-1 antara akun dengan jurnal
    public function akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun');
    }
}