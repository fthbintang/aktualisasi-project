<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PermohonanTidakDipidana;

class PermohonanDashboardController extends Controller
{
    public function index()
    {
        return view('tidak_dipidana.index', [
            'breadcrumbs' => ['Permohonan Tidak Dipidana'],
        ]);
    }

    public function getData(Request $request)
    {
        $query = PermohonanTidakDipidana::query();

        $totalRecords = $query->count();

        // Filtering (pencarian)
        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('tempat_lahir', 'like', "%{$search}%")
                    ->orWhere('tanggal_lahir', 'like', "%{$search}%")
                    ->orWhere('jenis_kelamin', 'like', "%{$search}%")
                    ->orWhere('pekerjaan', 'like', "%{$search}%")
                    ->orWhere('keperluan', 'like', "%{$search}%");
            });
        }

        $filteredRecords = $query->count();

        // Ordering
        if ($request->has('order')) {
            $columns = $request->input('columns');
            $order = $request->input('order')[0];
            $columnName = $columns[$order['column']]['data'];
            $dir = $order['dir'];
            if (in_array($columnName, [
                'id',
                'nama',
                'tanggal_lahir',
                'jenis_kelamin',
                'pekerjaan',
                'created_at'
            ])) {
                $query->orderBy($columnName, $dir);
            }
        }

        // Default order by created_at DESC
        $query->orderBy('created_at', 'desc');

        // Paging
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $data = $query->skip($start)->take($length)->get();

        // Tambahkan kolom aksi
        $data->transform(function ($item) {
            // $editUrl = route('permohonan_tidak_dipidana.edit', $item->id);
            // $deleteUrl = route('permohonan_tidak_dipidana.destroy', $item->id);

        $editUrl = "#";
        $deleteUrl = "#";
        $cetakUrl = route('permohonan_tidak_dipidana.cetak', $item->id);

        $item->aksi = '
            <a href="' . $editUrl . '" class="text-warning font-weight-bold text-xs me-2">Edit</a> |
            <a href="' . $cetakUrl . '" target="_blank" class="text-primary font-weight-bold text-xs mx-2">Cetak</a> |
            <form action="' . $deleteUrl . '" method="POST" class="d-inline form-delete">
                ' . csrf_field() . method_field('DELETE') . '
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

    public function cetak_tidak_dipidana($id)
    {
        $data = PermohonanTidakDipidana::findOrFail($id);

        $pdf = Pdf::loadView('pdf.surat_permohonan_tidak_dipidana', compact('data'));
        return $pdf->stream('Surat_Keterangan_Tidak_Dipidana_' . $data->nama . '.pdf');
    }

}