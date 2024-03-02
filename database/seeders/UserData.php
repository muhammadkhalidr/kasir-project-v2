<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'name' => 'Akun Developer',
                'username' => 'superadmin',
                'password' => bcrypt('12345'),
                'level' => 1,
                'email' => 'superadmin@gmail.com',
                'foto' => 'profile.png',
            ],
            [
                'name' => 'Owner',
                'username' => 'owner',
                'password' => bcrypt('12345'),
                'level' => 2,
                'email' => 'owner@gmail.com',
                'foto' => 'profile.png',
            ],
            [
                'name' => 'Kasir',
                'username' => 'kasir',
                'password' => bcrypt('12345'),
                'level' => 3,
                'email' => 'kasir@gmail.com',
                'foto' => 'profile.png',
            ],
            [
                'name' => 'Keuangan',
                'username' => 'keuangan',
                'password' => bcrypt('12345'),
                'level' => 4,
                'email' => 'keuangan@gmail.com',
                'foto' => 'profile.png',
            ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
