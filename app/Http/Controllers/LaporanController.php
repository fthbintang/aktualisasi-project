<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\JenisLaporan;
use App\Models\LaporanTahun;
use Illuminate\Http\Request;
use App\Models\UploadLaporan;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

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

    public function create(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
        $laporan = Laporan::all(); // ambil semua laporan
        $laporanTahun = LaporanTahun::where('tahun', $tahun)->get();

        return view('laporan.create_laporan_tahun', [
            'breadcrumbs' => ['Laporan', 'Tambah Laporan'],
            'tahun' => $tahun,
            'laporan' => $laporan,
            'laporanTahun' => $laporanTahun
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'laporan_id' => 'required|array',
            'laporan_id.*' => 'exists:laporan,id',
            'tahun' => 'required|digits:4',
        ]);

        foreach ($request->laporan_id as $laporanId) {
            LaporanTahun::firstOrCreate([
                'laporan_id' => $laporanId,
                'tahun' => $request->tahun,
            ]);
        }

        Alert::success('Sukses!', 'Laporan berhasil ditambahkan untuk tahun '.$request->tahun);
        return redirect()->route('laporan.index', ['tahun' => $request->tahun]);
    }

    public function destroy($laporanId, $tahun)
    {
        LaporanTahun::where('laporan_id', $laporanId)
                    ->where('tahun', $tahun)
                    ->delete();

        Alert::success('Sukses!', 'Data berhasil dihapus.');
        return redirect()->route('laporan.index', ['tahun' => $tahun]);
    }
    
}