<?php

namespace Database\Factories;

use App\Models\Laporan;
use App\Models\LaporanTahun;
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

    public function definition(): array
    {
        // Buat laporan_tahun beserta laporan
        $laporanTahun = LaporanTahun::factory()->create();

        // Ambil periode & bulan_wajib dari laporan terkait
        $laporan = $laporanTahun->laporan;
        $bulanWajib = json_decode($laporan->bulan_wajib, true);

        return [
            'laporan_tahun_id' => $laporanTahun->id,
            'bulan' => $this->faker->randomElement($bulanWajib),
            'laporan_path' => 'laporan/' . $this->faker->unique()->word . '.pdf',
        ];
    }
}