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
        ];

        foreach ($jenisP as $key => $value) {
            JenisPengeluaran::create($value);
        }
    }
}
