<?php

namespace Database\Seeders;

use App\Models\KategoriBahan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            [
                'kategori' => 'Outdoor',
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

        foreach ($kategori as $key => $value) {
            KategoriBahan::create($value);
        }
    }
}
