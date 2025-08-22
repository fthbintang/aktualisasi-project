<?php

namespace App\Http\Controllers;

use App\Models\JenisLaporan;
use App\Models\LaporanTahun;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $jenisLaporan = JenisLaporan::all();
        $tahun = $request->input('tahun', date('Y'));
        $filterJenis = $request->input('jenis', []);

        // Ambil laporan_tahun (hanya tahun terpilih)
        $query = LaporanTahun::with([
            'laporan.jenis_laporan',
            'upload_laporan'
        ])->where('tahun', $tahun);

        if (!empty($filterJenis)) {
            $query->whereHas('laporan', function ($q) use ($filterJenis) {
                $q->whereIn('jenis_laporan_id', $filterJenis);
            });
        }

        $dataLaporanTahun = $query->get();

        // Langsung group by jenis
        $laporanGrouped = $dataLaporanTahun
            ->groupBy(fn($lt) => $lt->laporan->jenis_laporan_id);

        return view('laporan.index', [
            'breadcrumbs'   => ['Laporan'],
            'jenisLaporan'  => $jenisLaporan,
            'laporanGrouped'=> $laporanGrouped,
            'tahun'         => $tahun,
        ]);
    }

    public function toggle($laporanId, $tahun)
    {
        $laporanTahun = LaporanTahun::firstOrCreate(
            ['laporan_id' => $laporanId, 'tahun' => $tahun],
            ['is_hidden' => 0]
        );

        $laporanTahun->is_hidden = !$laporanTahun->is_hidden;
        $laporanTahun->save();

        return back()->with('success', 'Status laporan berhasil diperbarui');
    }
}