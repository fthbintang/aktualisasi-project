<?php

namespace Database\Factories;

use App\Models\Laporan;
use App\Models\JenisLaporan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\yes>
 */
class LaporanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Laporan::class;

    public function definition()
    {
        return [
            'jenis_laporan_id' => JenisLaporan::factory(),
            'nama_laporan' => $this->faker->words(3, true) . '-' . rand(1, 10000),
        ];
    }
}