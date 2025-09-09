<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ArsipPidana>
 */
class ArsipPidanaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Contoh format no_berkas: "1.Pdt.G.2025.PN Kmn"
        $noUrut = $this->faker->numberBetween(1, 999);
        $tahun = $this->faker->numberBetween(2000, now()->year);
        $noBerkas = "{$noUrut}.Pid.B.{$tahun}.PN Kmn";

        // List bulan agar konsisten
        $bulanList = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Buat file dummy PDF
        $fileName = Str::of($noBerkas)
            ->replace(['.', ' '], '_')   // ganti titik & spasi dengan underscore
            ->append('.pdf');

        $filePath = "arsip_pidana/{$fileName}";

        if (!Storage::disk('public')->exists('arsip_pidana')) {
            Storage::disk('public')->makeDirectory('arsip_pidana');
        }

        Storage::disk('public')->put($filePath, '%PDF-1.4 dummy content'); // dummy PDF content

        return [
            'no_berkas' => $noBerkas,
            'bulan' => $this->faker->randomElement($bulanList),
            'arsip_pidana_path' => $filePath,
            'created_by' => $this->faker->name,
            'updated_by' => $this->faker->optional()->name,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}