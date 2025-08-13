<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Laporan;
use App\Models\JenisLaporan;
use App\Models\UploadLaporan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'nama_lengkap' => 'Muhammad Bintang Fathehah',
            'role' => 'Kepaniteraan Hukum',
            'username' => 'bintang',
            'password' => bcrypt('bintang')
        ]);

        // 1. Buat jenis laporan
        $jenisLaporans = [
            'Laporan Offline',
            'Laporan Online',
            'Laporan Lain-Lain'
        ];

        foreach ($jenisLaporans as $jenis) {
            $jenisModel = JenisLaporan::factory()->create([
                'nama_jenis' => $jenis
            ]);

            // 2. Buat laporan untuk jenis ini (5 laporan tiap jenis)
            for ($i = 1; $i <= 5; $i++) {
                $laporanModel = Laporan::factory()->create([
                    'jenis_laporan_id' => $jenisModel->id,
                    'nama_laporan' => $jenis . ' - Laporan ' . $i
                ]);

                // 3. Buat upload laporan random untuk setiap bulan di tahun ini
                for ($bulan = 1; $bulan <= 12; $bulan++) {
                    if (rand(0, 1)) { // 50% chance laporan sudah diupload
                        UploadLaporan::factory()->create([
                            'laporan_id' => $laporanModel->id,
                            'tahun' => date('Y'),
                            'bulan' => $bulan
                        ]);
                    }
                }
            }
        }
    }
}