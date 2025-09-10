<?php

namespace App\Http\Controllers;

use App\Models\ArsipPidana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class ArsipPidanaController extends Controller
{
    public function index()
    {
        return view('arsip_pidana.index', [
            'breadcrumbs' => ['Arsip Pidana'],
        ]);
    }

    public function getData(Request $request)
    {
        $query = ArsipPidana::query();

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
            if (in_array($columnName, ['id','no_berkas','bulan','arsip_pidana_path','created_by', 'updated_by'])) {
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
            $url = asset('storage/'.$item->arsip_pidana_path);
            $ext = strtolower(pathinfo($item->arsip_pidana_path, PATHINFO_EXTENSION));

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

            $item->arsip_pidana_path = '<a href="'.$url.'" target="_blank">'.$icon.' Lihat File</a>';

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
        return view('arsip_pidana.create', [
            'breadcrumbs' => ['Arsip Pidana', 'Tambah Arsip Pidana']
        ]);
    }

    public function store(Request $request)
    {
        try {
            // Validasi awal
            $validator = Validator::make($request->all(), [
                'no_urut'       => 'required|integer|min:1',
                'tahun_berkas'  => 'required|integer|min:2000',
                'bulan'         => 'required|string',
                'arsip_pidana'  => 'required|file|mimes:pdf|max:2048', // hanya PDF
            ]);

            $noBerkas = "{$request->no_berkas}";

            // 🔎 Cek duplikat
            $duplicate = ArsipPidana::where('no_berkas', $noBerkas)->exists();
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
            $folderPath = "arsip_pidana/{$request->tahun_berkas}/{$request->bulan}";

            // Upload file dengan nama asli
            $file = $request->file('arsip_pidana');
            $filePath = $file->storeAs(
                $folderPath,
                $file->getClientOriginalName(),
                'public'
            );

            // Simpan ke database
            ArsipPidana::create([
                'no_berkas'         => $noBerkas,
                'bulan'             => $request->bulan,
                'arsip_pidana_path' => $filePath,
                'created_by'        => Auth::user()->nama_lengkap,
            ]);

            Alert::success('Sukses!', 'Arsip pidana berhasil ditambahkan.');
            return redirect()->route('arsip_pidana.index');

        } catch (\Exception $e) {
            Log::error('Gagal menyimpan arsip pidana', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            Alert::error('Gagal!', 'Terjadi kesalahan saat menyimpan arsip: ' . $e->getMessage());
            return back()->withInput();
        }
    }

}