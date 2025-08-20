<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\JenisLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

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

    public function create_jenis_laporan()
    {
        return view('daftar_laporan.create_jenis_laporan', [
            'breadcrumbs' => ['Daftar Laporan', 'Tambah Daftar Laporan'],
        ]);
    }

    public function create_laporan()
    {
        return view('daftar_laporan.create_laporan', [
            'breadcrumbs' => ['Daftar Laporan', 'Tambah Daftar Laporan'],
            'jenisLaporan' => JenisLaporan::all()
        ]);
    }

    public function store_jenis_laporan(Request $request)
    {
        $validatedData = $request->validate([
            'nama_jenis' => 'required|string|max:255',
        ]);

        try {
            // Simpan user baru
            JenisLaporan::create($validatedData);

            Alert::success('Sukses!', 'Data Berhasil Ditambah');
            return redirect()->route('daftar_laporan.index');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan user baru', ['error' => $e->getMessage()]);
            Alert::error('Error', 'Terjadi kesalahan saat menyimpan data');
            return back()->withInput();
        }
    }

    public function store_laporan(Request $request)
    {
        $validatedData = $request->validate([
            'jenis_laporan_id' => 'required|exists:jenis_laporan,id',
            'nama_laporan'     => 'required|string|max:255',
        ]);

        try {
            // Simpan laporan baru
            Laporan::create($validatedData);

            Alert::success('Sukses!', 'Data Laporan Berhasil Ditambah');
            return redirect()->route('daftar_laporan.index');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan laporan baru', ['error' => $e->getMessage()]);
            Alert::error('Error', 'Terjadi kesalahan saat menyimpan data');
            return back()->withInput();
        }
    }

    public function editJenis($id)
    {
        $jenis = JenisLaporan::findOrFail($id);

        return view('daftar_laporan.edit_jenis_laporan', [
            'breadcrumbs' => ['Daftar Laporan', 'Edit Jenis Laporan'],
            'jenis' => $jenis
        ]);
    }

    public function editLaporan($id)
    {
        $laporan = Laporan::with('jenis_laporan')->findOrFail($id);

        return view('daftar_laporan.edit_laporan', [
            'breadcrumbs' => ['Daftar Laporan', 'Edit Laporan'],
            'laporan' => $laporan
        ]);
    }

    public function update_jenis_laporan(Request $request, JenisLaporan $jenis_laporan)
    {
        $validatedData = $request->validate([
            'nama_jenis' => 'required|string|max:255',
        ]);

        try {
            // Update data pengguna tanpa foto dulu
            $jenis_laporan->update($validatedData);

            Alert::success('Sukses!', 'Data Berhasil Diupdate');
            return redirect()->route('daftar_laporan.index');
        } catch (\Exception $e) {
            Log::error('Gagal update Jenis Laporan', ['error' => $e->getMessage()]);
            Alert::error('Error', 'Terjadi kesalahan saat mengupdate data');
            return back()->withInput();
        }
    }

    public function update_laporan(Request $request, Laporan $laporan)
    {
        $validatedData = $request->validate([
            'nama_laporan' => 'required|string|max:255',
        ]);

        try {
            // Update data laporan
            $laporan->update($validatedData);

            Alert::success('Sukses!', 'Laporan berhasil diupdate');
            return redirect()->route('daftar_laporan.index');
        } catch (\Exception $e) {
            Log::error('Gagal update Laporan', ['error' => $e->getMessage()]);
            Alert::error('Error', 'Terjadi kesalahan saat mengupdate data');
            return back()->withInput();
        }
    }
}