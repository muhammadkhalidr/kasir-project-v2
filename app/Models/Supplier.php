<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $guards = ['id'];
    protected $table = 'suppliers';

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class, 'id_supplier');
    }
}
