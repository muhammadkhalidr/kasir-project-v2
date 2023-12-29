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
                'nama_jenis' => 'Kasbon Karyawan',
                'aktif' => '1',
            ],
            [
                'id_jenis' => '102',
                'nama_jenis' => 'Uang Makan',
                'aktif' => '1',
            ],
            [
                'id_jenis' => '103',
                'nama_jenis' => 'Beli Peralatan',
                'aktif' => '1',
            ],
            [
                'id_jenis' => '104',
                'nama_jenis' => 'Pengiriman',
                'aktif' => '1',
            ],
        ];

        foreach ($jenisP as $key => $value) {
            JenisPengeluaran::create($value);
        }
    }
}
