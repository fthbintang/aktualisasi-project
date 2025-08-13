<?php

namespace Database\Factories;

use App\Models\Laporan;
use App\Models\UploadLaporan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\yes>
 */
class UploadLaporanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = UploadLaporan::class;

    public function definition()
    {
        return [
            'laporan_id' => Laporan::factory(), // Bisa buat laporan baru otomatis
            'tahun' => $this->faker->year,
            'bulan' => $this->faker->numberBetween(1, 12),
            'laporan_path' => 'laporan/' . $this->faker->unique()->word . '.pdf',
        ];
    }
}