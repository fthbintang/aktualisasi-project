<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArsipPermohonan;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class ArsipPermohonanController extends Controller
{
    public function index()
    {
        return view('arsip_permohonan.index', [
            'breadcrumbs' => ['Arsip Permohonan'],
        ]);
    }

    public function getData(Request $request)
    {
        $query = ArsipPermohonan::query();

        $totalRecords = $query->count();

        // Filtering
        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where('no_berkas', 'like', "%{$search}%")
                    ->orWhere('bulan', 'like', "%{$search}%")
                    ->orWhere('created_by', 'like', "%{$search}%")
                    ->orWhere('updated_by', 'like', "%{$search}%");
            });
        }

        $filteredRecords = $query->count();

        // Ordering
        if ($request->has('order')) {
            $columns = $request->input('columns');
            $order = $request->input('order')[0];
            $columnName = $columns[$order['column']]['data'];
            $dir = $order['dir'];
            if (in_array($columnName, ['id','no_berkas','bulan','arsip_permohonan_path','created_by', 'updated_by'])) {
                $query->orderBy($columnName, $dir);
            }
        }

        // Default order by created_at DESC
        $query->orderBy('created_at', 'desc');

        // Paging
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $data = $query->skip($start)->take($length)->get();

        // Transform data (file + aksi) tetap sama
        $data->transform(function ($item) {
            $url = asset('storage/'.$item->arsip_permohonan_path);
            $ext = strtolower(pathinfo($item->arsip_permohonan_path, PATHINFO_EXTENSION));

            switch ($ext) {
                case 'pdf':
                    $icon = '<i class="bi bi-file-earmark-pdf-fill text-danger"></i>';
                    break;
                case 'doc':
                case 'docx':
                    $icon = '<i class="bi bi-file-earmark-word-fill text-primary"></i>';
                    break;
                case 'xls':
                case 'xlsx':
                    $icon = '<i class="bi bi-file-earmark-excel-fill text-success"></i>';
                    break;
                default:
                    $icon = '<i class="bi bi-file-earmark-fill text-secondary"></i>';
            }
            $item->arsip_permohonan_path = '<a href="'.$url.'" target="_blank">'.$icon.' Lihat File</a>';

            // Pastikan updated_by selalu ada (kalau null diganti '-')
            $item->updated_by = $item->updated_by ?? '-';

            $editUrl = route('arsip_permohonan.edit', $item->id);
            $deleteUrl = route('arsip_permohonan.destroy', $item->id);

            $item->aksi = '
                <a href="'.$editUrl.'" class="text-warning font-weight-bold text-xs me-2">Edit</a>
                |
                <form action="'.$deleteUrl.'" method="POST" class="d-inline form-delete">
                    '.csrf_field().method_field('DELETE').'
                    <button type="button" class="btn btn-link p-0 m-0 text-danger text-xs btn-delete">Hapus</button>
                </form>
            ';
            return $item;
        });

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
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
            // Validasi awal
            $validator = Validator::make($request->all(), [
                'no_urut' => 'required|integer|min:1',
                'tahun_berkas' => 'required|integer|min:2000',
                'bulan' => 'required|string',
                'arsip_permohonan' => 'required|file|mimes:pdf|max:2048', // hanya PDF
            ]);

            // Buat No Berkas
            $noBerkas = "{$request->no_urut}.Pdt.P.{$request->tahun_berkas}.PN Kmn";

            // 🔎 Cek duplikat
            $duplicate = ArsipPermohonan::where('no_berkas', $noBerkas)->exists();
            if ($duplicate) {
                $validator->after(function ($v) use ($noBerkas) {
                    $v->errors()->add('no_urut', "No Berkas '{$noBerkas}' sudah ada. Silakan gunakan nomor lain.");
                });
            }

            // Jika validasi gagal
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            // Tentukan path folder berdasarkan tahun & bulan
            $folderPath = "arsip_permohonan/{$request->tahun_berkas}/{$request->bulan}";

            // Upload file
            $file = $request->file('arsip_permohonan');
            $filePath = $file->storeAs(
                $folderPath,
                "{$noBerkas}.pdf",
                'public'
            );

            // Simpan ke database
            ArsipPermohonan::create([
                'no_berkas' => $noBerkas,
                'bulan' => $request->bulan,
                'arsip_permohonan_path' => $filePath,
                'created_by' => Auth::user()->nama_lengkap,
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
        ]);
    }

    public function update(Request $request, ArsipPermohonan $arsip_permohonan)
    {
        try {
            // Validasi awal
            $validator = Validator::make($request->all(), [
                'no_urut' => 'required|integer|min:1',
                'tahun_berkas' => 'required|integer|min:2000',
                'bulan' => 'required|string',
                'arsip_permohonan' => 'nullable|file|mimes:pdf|max:2048',
            ]);

            // Buat No Berkas baru
            $noBerkas = "{$request->no_urut}.Pdt.P.{$request->tahun_berkas}.PN Kmn";

            // 🔎 Cek duplikat (kecuali record yang sedang diedit)
            $duplicate = ArsipPermohonan::where('no_berkas', $noBerkas)
                ->where('id', '!=', $arsip_permohonan->id)
                ->exists();

            if ($duplicate) {
                $validator->after(function ($v) use ($noBerkas) {
                    $v->errors()->add('no_urut', "No Berkas '{$noBerkas}' sudah ada. Silakan gunakan nomor lain.");
                });
            }

            // Jika validasi gagal
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            // Tentukan folder baru berdasarkan tahun & bulan
            $folderPath = "arsip_permohonan/{$request->tahun_berkas}/{$request->bulan}";
            $filePath = $arsip_permohonan->arsip_permohonan_path; // default tetap pakai path lama

            if ($request->hasFile('arsip_permohonan')) {
                // Hapus file lama jika ada
                if (!empty($arsip_permohonan->arsip_permohonan_path) 
                    && Storage::disk('public')->exists($arsip_permohonan->arsip_permohonan_path)) {
                    Storage::disk('public')->delete($arsip_permohonan->arsip_permohonan_path);
                }

                // Upload file baru
                $file = $request->file('arsip_permohonan');
                $filePath = $file->storeAs(
                    $folderPath,
                    "{$noBerkas}.pdf",
                    'public'
                );
            } else {
                // Jika tidak ada file baru tapi info berubah → pindahkan file lama
                if (!empty($arsip_permohonan->arsip_permohonan_path)) {
                    $oldPath = $arsip_permohonan->arsip_permohonan_path;
                    $newPath = $folderPath . "/{$noBerkas}.pdf";

                    if ($oldPath !== $newPath && Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->move($oldPath, $newPath);
                    }

                    $filePath = $newPath;
                }
            }

            // Update database
            $arsip_permohonan->update([
                'no_berkas' => $noBerkas,
                'bulan' => $request->bulan,
                'arsip_permohonan_path' => $filePath,
                'updated_by' => Auth::user()->nama_lengkap,
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

    public function destroy(ArsipPermohonan $arsip_permohonan)
    {
        try {
            // Hapus file PDF dari storage jika ada
            if ($arsip_permohonan->arsip_permohonan_path && Storage::disk('public')->exists($arsip_permohonan->arsip_permohonan_path)) {
                Storage::disk('public')->delete($arsip_permohonan->arsip_permohonan_path);
            }

            // Hapus data dari database
            $arsip_permohonan->delete();

            Alert::success('Sukses!', 'Arsip permohonan berhasil dihapus.');
            return redirect()->route('arsip_permohonan.index');

        } catch (\Exception $e) {
            Log::error('Gagal menghapus arsip permohonan', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            Alert::error('Gagal!', 'Terjadi kesalahan saat menghapus arsip: ' . $e->getMessage());
            return back();
        }
    }

}