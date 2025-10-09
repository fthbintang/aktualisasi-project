<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Laporan;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ArsipPidana;
use App\Models\JenisLaporan;
use App\Models\LaporanTahun;
use App\Models\UploadLaporan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'role' => 'Staff Kepaniteraan Hukum',
            'username' => 'bintang',
            'password' => bcrypt('bintang')
        ]);

        // Insert ke tabel jenis_laporan
        $jenisLaporan = [
            ['nama_jenis' => 'Laporan Online'],
            ['nama_jenis' => 'Laporan Offline'],
            ['nama_jenis' => 'Laporan Lain-Lain'],
        ];
        DB::table('jenis_laporan')->insert($jenisLaporan);

        // Ambil id dari jenis laporan
        $laporanOnlineId   = DB::table('jenis_laporan')->where('nama_jenis', 'Laporan Online')->value('id');
        $laporanOfflineId  = DB::table('jenis_laporan')->where('nama_jenis', 'Laporan Offline')->value('id');
        $laporanLainId     = DB::table('jenis_laporan')->where('nama_jenis', 'Laporan Lain-Lain')->value('id');

        // Mapping bulan wajib sesuai periode
        $bulanWajibMap = [
            'Bulanan'    => [1,2,3,4,5,6,7,8,9,10,11,12],
            'Triwulan'   => [3,6,9,12],
            'Caturwulan' => [4,8,12],
            'Semester'   => [6,12],
            'Tahunan'    => [12],
        ];

        // Daftar laporan Online
        $laporanOnline = [
            ['jenis_laporan_id' => $laporanOnlineId, 'nama_laporan' => 'Laporan Perkara',            'periode_upload' => 'Bulanan'],
            ['jenis_laporan_id' => $laporanOnlineId, 'nama_laporan' => 'Laporan Mediasi',            'periode_upload' => 'Bulanan'],
            ['jenis_laporan_id' => $laporanOnlineId, 'nama_laporan' => 'Laporan Diversi',            'periode_upload' => 'Bulanan'],
            ['jenis_laporan_id' => $laporanOnlineId, 'nama_laporan' => 'Laporan Sidang Keliling (luar gedung)',    'periode_upload' => 'Bulanan'],
            ['jenis_laporan_id' => $laporanOnlineId, 'nama_laporan' => 'Laporan Delegasi',           'periode_upload' => 'Bulanan'],
            ['jenis_laporan_id' => $laporanOnlineId, 'nama_laporan' => 'Laporan Prodeo (Pembebasan Biaya)',             'periode_upload' => 'Bulanan'],
            ['jenis_laporan_id' => $laporanOnlineId, 'nama_laporan' => 'Laporan Biaya (Keuangan Perkara)',              'periode_upload' => 'Bulanan'],
            ['jenis_laporan_id' => $laporanOnlineId, 'nama_laporan' => 'Laporan Restorative Justice (RJ)','periode_upload' => 'Bulanan'],
            ['jenis_laporan_id' => $laporanOnlineId, 'nama_laporan' => 'Laporan Posbakum',           'periode_upload' => 'Bulanan'],
            ['jenis_laporan_id' => $laporanOnlineId, 'nama_laporan' => 'Laporan Pengaduan',          'periode_upload' => 'Bulanan'],
        ];

        // Daftar laporan Offline
        $laporanOffline = [
            ['jenis_laporan_id' => $laporanOfflineId, 'nama_laporan' => 'Laporan Survei Harian',                    'periode_upload'              => 'Bulanan'],
            ['jenis_laporan_id' => $laporanOfflineId, 'nama_laporan' => 'Laporan EIS',                              'periode_upload'              => 'Bulanan'],
            ['jenis_laporan_id' => $laporanOfflineId, 'nama_laporan' => 'Laporan Statistik Perkara',                'periode_upload'              => 'Bulanan'],
            ['jenis_laporan_id' => $laporanOfflineId, 'nama_laporan' => 'Laporan Keadaan Perkara (Pid & Perd)',     'periode_upload'              => 'Bulanan'],
            ['jenis_laporan_id' => $laporanOfflineId, 'nama_laporan' => 'Laporan SKM',                              'periode_upload'              => 'Triwulan'],
            ['jenis_laporan_id' => $laporanOfflineId, 'nama_laporan' => 'Laporan SPAK',                             'periode_upload'              => 'Triwulan'],
            ['jenis_laporan_id' => $laporanOfflineId, 'nama_laporan' => 'Laporan Upaya Hukum',                      'periode_upload'              => 'Caturwulan'],
            ['jenis_laporan_id' => $laporanOfflineId, 'nama_laporan' => 'Laporan Tahunan (Laptah) LKJIP',           'periode_upload'              => 'Tahunan'],
            ['jenis_laporan_id' => $laporanOfflineId, 'nama_laporan' => 'Laporan Informasi Publik',                 'periode_upload'              => 'Tahunan'],
            ['jenis_laporan_id' => $laporanOfflineId, 'nama_laporan' => 'Laporan Kegiatan Hakim',                   'periode_upload'              => 'Semester'],
            ['jenis_laporan_id' => $laporanOfflineId, 'nama_laporan' => 'Laporan Data Responden',                   'periode_upload'              => 'Semester'],
        ];

        // Daftar laporan Lain-Lain
        $laporanLain = [
            ['jenis_laporan_id' => $laporanLainId, 'nama_laporan' => 'Laporan Posbakum',                'periode_upload' => 'Bulanan'],
            ['jenis_laporan_id' => $laporanLainId, 'nama_laporan' => 'Laporan Monev Akurasi Data SIPP', 'periode_upload' => 'Bulanan'],
            ['jenis_laporan_id' => $laporanLainId, 'nama_laporan' => 'Laporan Monev PTSP',              'periode_upload' => 'Bulanan'],
            ['jenis_laporan_id' => $laporanLainId, 'nama_laporan' => 'Laporan Rekapitulasi Gratifikasi','periode_upload' => 'Triwulan'],
        ];

        // Tambahkan field bulan_wajib sesuai periode
        $mapBulan = function ($laporan) use ($bulanWajibMap) {
            $laporan['bulan_wajib'] = json_encode($bulanWajibMap[$laporan['periode_upload']]);
            return $laporan;
        };

        $laporanOnline  = array_map($mapBulan, $laporanOnline);
        $laporanOffline = array_map($mapBulan, $laporanOffline);
        $laporanLain    = array_map($mapBulan, $laporanLain);

        DB::table('laporan')->insert(array_merge($laporanOnline, $laporanOffline, $laporanLain));
    }
}