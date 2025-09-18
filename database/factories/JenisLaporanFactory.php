<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\yes>
 */
class JenisLaporanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_jenis' => $this->faker->randomElement([
                'Laporan Offline', 
                'Laporan Online', 
                'Laporan Lain-Lain'
            ]),
        ];
    }
}