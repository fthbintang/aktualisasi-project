<?php

namespace App\Http\Controllers;

use App\Models\ArsipGugatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

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

            // $editUrl = route('arsip_gugatan.edit', $item->id);
            // $deleteUrl = route('arsip_gugatan.destroy', $item->id);

            $editUrl = '#';
            $deleteUrl = '#';

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
        return view('arsip_gugatan.create', [
            'breadcrumbs' => ['Arsip Gugatan', 'Tambah Arsip Gugatan'],
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'no_urut' => 'required|integer|min:1',
                'tahun_berkas' => 'required|integer|min:2000',
                'bulan' => 'required|string',
                'arsip_gugatan' => 'required|file|mimes:pdf|max:2048', // Hanya PDF
            ]);

            // Buat No Berkas
            $noBerkas = "{$request->no_urut}.Pdt.G.{$request->tahun_berkas}.PN Kmn";

            // Tentukan path folder berdasarkan tahun & bulan
            $folderPath = "arsip_gugatan/{$request->tahun_berkas}/{$request->bulan}";

            // Upload file ke folder arsip_gugatan/tahun/bulan dengan nama [no_berkas].pdf
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


}