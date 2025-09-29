<?php

namespace App\Http\Controllers;

use App\Models\ArsipGugatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class ArsipGugatanController extends Controller
{
    public function index()
    {
        return view('arsip_gugatan.index', [
            'breadcrumbs' => ['Arsip Gugatan'],
        ]);
    }

    public function getData(Request $request)
    {
        $query = ArsipGugatan::query();

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
            if (in_array($columnName, ['id','no_berkas','bulan','arsip_gugatan_path','created_by', 'updated_by'])) {
                $query->orderBy($columnName, $dir);
            }
        }

        // Default order by created_at DESC
        $query->orderBy('created_at', 'desc');

        // Paging
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $data = $query->skip($start)->take($length)->get();

        // Transform data (file + aksi)
        $data->transform(function ($item) {
            $url = asset('storage/'.$item->arsip_gugatan_path);
            $ext = strtolower(pathinfo($item->arsip_gugatan_path, PATHINFO_EXTENSION));

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

            $item->arsip_gugatan_path = '<a href="'.$url.'" target="_blank">'.$icon.' Lihat File</a>';

            // Pastikan updated_by selalu ada (kalau null diganti '-')
            $item->updated_by = $item->updated_by ?? '-';

            if (Auth::check() && in_array(Auth::user()->role, ['Staff Kepaniteraan Hukum', 'Admin'])) {
                $editUrl = route('arsip_gugatan.edit', $item->id);
                $deleteUrl = route('arsip_gugatan.destroy', $item->id);

                // $editUrl = '#';
                // $deleteUrl = '#';

                $item->aksi = '
                    <a href="'.$editUrl.'" class="text-warning font-weight-bold text-xs me-2">Edit</a>
                    |
                    <form action="'.$deleteUrl.'" method="POST" class="d-inline form-delete">
                        '.csrf_field().method_field('DELETE').'
                        <button type="button" class="btn btn-link p-0 m-0 text-danger text-xs btn-delete">Hapus</button>
                    </form>
                ';
            } else {
                $item->aksi = '-';
            }

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
        return view('arsip_gugatan.create', [
            'breadcrumbs' => ['Arsip Gugatan', 'Tambah Arsip Gugatan'],
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
                'arsip_gugatan' => 'required|file|mimes:pdf|max:2048', // hanya PDF
            ]);

            // Buat No Berkas
            $noBerkas = "{$request->no_urut}.Pdt.G.{$request->tahun_berkas}.PN Kmn";

            // 🔎 Cek duplikat
            $duplicate = ArsipGugatan::where('no_berkas', $noBerkas)->exists();
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
            $folderPath = "arsip_gugatan/{$request->tahun_berkas}/{$request->bulan}";

            // Upload file
            $file = $request->file('arsip_gugatan');
            $filePath = $file->storeAs(
                $folderPath,
                "{$noBerkas}.pdf",
                'public'
            );

            // Simpan ke database
            ArsipGugatan::create([
                'no_berkas' => $noBerkas,
                'bulan' => $request->bulan,
                'arsip_gugatan_path' => $filePath,
                'created_by' => Auth::user()->nama_lengkap,
            ]);

            Alert::success('Sukses!', 'Arsip gugatan berhasil ditambahkan.');
            return redirect()->route('arsip_gugatan.index');

        } catch (\Exception $e) {
            Log::error('Gagal menyimpan arsip gugatan', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            Alert::error('Gagal!', 'Terjadi kesalahan saat menyimpan arsip: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function edit(ArsipGugatan $arsip_gugatan)
    {
        return view('arsip_gugatan.edit', [
            'breadcrumbs' => ['Arsip Gugatan', 'Edit Arsip Gugatan'],
            'arsip_gugatan' => $arsip_gugatan
        ]);
    }

    public function update(Request $request, ArsipGugatan $arsip_gugatan)
    {
        try {
            // Buat validator manual supaya bisa tambah error custom
            $validator = Validator::make($request->all(), [
                'no_urut' => 'required|integer|min:1',
                'tahun_berkas' => 'required|integer|min:2000',
                'bulan' => 'required|string',
                'arsip_gugatan' => 'nullable|file|mimes:pdf|max:2048',
            ]);

            // Buat No Berkas baru
            $noBerkas = "{$request->no_urut}.Pdt.G.{$request->tahun_berkas}.PN Kmn";

            // Cek duplicate
            $duplicate = ArsipGugatan::where('no_berkas', $noBerkas)
                ->where('id', '!=', $arsip_gugatan->id)
                ->exists();

            if ($duplicate) {
                $validator->after(function ($v) use ($noBerkas) {
                    $v->errors()->add('no_urut', "No Berkas '{$noBerkas}' sudah ada. Silakan gunakan nomor lain.");
                });
            }

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            // Tentukan folder berdasarkan tahun & bulan
            $folderPath = "arsip_gugatan/{$request->tahun_berkas}/{$request->bulan}";

            $filePath = $arsip_gugatan->arsip_gugatan_path; // default path lama

            if ($request->hasFile('arsip_gugatan')) {
                // Upload file baru → hapus file lama
                if ($filePath && Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }

                $file = $request->file('arsip_gugatan');
                $filePath = $file->storeAs($folderPath, "{$noBerkas}.pdf", 'public');
            } else {
                // Tidak ada file baru → cek perubahan folder
                if ($filePath && Storage::disk('public')->exists($filePath)) {
                    $newPath = $folderPath . "/{$noBerkas}.pdf";
                    if ($filePath !== $newPath) {
                        Storage::disk('public')->move($filePath, $newPath);
                        $filePath = $newPath;
                    }
                } else {
                    $filePath = $folderPath . "/{$noBerkas}.pdf";
                }
            }

            // Update database
            $arsip_gugatan->update([
                'no_berkas' => $noBerkas,
                'bulan' => $request->bulan,
                'arsip_gugatan_path' => $filePath,
                'updated_by' => Auth::user()->nama_lengkap,
            ]);

            Alert::success('Sukses!', 'Arsip gugatan berhasil diperbarui.');
            return redirect()->route('arsip_gugatan.index');

        } catch (\Exception $e) {
            Log::error('Gagal memperbarui arsip gugatan', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            Alert::error('Gagal!', 'Terjadi kesalahan saat memperbarui arsip.');
            return back()->withInput();
        }
    }

    public function destroy(ArsipGugatan $arsip_gugatan)
    {
        try {
            // Hapus file PDF dari storage jika ada
            if ($arsip_gugatan->arsip_gugatan_path && Storage::disk('public')->exists($arsip_gugatan->arsip_gugatan_path)) {
                Storage::disk('public')->delete($arsip_gugatan->arsip_gugatan_path);
            }

            // Hapus data dari database
            $arsip_gugatan->delete();

            Alert::success('Sukses!', 'Arsip gugatan berhasil dihapus.');
            return redirect()->route('arsip_gugatan.index');

        } catch (\Exception $e) {
            Log::error('Gagal menghapus arsip gugatan', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            Alert::error('Gagal!', 'Terjadi kesalahan saat menghapus arsip: ' . $e->getMessage());
            return back();
        }
    }


}