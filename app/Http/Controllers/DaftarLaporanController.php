<?php

namespace App\Http\Controllers;

use App\Models\JenisLaporan;
use App\Models\Laporan;
use Illuminate\Http\Request;

class DaftarLaporanController extends Controller
{
    public function index()
    {
        $jenisLaporan = JenisLaporan::with('laporan')->get();

        return view('daftar_laporan.index', [
            'breadcrumbs' => ['Daftar Laporan'],
            'jenisLaporan' => $jenisLaporan,
        ]);
    }
}