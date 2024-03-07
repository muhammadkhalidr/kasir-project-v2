<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produk = [
            [
                'id_kategori' => 1,
                'id_bahan' => 1,
                'barcode' => '4566856947464',
                'judul' => 'Spanduk',
                'harga_beli' => 0,
                'harga_jual' => 0,
                'harga_jual' => 0,
                'ukuran' => '1x1',
                'public' => 1,
                'jumlah' => 1,
                'status' => 'Y',
            ],

        ];

        foreach ($produk as $key => $value) {
            Produk::create($value);
        }
    }
}
