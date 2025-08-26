<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\JenisLaporan;
use App\Models\LaporanTahun;
use Illuminate\Http\Request;
use App\Models\UploadLaporan;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
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

    public function upload_laporan(Request $request)
    {
        try {
            $request->validate([
                'laporan_tahun_id' => 'required|exists:laporan_tahun,id',
                'bulan' => 'required|integer|min:1|max:12',
                'file_laporan' => 'required|file|mimes:pdf,doc,docx,xlsx,xls|max:2048',
            ]);

            $lt = LaporanTahun::with('laporan')->findOrFail($request->laporan_tahun_id);

            $namaLaporan = $lt->laporan->nama_laporan; 
            $tahun = $lt->tahun;
            $bulan = (int) $request->bulan;

            // Nama bulan dalam bahasa Indonesia
            $bulanIndo = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];
            $namaBulan = $bulanIndo[$bulan] ?? 'Bulan'.$bulan;

            // Ekstensi file
            $ext = $request->file('file_laporan')->getClientOriginalExtension();

            // Nama file: nama_laporan_bulan_tahun.ext
            $fileName = "{$namaLaporan}_{$namaBulan}_{$tahun}.{$ext}";

            // Path: laporan/nama_bulan
            $folderPath = "laporan/{$namaBulan}";

            // Simpan file di storage/app/public/laporan/nama_bulan/
            $storedPath = $request->file('file_laporan')->storeAs($folderPath, $fileName, 'public');

            Log::info('File berhasil disimpan', [
                'laporan_tahun_id' => $request->laporan_tahun_id,
                'bulan' => $bulan,
                'file_name' => $fileName,
                'stored_path' => $storedPath,
            ]);

            // Simpan ke database
            UploadLaporan::updateOrCreate(
                [
                    'laporan_tahun_id' => $request->laporan_tahun_id,
                    'bulan' => $bulan,
                ],
                [
                    'laporan_path' => $storedPath,
                ]
            );

            Alert::success('Sukses!', 'Laporan berhasil diunggah');
            return back();

        } catch (\Exception $e) {
            Log::error('Gagal upload laporan', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            Alert::error('Gagal!', 'Terjadi kesalahan saat upload laporan: ' . $e->getMessage());
            return back();
        }
    }

    public function update_laporan(Request $request, $uploadLaporanId)
    {
        try {
            $request->validate([
                'file_laporan' => 'required|file|mimes:pdf,doc,docx,xlsx,xls|max:2048',
            ]);

            $upload = UploadLaporan::with('laporan_tahun.laporan')->findOrFail($uploadLaporanId);

            $lt = $upload->laporan_tahun;
            $laporan = $lt->laporan;

            // Nama laporan
            $namaLaporan = $laporan->nama_laporan;
            $tahun = $lt->tahun;
            $bulan = $upload->bulan;

            // Nama bulan dalam bahasa Indonesia
            $bulanIndo = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];
            $namaBulan = $bulanIndo[$bulan] ?? $bulan;

            // Ambil ekstensi file baru
            $ext = $request->file('file_laporan')->getClientOriginalExtension();

            // Buat nama file baru
            $fileName = "{$namaLaporan}_{$namaBulan}_{$tahun}.{$ext}";

            // Path file baru
            $path = "laporan/{$namaBulan}/{$fileName}";

            // Hapus file lama jika ada
            if (Storage::disk('public')->exists($upload->laporan_path)) {
                Storage::disk('public')->delete($upload->laporan_path);
            }

            // Simpan file baru
            $request->file('file_laporan')->storeAs("laporan/{$namaBulan}", $fileName, 'public');

            // Update path di database
            $upload->update([
                'laporan_path' => $path,
            ]);

            Alert::success('Sukses!', 'Laporan berhasil diupdate.');
            return back();

        } catch (\Exception $e) {
            Log::error('Gagal update laporan', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            Alert::error('Gagal!', 'Terjadi kesalahan saat update laporan: ' . $e->getMessage());
            return back();
        }
    }

    public function delete_laporan($uploadLaporanId)
    {
        try {
            $upload = UploadLaporan::findOrFail($uploadLaporanId);

            // Hapus file fisik jika ada
            if (Storage::disk('public')->exists($upload->laporan_path)) {
                Storage::disk('public')->delete($upload->laporan_path);
            }

            // Hapus record dari database
            $upload->delete();

            Alert::success('Sukses!', 'Laporan berhasil dihapus.');
            return back();

        } catch (\Exception $e) {
            Log::error('Gagal hapus laporan', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            Alert::error('Gagal!', 'Terjadi kesalahan saat menghapus laporan: ' . $e->getMessage());
            return back();
        }
    }

}