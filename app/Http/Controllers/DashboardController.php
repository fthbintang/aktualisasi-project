<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Laporan;
use App\Models\ArsipPidana;
use App\Models\ArsipGugatan;
use App\Models\JenisLaporan;
use App\Models\LaporanTahun;
use Illuminate\Http\Request;
use App\Models\UploadLaporan;
use App\Models\ArsipPermohonan;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $bulanSekarang = Carbon::now()->translatedFormat('F Y');
        $namaBulanSekarang = Carbon::now()->translatedFormat('F'); // Januari, Februari, dst
        $angkaBulanSekarang = Carbon::now()->month;
        $tahunSekarang = Carbon::now()->year;

        // Data ringkasan arsip bulan ini (pakai kolom bulan, bukan created_at)
        $arsip = [
            'permohonan' => ArsipPermohonan::where('bulan', $namaBulanSekarang)->count(),
            'gugatan'    => ArsipGugatan::where('bulan', $namaBulanSekarang)->count(),
            'pidana'     => ArsipPidana::where('bulan', $namaBulanSekarang)->count(),
        ];

        $statusUpload = [];
        $jenisLaporan = JenisLaporan::with('laporan.laporan_tahun')->get();

        foreach ($jenisLaporan as $jenis) {
            // Ambil semua laporan di jenis ini
            $laporanList = $jenis->laporan;

            $sudahUploadSemua = true; // default aman
            foreach ($laporanList as $laporan) {
                // Cek apakah bulan sekarang termasuk bulan wajib (JSON di kolom laporan.bulan_wajib)
                $bulanWajib = collect(json_decode($laporan->bulan_wajib, true));
                $isWajib = $bulanWajib->contains($angkaBulanSekarang);

                if ($isWajib) {
                    // Cari laporan_tahun yang sesuai
                    $laporanTahun = $laporan->laporan_tahun()
                        ->where('tahun', $tahunSekarang)
                        ->first();

                    if (!$laporanTahun) {
                        $sudahUploadSemua = false;
                        break;
                    }

                    // Cek apakah sudah ada upload untuk bulan ini
                    $sudahUpload = UploadLaporan::where('laporan_tahun_id', $laporanTahun->id)
                        ->where('bulan', $angkaBulanSekarang)
                        ->exists();

                    if (!$sudahUpload) {
                        $sudahUploadSemua = false;
                        break;
                    }
                }
            }

            $statusUpload[$jenis->nama_jenis] = $sudahUploadSemua;
        }

        // Daftar bulan lengkap
        $bulanPanjang = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $labelsBulan = [
            'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'
        ];

        // Grafik Arsip per Bulan (pakai kolom bulan, bukan created_at)
        $grafikPermohonan = [];
        $grafikGugatan = [];
        $grafikPidana = [];

        for ($i = 1; $i <= 12; $i++) {
            $namaBulan = $bulanPanjang[$i];

            $grafikPermohonan[] = ArsipPermohonan::where('bulan', $namaBulan)->count();
            $grafikGugatan[]    = ArsipGugatan::where('bulan', $namaBulan)->count();
            $grafikPidana[]     = ArsipPidana::where('bulan', $namaBulan)->count();
        }

        // Grafik Kepatuhan (tetap sama)
        $grafikKepatuhan = [];
        $kepUploadedCounts = [];
        $kepTotalRequired = [];

        for ($i = 1; $i <= 12; $i++) {
            $requiredIds = Laporan::where(function($q) use ($i) {
                $q->whereJsonContains('bulan_wajib', $i)
                ->orWhereJsonContains('bulan_wajib', (string)$i);
            })->pluck('id')->toArray();

            $totalRequired = count($requiredIds);
            $kepTotalRequired[] = $totalRequired;

            if ($totalRequired === 0) {
                $kepUploadedCounts[] = 0;
                $grafikKepatuhan[] = 100;
                continue;
            }

            $laporanTahunIds = LaporanTahun::whereIn('laporan_id', $requiredIds)
                ->where('tahun', $tahunSekarang)
                ->pluck('id')
                ->toArray();

            if (empty($laporanTahunIds)) {
                $kepUploadedCounts[] = 0;
                $grafikKepatuhan[] = 0;
                continue;
            }

            $uploadedCount = UploadLaporan::whereIn('laporan_tahun_id', $laporanTahunIds)
                ->where('bulan', $i)
                ->distinct()
                ->pluck('laporan_tahun_id')
                ->count();

            $kepUploadedCounts[] = $uploadedCount;
            $grafikKepatuhan[] = round(($uploadedCount / $totalRequired) * 100, 2);
        }

        return view('dashboard', [
            'title' => 'Dashboard',
            'bulanSekarang' => $bulanSekarang,
            'arsip' => $arsip,
            'statusUpload' => $statusUpload,
            'labelsBulan' => $labelsBulan,
            'grafikPermohonan' => $grafikPermohonan,
            'grafikGugatan' => $grafikGugatan,
            'grafikPidana' => $grafikPidana,
            'grafikKepatuhan' => $grafikKepatuhan,
            'kepUploadedCounts' => $kepUploadedCounts,
            'kepTotalRequired' => $kepTotalRequired,
        ]);
    }

}