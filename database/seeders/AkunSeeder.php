<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $akun = [
            ['nama_reff' => 'Kas', 'id_akun' => '110', 'keterangan' => 'Kas', 'aktif' => 'Y', 'id_user' => '1'],
            ['nama_reff' => 'Piutang Usaha', 'id_akun' => '120', 'keterangan' => 'Piutang', 'aktif' => 'Y', 'id_user' => '1'],
            ['nama_reff' => 'Peralatan Usaha', 'id_akun' => '140', 'keterangan' => 'Peralatan Usaha', 'aktif' => 'Y', 'id_user' => '1'],
            ['nama_reff' => 'Bangunan', 'id_akun' => '150', 'keterangan' => ' Bangunan', 'aktif' => 'Y', 'id_user' => '1'],
            ['nama_reff' => 'Tanah', 'id_akun' => '160', 'keterangan' => 'Tanah', 'aktif' => 'Y', 'id_user' => '1'],
            ['nama_reff' => 'Utang Usaha', 'id_akun' => '210', 'keterangan' => 'Utang Usaha', 'aktif' => 'Y', 'id_user' => '1'],
            ['nama_reff' => 'Utang Bank', 'id_akun' => '230', 'keterangan' => 'Utang Bank', 'aktif' => 'Y', 'id_user' => '1'],
            ['nama_reff' => 'Modal Saham', 'id_akun' => '310', 'keterangan' => 'Modal Saham', 'aktif' => 'Y', 'id_user' => '1'],
            ['nama_reff' => 'Pendapatan', 'id_akun' => '510', 'keterangan' => 'Pendapatan', 'aktif' => 'Y', 'id_user' => '1'],
            ['nama_reff' => 'Gaji & Upah', 'id_akun' => '410', 'keterangan' => 'Gaji', 'aktif' => 'Y', 'id_user' => '1'],
            ['nama_reff' => 'Utilities (Listrik, Air, & Gas)', 'id_akun' => '420', 'keterangan' => 'Listrik, Air, Gas', 'aktif' => 'Y', 'id_user' => '1'],
            ['nama_reff' => 'Bunga Bank', 'id_akun' => '430', 'keterangan' => 'Bunga Bank', 'aktif' => 'Y', 'id_user' => '1'],
            ['nama_reff' => 'Dividen', 'id_akun' => '440', 'keterangan' => 'Dividen', 'aktif' => 'Y', 'id_user' => '1'],
        ];

        DB::table('akuns')->insert($akun);

        $this->command->info('Berhasil Menambahkan Beberapa Akun');
    }
}
