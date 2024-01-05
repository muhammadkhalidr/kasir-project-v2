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
            [
                'id_jenis' => '105',
                'nama_jenis' => 'Token Listrik',
                'aktif' => '1',
            ],
            [
                'id_jenis' => '106',
                'nama_jenis' => 'Sewa Ruko',
                'aktif' => '1',
            ],
            [
                'id_jenis' => '107',
                'nama_jenis' => 'Ongkos',
                'aktif' => '1',
            ],
            [
                'id_jenis' => '108',
                'nama_jenis' => 'Wifi',
                'aktif' => '1',
            ],
            [
                'id_jenis' => '109',
                'nama_jenis' => 'PDAM',
                'aktif' => '1',
            ],
            [
                'id_jenis' => '110',
                'nama_jenis' => 'Transportasi',
                'aktif' => '1',
            ],
            [
                'id_jenis' => '111',
                'nama_jenis' => 'Lembur',
                'aktif' => '1',
            ],
            [
                'id_jenis' => '112',
                'nama_jenis' => 'Cashback',
                'aktif' => '1',
            ],
            [
                'id_jenis' => '113',
                'nama_jenis' => 'Pulsa',
                'aktif' => '1',
            ],
        ];

        foreach ($jenisP as $key => $value) {
            JenisPengeluaran::create($value);
        }
    }
}
