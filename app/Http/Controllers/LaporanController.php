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
        // Semua jenis laporan untuk checkbox
        $jenisLaporan = JenisLaporan::all();

        // Filter tahun (default ke tahun sekarang)
        $tahun = $request->input('tahun', date('Y'));

        // Filter jenis laporan (array ID)
        $filterJenis = $request->input('jenis', []);

        // Ambil laporan beserta upload_laporan yang sesuai filter
        $query = Laporan::with(['upload_laporan' => function ($q) use ($tahun) {
            $q->where('tahun', $tahun);
        }, 'jenis_laporan']);

        // Filter berdasarkan jenis laporan
        if (!empty($filterJenis)) {
            $query->whereIn('jenis_laporan_id', $filterJenis);
        }

        $dataLaporan = $query->get();

        return view('laporan.index', [
            'breadcrumbs'   => ['Laporan'],
            'jenisLaporan'  => $jenisLaporan,
            'dataLaporan'   => $dataLaporan,
            'tahun'         => $tahun
        ]);
    }



}