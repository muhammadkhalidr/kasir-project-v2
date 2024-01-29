<?php

namespace Database\Seeders;

use App\Models\Satuan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $satuan = [
            [
                'satuan' => 'PCS',
            ],
            [
                'satuan' => 'CM',
            ],
            [
                'satuan' => 'MM',
            ],
            [
                'satuan' => 'INCH',
            ],
            [
                'satuan' => 'RUPIAH',
            ],
        ];

        foreach ($satuan as $key => $value) {
            Satuan::create($value);
        }
    }
}
