<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Karyawan>
 */
class KaryawanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_karyawan' => $this->faker->ean8(),
            'nama_karyawan' => $this->faker->name(),
            'alamat'    => $this->faker->address(),
            'no_hp'     => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'foto' => $this->faker->ean13(),
        ];
    }
}
