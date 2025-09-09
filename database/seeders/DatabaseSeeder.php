<?php

namespace Database\Seeders;

use App\Models\ArsipGugatan;
use App\Models\ArsipPermohonan;
use App\Models\ArsipPidana;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Laporan;
use App\Models\JenisLaporan;
use App\Models\LaporanTahun;
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

        // 1. Buat user
        User::create([
            'nama_lengkap' => 'Muhammad Bintang Fathehah',
            'role' => 'Kepaniteraan Hukum',
            'username' => 'bintang',
            'password' => bcrypt('bintang')
        ]);

        // ArsipPermohonan::factory(500)->create();
        // ArsipGugatan::factory(20)->create();
        ArsipPidana::factory(100)->create();

        // 2. Buat jenis laporan
        $jenisLaporans = [
            'Laporan Offline',
            'Laporan Online',
            'Laporan Lain-Lain'
        ];

        foreach ($jenisLaporans as $jenis) {
            $jenisModel = JenisLaporan::factory()->create([
                'nama_jenis' => $jenis
            ]);

            // 3. Buat laporan untuk jenis ini (5 laporan tiap jenis)
            for ($i = 1; $i <= 5; $i++) {
                $laporanModel = Laporan::factory()->create([
                    'jenis_laporan_id' => $jenisModel->id,
                    'nama_laporan' => $jenis . ' - Laporan ' . $i
                ]);

                // 4. Buat laporan_tahun untuk tahun ini
                $laporanTahun = LaporanTahun::factory()->create([
                    'laporan_id' => $laporanModel->id,
                    'tahun' => date('Y'),
                ]);

                // 5. Buat upload_laporan random untuk tiap bulan
                for ($bulan = 1; $bulan <= 12; $bulan++) {
                    if (rand(0,1)) { // 50% chance sudah diupload
                        UploadLaporan::factory()->create([
                            'laporan_tahun_id' => $laporanTahun->id,
                            'bulan' => $bulan,
                            'laporan_path' => 'laporan/' . $laporanModel->id . '/file_' . $bulan . '.pdf'
                        ]);
                    }
                }
            }
        }
    }
}