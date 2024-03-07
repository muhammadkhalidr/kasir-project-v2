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
        $aktiva = [
            [
                'nama_reff' => 'Kas',
                'id_akun' => '110',
                'keterangan' => 'Kas',
                'aktif' => 'Y',
                'id_user' => '1',
                'aktiva' => '1',
                'pasiva' => '0',
                'laba_rugi' => '0',
                'kewajiban' => '0',
                'beban' => '0'
            ],
            [
                'nama_reff' => 'Bank',
                'id_akun' => '111',
                'keterangan' => 'Kas Bank',
                'aktif' => 'Y',
                'id_user' => '1',
                'aktiva' => '1',
                'pasiva' => '0',
                'laba_rugi' => '0',
                'kewajiban' => '0',
                'beban' => '0'
            ],
            [
                'nama_reff' => 'Piutang Usaha',
                'id_akun' => '120',
                'keterangan' => 'Piutang',
                'aktif' => 'Y',
                'id_user' => '1',
                'aktiva' => '1',
                'pasiva' => '0',
                'laba_rugi' => '0',
                'kewajiban' => '0',
                'beban' => '0'
            ],
            [
                'nama_reff' => 'Peralatan Usaha',
                'id_akun' => '140',
                'keterangan' => 'Peralatan Usaha',
                'aktif' => 'Y',
                'id_user' => '1',
                'aktiva' => '2',
                'pasiva' => '0',
                'laba_rugi' => '0',
                'kewajiban' => '0',
                'beban' => '0'
            ],
            [
                'nama_reff' => 'Bangunan',
                'id_akun' => '150',
                'keterangan' => 'Bangunan',
                'aktif' => 'Y',
                'id_user' => '1',
                'aktiva' => '2',
                'pasiva' => '0',
                'laba_rugi' => '0',
                'kewajiban' => '0',
                'beban' => '0'
            ],
            [
                'nama_reff' => 'Tanah',
                'id_akun' => '160',
                'keterangan' => 'Tanah',
                'aktif' => 'Y',
                'id_user' => '1',
                'aktiva' => '2',
                'pasiva' => '0',
                'laba_rugi' => '0',
                'kewajiban' => '0',
                'beban' => '0'
            ],
            [
                'nama_reff' => 'Persediaan',
                'id_akun' => '310',
                'keterangan' => 'Persediaan Bahan',
                'aktif' => 'Y',
                'id_user' => '1',
                'aktiva' => '1',
                'pasiva' => '0',
                'laba_rugi' => '0',
                'kewajiban' => '0',
                'beban' => '0'
            ],
            [
                'nama_reff' => 'Hutang Pajak',
                'id_akun' => '330',
                'keterangan' => 'Hutang Pajak',
                'aktif' => 'Y',
                'id_user' => '1',
                'aktiva' => '1',
                'pasiva' => '0',
                'laba_rugi' => '0',
                'kewajiban' => '0',
                'beban' => '0'
            ],
        ];
        $pasiva = [
            [
                'nama_reff' => 'Utang Usaha',
                'id_akun' => '210',
                'keterangan' => 'Utang Usaha',
                'aktif' => 'Y',
                'id_user' => '1',
                'aktiva' => '0',
                'pasiva' => '1',
                'laba_rugi' => '0',
                'kewajiban' => '0',
                'beban' => '0'
            ],
            [
                'nama_reff' => 'Utang Bank',
                'id_akun' => '230',
                'keterangan' => 'Utang Bank',
                'aktif' => 'Y',
                'id_user' => '1',
                'aktiva' => '0',
                'pasiva' => '1',
                'laba_rugi' => '0',
                'kewajiban' => '0',
                'beban' => '0'
            ],
            [
                'nama_reff' => 'Modal Saham',
                'id_akun' => '310',
                'keterangan' => 'Modal Saham',
                'aktif' => 'Y',
                'id_user' => '1',
                'aktiva' => '0',
                'pasiva' => '1',
                'laba_rugi' => '0',
                'kewajiban' => '0',
                'beban' => '0'
            ],
            [
                'nama_reff' => 'Laba Ditahan',
                'id_akun' => '320',
                'keterangan' => 'Laba Ditahan',
                'aktif' => 'Y',
                'id_user' => '1',
                'aktiva' => '0',
                'pasiva' => '1',
                'laba_rugi' => '0',
                'kewajiban' => '0',
                'beban' => '0'
            ],
        ];
        $laba_rugi = [
            [
                'nama_reff' => 'Pendapatan',
                'id_akun' => '410',
                'keterangan' => 'Pendapatan',
                'aktif' => 'Y',
                'id_user' => '1',
                'aktiva' => '0',
                'pasiva' => '0',
                'laba_rugi' => '1',
                'kewajiban' => '0',
                'beban' => '0'
            ],
            [
                'nama_reff' => 'Beban Gaji & Upah',
                'id_akun' => '420',
                'keterangan' => 'Beban Gaji & Upah',
                'aktif' => 'Y',
                'id_user' => '1',
                'aktiva' => '0',
                'pasiva' => '0',
                'laba_rugi' => '1',
                'kewajiban' => '0',
                'beban' => '1'
            ],
            [
                'nama_reff' => 'Beban Utilitas (Listrik, Air, & Gas)',
                'id_akun' => '430',
                'keterangan' => 'Beban Utilitas (Listrik, Air, & Gas)',
                'aktif' => 'Y',
                'id_user' => '1',
                'aktiva' => '0',
                'pasiva' => '0',
                'laba_rugi' => '1',
                'kewajiban' => '0',
                'beban' => '1'
            ],
            [
                'nama_reff' => 'Beban Bunga Bank',
                'id_akun' => '440',
                'keterangan' => 'Beban Bunga Bank',
                'aktif' => 'Y',
                'id_user' => '1',
                'aktiva' => '0',
                'pasiva' => '0',
                'laba_rugi' => '1',
                'kewajiban' => '0',
                'beban' => '1'
            ],
            [
                'nama_reff' => 'Pendapatan Jasa/Usaha',
                'id_akun' => '451',
                'keterangan' => 'Pendapatan Jasa/Usaha',
                'aktif' => 'Y',
                'id_user' => '1',
                'aktiva' => '3',
                'pasiva' => '0',
                'laba_rugi' => '1',
                'kewajiban' => '0',
                'beban' => '0'
            ],
            [
                'nama_reff' => 'Pendapatan Lainnya',
                'id_akun' => '452',
                'keterangan' => 'Pendapatan Lainnya',
                'aktif' => 'Y',
                'id_user' => '1',
                'aktiva' => '3',
                'pasiva' => '0',
                'laba_rugi' => '1',
                'kewajiban' => '0',
                'beban' => '0'
            ],
            [
                'nama_reff' => 'Beban Karyawan',
                'id_akun' => '460',
                'keterangan' => 'Beban Karyawan',
                'aktif' => 'Y',
                'id_user' => '1',
                'aktiva' => '0',
                'pasiva' => '0',
                'laba_rugi' => '0',
                'kewajiban' => '0',
                'beban' => '1'
            ],
        ];


        DB::table('akuns')->insert($aktiva);
        DB::table('akuns')->insert($pasiva);
        DB::table('akuns')->insert($laba_rugi);

        $this->command->info('Berhasil Menambahkan Beberapa Akun');
    }
}
