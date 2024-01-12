<?php

namespace Database\Seeders;

use App\Models\JenisBahan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bahan = [
            [
                'bahan' => 'Flexy 280 G',
                'status' => 'Y',
                'id_kategori' => '1',
            ],
            [
                'bahan' => 'Vinyl Rirtama',
                'status' => 'Y',
                'id_kategori' => '2',
            ],
            [
                'bahan' => 'Duplex',
                'status' => 'Y',
                'id_kategori' => '3',
            ],
        ];

        foreach ($bahan as $key => $value) {
            JenisBahan::create($value);
        }
    }
}
