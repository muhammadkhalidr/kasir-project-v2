<?php

namespace Database\Seeders;

use App\Models\Karyawan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserData::class);
        $this->call(PermissionSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(RekeningSeeder::class);
        $this->call(PelangganSeeder::class);
        $this->call(JenisPengeluaranSeeder::class);
        $this->call(KaryawanSeeder::class);
        $this->call(KategoriSeeder::class);
        $this->call(BahanSeeder::class);

        // Jika Anda juga ingin menjalankan factory atau seeder bawaan Laravel, Anda dapat mengaktifkannya di sini.
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
