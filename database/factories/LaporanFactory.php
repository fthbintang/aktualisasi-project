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
        $periode = $this->faker->randomElement([
            'Bulanan',
            'Triwulan',
            'Caturwulan',
            'Semester',
            'Tahunan'
        ]);

        // mapping default bulan_wajib sesuai periode_upload
        $bulanWajibMap = [
            'Bulanan'    => [1,2,3,4,5,6,7,8,9,10,11,12],
            'Triwulan'   => [3,6,9,12], // biasanya laporan triwulan di akhir kuartal
            'Caturwulan' => [4,8,12],   // per 4 bulan
            'Semester' => [6,12],     // tengah & akhir tahun
            'Tahunan'    => [12],       // akhir tahun
        ];

        return [
            'jenis_laporan_id' => JenisLaporan::factory(),
            'nama_laporan'     => $this->faker->sentence(3),
            'periode_upload'   => $periode,
            'bulan_wajib'      => json_encode($bulanWajibMap[$periode]),
        ];
    }

}