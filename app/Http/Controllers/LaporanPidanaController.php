<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\LaporanPidana;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

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

    public function store(Request $request)
    {
        try {
            // 1. Validasi awal (boleh terima bulan sebagai angka atau nama)
            $validator = Validator::make($request->all(), [
                'nama_laporan' => 'required|string|max:255',
                'laporan_pidana_path'    => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:5120', // 5MB
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
            $folderPath = "laporan_pidana/{$bulanNama}";
            $safeNama = Str::slug($request->nama_laporan, '_'); // ganti spasi jadi underscore
            $extension = $request->file('laporan_pidana_path')->getClientOriginalExtension();
            $fileName = "{$safeNama}_{$request->tahun}_{$bulanInt}.{$extension}";

            // 5. Upload file ke storage/app/public/laporan_pidana/{Bulan}/
            $filePath = $request->file('laporan_pidana_path')->storeAs($folderPath, $fileName, 'public');

            // 6. Cari atau buat entri induk laporan_pidana untuk bulan & tahun itu
            $laporanpidana = LaporanPidana::firstOrCreate([
                'bulan' => $bulanInt,
                'tahun' => $request->tahun,
            ]);

            // 7. Simpan detail (gunakan relasi yang ada di model Anda)
            $laporanpidana->laporan_pidana_detail()->create([
                'nama_laporan' => $request->nama_laporan,
                'laporan_pidana_path'    => $filePath,
                'catatan'      => $request->catatan ?? null,
                'created_by'   => Auth::user()->nama_lengkap ?? Auth::user()->name ?? null,
            ]);

            Alert::success('Sukses!', "Laporan '{$request->nama_laporan}' berhasil diupload.");
            return redirect()->route('laporan_pidana.index', [
                'bulan' => $bulanInt,
                'tahun' => $request->tahun,
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal menyimpan laporan pidana', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            Alert::error('Gagal!', 'Terjadi kesalahan saat menyimpan laporan: ' . $e->getMessage());
            return back()->withInput();
        }
    }
}