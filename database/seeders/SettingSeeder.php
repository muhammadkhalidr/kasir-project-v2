<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            'id_setting' => '1',
            'perusahaan' => 'Khalid R',
            'alamat' => 'Banda Aceh',
            'email' => 'khalidr8899@gmail.com',
            'phone' => '082291659033',
            'instagram' => 'khlid.er',
            'logo' => 'logo-putih.png',
            'favicon' => 'favicon.png',
            'login_logo' => 'login-logo.png',
            'darijam' => 18,
            'sampaijam' => 8,
            'pesan' => 'Pemesanan Dapat di Akses Melalui Web Resmi Kami, www.khalidr.my.id',
            'logo_lunas' => 'logo-lunas.png',
            'logo_blunas' => 'logo-blunas.png',
            'warnatema' => '#7571f9',
            'qrcode' => 'qrcode.png',
            'demo' => 'N',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
