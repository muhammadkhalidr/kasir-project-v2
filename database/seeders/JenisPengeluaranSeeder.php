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
                'id_akun' => '460',
                'aktif' => 'Y',
            ],
            [
                'id_jenis' => '102',
                'nama_jenis' => 'Uang Makan',
                'id_akun' => '460',
                'aktif' => 'Y',
            ],
            [
                'id_jenis' => '103',
                'nama_jenis' => 'Token Listrik',
                'id_akun' => '430',
                'aktif' => 'Y',
            ],
            [
                'id_jenis' => '104',
                'nama_jenis' => 'Air PDAM',
                'id_akun' => '430',
                'aktif' => 'Y',
            ],
            [
                'id_jenis' => '105',
                'nama_jenis' => 'Ambil Modal',
                'id_akun' => '480',
                'aktif' => 'Y',
            ],
        ];

        foreach ($jenisP as $key => $value) {
            JenisPengeluaran::create($value);
        }
    }
}
