<?php

namespace Database\Seeders;

use App\Models\Karyawan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $karyawans = [
            [
                'id_karyawan' => '2022010',
                'nama_karyawan' => 'Khalid R',
                'alamat' => 'Banda Aceh',
                'no_hp' => '082291659033',
                'email' => 'khalidr@gmail.com',
                'foto' => 'khalid.jpg',
            ],
            [
                'id_karyawan' => '2022012',
                'nama_karyawan' => 'Rinaldy',
                'alamat' => 'Banda Aceh',
                'no_hp' => '082291659223',
                'email' => 'rinaldy@gmail.com',
                'foto' => 'rinaldy.jpg',
            ],
            [
                'id_karyawan' => '2021020',
                'nama_karyawan' => 'Arinal',
                'alamat' => 'Banda Aceh',
                'no_hp' => '082291650098',
                'email' => 'arinal@gmail.com',
                'foto' => 'arinal.jpg',
            ],
        ];

        foreach ($karyawans as $key => $value) {
            Karyawan::create($value);
        }
    }
}
