<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supplier = [
            [
                'nama' => '5M',
                'jenis_usaha' => 'percetakan',
                'pemilik' => '5M',
                'jabatan' => 'owner',
                'alamat' => 'banda aceh',
                'nohp' => '082291659032',
                'email' => '5m@gmail.com',
                'norek' => '73912739128',
                'status' => 'Y'
            ],
            [
                'nama' => 'Wastern',
                'jenis_usaha' => 'percetakan',
                'pemilik' => 'wastern',
                'jabatan' => 'owner',
                'alamat' => 'banda aceh',
                'nohp' => '082291659223',
                'email' => 'wastern@gmail.com',
                'norek' => '733434343',
                'status' => 'Y'
            ],
        ];

        foreach ($supplier as $key => $value) {
            Supplier::create($value);
        }
    }
}
