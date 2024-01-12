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
                'produk' => 'Outdoor',
                'status' => 'Y',
            ],
            [
                'kategori' => 'Indoor',
                'status' => 'Y',
            ],
            [
                'kategori' => 'Offset',
                'status' => 'Y',
            ],
        ];

        foreach ($produk as $key => $value) {
            Produk::create($value);
        }
    }
}
