<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArsipPermohonan;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ArsipPermohonanController extends Controller
{
    public function index()
    {
        return view('arsip_permohonan.index', [
            'breadcrumbs' => ['Arsip Permohonan'],
            'arsip_permohonan' => ArsipPermohonan::all()
        ]);
    }

    public function create()
    {
        return view('arsip_permohonan.create', [
            'breadcrumbs' => ['Arsip Permohonan', 'Tambah Arsip Permohonan']
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'no_urut' => 'required|integer|min:1',
                'tahun_berkas' => 'required|integer|min:2000',
                'bulan' => 'required|string',
                'arsip_permohonan' => 'required|file|mimes:pdf|max:2048', // Hanya PDF
            ]);

            // Buat No Berkas
            $noBerkas = "{$request->no_urut}.Pdt.P.{$request->tahun_berkas}.PN Kmn";

            // Upload file ke folder arsip_permohonan dengan nama [no_berkas].pdf
            $file = $request->file('arsip_permohonan');
            $filePath = $file->storeAs(
                'arsip_permohonan',
                "{$noBerkas}.pdf",
                'public'
            );

            // Simpan ke database
            ArsipPermohonan::create([
                'no_berkas' => $noBerkas,
                'bulan' => $request->bulan,
                'arsip_permohonan_path' => $filePath,
            ]);

            Alert::success('Sukses!', 'Arsip permohonan berhasil ditambahkan.');
            return redirect()->route('arsip_permohonan.index');

        } catch (\Exception $e) {
            Log::error('Gagal menyimpan arsip permohonan', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            Alert::error('Gagal!', 'Terjadi kesalahan saat menyimpan arsip: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function edit(ArsipPermohonan $arsip_permohonan)
    {
        return view('arsip_permohonan.edit', [
            'breadcrumbs' => ['Arsip Permohonan', 'Edit Arsip Permohonan'],
            'arsip_permohonan' => $arsip_permohonan,
            'tahunBerkas'
        ]);
    }

    public function update(Request $request, ArsipPermohonan $arsip_permohonan)
    {
        try {
            // Validasi
            $request->validate([
                'no_urut' => 'required|integer|min:1',
                'tahun_berkas' => 'required|integer|min:2000',
                'bulan' => 'required|string',
                'arsip_permohonan' => 'nullable|file|mimes:pdf|max:2048', // opsional
            ]);

            // Buat No Berkas baru
            $noBerkas = "{$request->no_urut}.Pdt.P.{$request->tahun_berkas}.PN Kmn";

            // Cek apakah ada file baru
            if ($request->hasFile('arsip_permohonan')) {
                // Hapus file lama jika ada
                if ($arsip_permohonan->arsip_permohonan_path && Storage::disk('public')->exists($arsip_permohonan->arsip_permohonan_path)) {
                    Storage::disk('public')->delete($arsip_permohonan->arsip_permohonan_path);
                }

                // Upload file baru
                $file = $request->file('arsip_permohonan');
                $filePath = $file->storeAs(
                    'arsip_permohonan',
                    "{$noBerkas}.pdf",
                    'public'
                );
            } else {
                // Jika tidak ada file baru, tetap pakai path lama
                $filePath = $arsip_permohonan->arsip_permohonan_path;
            }

            // Update database
            $arsip_permohonan->update([
                'no_berkas' => $noBerkas,
                'bulan' => $request->bulan,
                'arsip_permohonan_path' => $filePath,
            ]);

            Alert::success('Sukses!', 'Arsip permohonan berhasil diperbarui.');
            return redirect()->route('arsip_permohonan.index');

        } catch (\Exception $e) {
            Log::error('Gagal memperbarui arsip permohonan', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            Alert::error('Gagal!', 'Terjadi kesalahan saat memperbarui arsip: ' . $e->getMessage());
            return back()->withInput();
        }
    }


}