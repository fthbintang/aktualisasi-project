<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\LaporanPerdata;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\LaporanPerdataDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class LaporanPerdataController extends Controller
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
                // fallback: coba parse dengan Carbon (mis. "Sep" atau "September")
                try {
                    $parsed = Carbon::parse('1 ' . $bulanInput);
                    $bulan = (int) $parsed->month;
                } catch (\Exception $e) {
                    // jika tetap gagal, pakai bulan sekarang
                    $bulan = now()->month;
                }
            }
        }

        // pastikan tahun integer
        $tahun = (int) $tahunInput;

        // Ambil nama bulan dg cara aman (locale id)
        $bulanNama = Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->translatedFormat('F');

        // Cari atau buat entri laporan_perdata untuk bulan & tahun itu
        $laporanPerdata = LaporanPerdata::firstOrCreate(
            ['bulan' => $bulan, 'tahun' => $tahun]
        );

        // Ambil detail laporan yang terkait (sesuaikan nama relasi model Anda)
        $laporanPerdata->load('laporan_perdata_detail');

        return view('laporan_perdata.index', [
            'breadcrumbs' => ['Laporan Perdata'],
            'bulan'       => $bulan,
            'tahun'       => $tahun,
            'bulanNama'   => $bulanNama,
            'laporanPerdata' => $laporanPerdata,
        ]);
    }

    public function store(Request $request)
    {
        try {
            // 1. Validasi awal (boleh terima bulan sebagai angka atau nama)
            $validator = Validator::make($request->all(), [
                'nama_laporan' => 'required|string|max:255',
                'laporan_perdata_path'    => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:5120', // 5MB
                'catatan'      => 'nullable|string|max:1000',
                'bulan'        => 'required', // bisa angka atau teks
                'tahun'        => 'required|integer|min:2000',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            // 2. Normalisasi bulan -> jadi integer 1..12
            $bulanInput = $request->input('bulan');

            if (is_numeric($bulanInput)) {
                $bulanInt = (int) $bulanInput;
            } else {
                // dukung nama bulan Bahasa Indonesia (case-insensitive)
                $bulanMap = [
                    'januari'   => 1, 'februari' => 2, 'maret'    => 3, 'april'   => 4,
                    'mei'       => 5, 'juni'     => 6, 'juli'     => 7, 'agustus' => 8,
                    'september' => 9, 'oktober'  => 10,'november' => 11,'desember'=> 12,
                ];

                $key = mb_strtolower(trim($bulanInput));
                if (isset($bulanMap[$key])) {
                    $bulanInt = $bulanMap[$key];
                } else {
                    // fallback: coba parse dengan Carbon (mis. "Sep 2025" atau bahasa lain)
                    try {
                        $parsed = Carbon::parse('1 ' . $bulanInput);
                        $bulanInt = (int) $parsed->month;
                    } catch (\Exception $e) {
                        return back()->withErrors(['bulan' => 'Format bulan tidak dikenali. Gunakan angka (1-12) atau nama bulan.'])->withInput();
                    }
                }
            }

            if ($bulanInt < 1 || $bulanInt > 12) {
                return back()->withErrors(['bulan' => 'Bulan tidak valid'])->withInput();
            }

            // 3. Ambil nama bulan (Bahasa Indonesia) dengan cara yang aman
            $bulanNama = Carbon::create(null, $bulanInt, 1)->locale('id')->translatedFormat('F'); 
            // contoh: "September"

            // 4. Persiapkan folder & nama file (escape/slug dan timestamp agar unik)
            $folderPath = "laporan_perdata/{$bulanNama}";
            $safeNama = Str::slug($request->nama_laporan, '_'); // ganti spasi jadi underscore
            $extension = $request->file('laporan_perdata_path')->getClientOriginalExtension();
            $fileName = "{$safeNama}_{$request->tahun}_{$bulanInt}.{$extension}";

            // 5. Upload file ke storage/app/public/laporan_perdata/{Bulan}/
            $filePath = $request->file('laporan_perdata_path')->storeAs($folderPath, $fileName, 'public');

            // 6. Cari atau buat entri induk laporan_perdata untuk bulan & tahun itu
            $laporanPerdata = \App\Models\LaporanPerdata::firstOrCreate([
                'bulan' => $bulanInt,
                'tahun' => $request->tahun,
            ]);

            // 7. Simpan detail (gunakan relasi yang ada di model Anda)
            $laporanPerdata->laporan_perdata_detail()->create([
                'nama_laporan' => $request->nama_laporan,
                'laporan_perdata_path'    => $filePath,
                'catatan'      => $request->catatan ?? null,
                'created_by'   => Auth::user()->nama_lengkap ?? Auth::user()->name ?? null,
            ]);

            Alert::success('Sukses!', "Laporan '{$request->nama_laporan}' berhasil diupload.");
            return redirect()->route('laporan_perdata.index', [
                'bulan' => $bulanInt,
                'tahun' => $request->tahun,
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal menyimpan laporan perdata', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            Alert::error('Gagal!', 'Terjadi kesalahan saat menyimpan laporan: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function update(Request $request, LaporanPerdataDetail $laporan_perdata_detail)
    {
        try {
            // 🔎 Validasi
            $validator = Validator::make($request->all(), [
                'edit_nama_laporan'    => 'required|string|max:255',
                'edit_catatan'         => 'nullable|string',
                'laporan_perdata_path' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $newNama   = $request->edit_nama_laporan;
            $filePath  = $laporan_perdata_detail->laporan_perdata_path;

            // 🔎 Ambil tahun & bulan dari file lama (fallback ke sekarang jika kosong)
            if (!empty($filePath)) {
                $basename  = basename($filePath); // contoh: laporan_kegiatan_2025_09.pdf
                $parts     = explode('_', pathinfo($basename, PATHINFO_FILENAME));
                
                // Ambil tahun & bulan dari nama file
                $tahun     = $parts[count($parts)-2] ?? date('Y');
                $bulanInt  = $parts[count($parts)-1] ?? date('m');

                // Ambil nama bulan dari folder path lama
                $folderOld = explode('/', $filePath)[1] ?? Carbon::create(null, $bulanInt, 1)->locale('id')->translatedFormat('F');
                $bulanNama = $folderOld;
            } else {
                // fallback kalau file lama belum ada
                $tahun     = date('Y');
                $bulanInt  = date('m');
                $bulanNama = Carbon::create(null, $bulanInt, 1)->locale('id')->translatedFormat('F');
            }

            $safeNama = Str::slug($newNama, '_');

            // ✅ Jika upload file baru
            if ($request->hasFile('laporan_perdata_path')) {
                // Hapus file lama
                if (!empty($laporan_perdata_detail->laporan_perdata_path) 
                    && Storage::disk('public')->exists($laporan_perdata_detail->laporan_perdata_path)) {
                    Storage::disk('public')->delete($laporan_perdata_detail->laporan_perdata_path);
                }

                $ext      = $request->file('laporan_perdata_path')->getClientOriginalExtension();
                $folder   = "laporan_perdata/{$bulanNama}";
                $fileName = "{$safeNama}_{$tahun}_{$bulanInt}.{$ext}";

                $filePath = $request->file('laporan_perdata_path')->storeAs($folder, $fileName, 'public');
            } else {
                // ✅ Jika hanya ganti nama laporan → rename file lama
                if ($laporan_perdata_detail->nama_laporan !== $newNama && !empty($filePath)) {
                    if (Storage::disk('public')->exists($filePath)) {
                        $ext     = pathinfo($filePath, PATHINFO_EXTENSION);
                        $folder  = "laporan_perdata/{$bulanNama}";
                        $newName = "{$safeNama}_{$tahun}_{$bulanInt}.{$ext}";
                        $newPath = "{$folder}/{$newName}";

                        Storage::disk('public')->move($filePath, $newPath);
                        $filePath = $newPath;
                    }
                }
            }

            // ✅ Update DB
            $laporan_perdata_detail->update([
                'nama_laporan'         => $newNama,
                'catatan'              => $request->edit_catatan,
                'laporan_perdata_path' => $filePath,
            ]);

            Alert::success('Sukses!', 'Laporan berhasil diperbarui.');
            return redirect()->back();

        } catch (\Exception $e) {
            Log::error('Gagal memperbarui laporan', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            Alert::error('Gagal!', 'Terjadi kesalahan: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function destroy(LaporanPerdataDetail $laporanPerdataDetail)
    {
        try {
            // Hapus file dari storage jika ada
            if ($laporanPerdataDetail->laporan_perdata_path && 
                Storage::disk('public')->exists($laporanPerdataDetail->laporan_perdata_path)) {
                Storage::disk('public')->delete($laporanPerdataDetail->laporan_perdata_path);
            }

            // Hapus data dari database
            $laporanPerdataDetail->delete();

            Alert::success('Sukses!', 'Laporan berhasil dihapus.');
            return back();
        } catch (\Exception $e) {
            Log::error('Gagal menghapus laporan perdata detail', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            Alert::error('Gagal!', 'Terjadi kesalahan saat menghapus laporan: ' . $e->getMessage());
            return back();
        }
    }

}