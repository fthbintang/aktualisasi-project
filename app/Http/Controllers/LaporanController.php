<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\JenisLaporan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $jenisLaporan = JenisLaporan::where('is_hidden', 0)->get();
        $tahun = $request->input('tahun', date('Y'));
        $filterJenis = $request->input('jenis', []);

        $query = Laporan::with(['upload_laporan' => function ($q) use ($tahun) {
            $q->where('tahun', $tahun);
        }, 'jenis_laporan' => function ($q) {
            $q->where('is_hidden', 0);
        }]);

        if (!empty($filterJenis)) {
            $query->whereIn('jenis_laporan_id', $filterJenis);
        }

        $dataLaporan = $query->get();

        // Pisahkan laporan visible dan hidden
        $laporanVisible = $dataLaporan->where('is_hidden', 0)->groupBy('jenis_laporan_id');
        $laporanHidden  = $dataLaporan->where('is_hidden', 1)->groupBy('jenis_laporan_id');

        return view('laporan.index', [
            'breadcrumbs'    => ['Laporan'],
            'jenisLaporan'   => $jenisLaporan,
            'laporanVisible' => $laporanVisible,
            'laporanHidden'  => $laporanHidden,
            'tahun'          => $tahun,
        ]);
    }

    public function toggle($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->is_hidden = !$laporan->is_hidden;
        $laporan->save();

        return back()->with('success', 'Status laporan berhasil diperbarui');
    }

}