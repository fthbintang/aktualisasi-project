<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\LaporanPidana;
use App\Http\Controllers\Controller;

class LaporanPidanaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil raw input
        $bulanInput = $request->get('bulan', now()->month);
        $tahunInput = $request->get('tahun', now()->year);

        // Normalisasi bulan -> integer 1..12
        if (is_numeric($bulanInput)) {
            $bulan = (int) $bulanInput;
        } else {
            $map = [
                'januari'=>1,'februari'=>2,'maret'=>3,'april'=>4,'mei'=>5,'juni'=>6,
                'juli'=>7,'agustus'=>8,'september'=>9,'oktober'=>10,'november'=>11,'desember'=>12,
                // tambahkan singkatan kalau perlu
                'jan'=>1,'feb'=>2,'mar'=>3,'apr'=>4,'jun'=>6,'jul'=>7,'ags'=>8,'sep'=>9,'okt'=>10,'nov'=>11,'des'=>12,
            ];
            $key = mb_strtolower(trim($bulanInput));
            if (isset($map[$key])) {
                $bulan = $map[$key];
            } else {
                // fallback: coba parse dengan Carbon
                try {
                    $parsed = Carbon::parse('1 ' . $bulanInput);
                    $bulan = (int) $parsed->month;
                } catch (\Exception $e) {
                    $bulan = now()->month;
                }
            }
        }

        // Pastikan tahun integer
        $tahun = (int) $tahunInput;

        // Ambil nama bulan & nama bulan sebelumnya (locale id)
        $carbonBulan = Carbon::createFromDate($tahun, $bulan, 1)->locale('id');
        $bulanNama = $carbonBulan->translatedFormat('F');

        // Untuk bulan sebelumnya → otomatis handle Januari (mundur ke Desember tahun lalu)
        $carbonSebelumnya = $carbonBulan->copy()->subMonth();
        $bulanSebelumnya = $carbonSebelumnya->translatedFormat('F');
        $tahunSebelumnya = $carbonSebelumnya->year; // kalau perlu tampilkan juga tahun sebelumnya

        // Cari atau buat entri laporan_pidana untuk bulan & tahun itu
        $laporanPidana = LaporanPidana::firstOrCreate(
            ['bulan' => $bulan, 'tahun' => $tahun]
        );

        // Ambil detail laporan
        $laporanPidana->load('laporan_pidana_detail');

        return view('laporan_pidana.index', [
            'breadcrumbs'      => ['Laporan Pidana'],
            'bulan'            => $bulan,
            'tahun'            => $tahun,
            'bulanNama'        => $bulanNama,
            'bulanSebelumnya'  => $bulanSebelumnya,
            'tahunSebelumnya'  => $tahunSebelumnya,
            'laporanPidana'   => $laporanPidana,
        ]);
    }
}