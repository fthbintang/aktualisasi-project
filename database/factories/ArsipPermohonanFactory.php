<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ArsipPermohonan>
 */
class ArsipPermohonanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Nomor urut unik (1-999)
        $noUrut = $this->faker->unique()->numberBetween(1, 999);

        // Tahun berkas (1970-2030)
        $tahun = $this->faker->numberBetween(1970, 2030);

        // Buat no_berkas unik
        $noBerkas = "{$noUrut}.Pdt.P.{$tahun}.PN Kmn";

        // Pilih bulan random
        $bulanIndo = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
        ];
        $bulan = $this->faker->randomElement($bulanIndo);

        // Buat file dummy PDF (jika storage disk 'public' tersedia)
        $fileName = Str::slug($noBerkas) . '.pdf';
        $filePath = "arsip_permohonan/{$fileName}";

        if (!Storage::disk('public')->exists('arsip_permohonan')) {
            Storage::disk('public')->makeDirectory('arsip_permohonan');
        }

        Storage::disk('public')->put($filePath, '%PDF-1.4 dummy content'); // dummy PDF content

        return [
            'no_berkas' => $noBerkas,
            'bulan' => $bulan,
            'arsip_permohonan_path' => $filePath,
            'created_by' => $this->faker->name(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}