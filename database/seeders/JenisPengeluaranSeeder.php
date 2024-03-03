<?php

namespace Database\Seeders;

use App\Models\JenisPengeluaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisPengeluaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisP = [
            [
                'id_jenis' => '101',
                'nama_jenis' => 'Pendapatan',
                'id_akun' => '110',
                'aktif' => 'Y',
            ],
            [
                'id_jenis' => '102',
                'nama_jenis' => 'Piutang',
                'id_akun' => '120',
                'aktif' => 'Y',
            ],
            [
                'id_jenis' => '103',
                'nama_jenis' => 'Dividen',
                'id_akun' => '440',
                'aktif' => 'Y',
            ],
        ];

        foreach ($jenisP as $key => $value) {
            JenisPengeluaran::create($value);
        }
    }
}
