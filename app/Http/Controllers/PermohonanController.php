<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermohonanTidakDipidana;

class PermohonanController extends Controller
{
    public function index()
    {
        return view('permohonan.pilih_permohonan');
    }

    public function index_tidak_dipidana()
    {
        return view('permohonan.tidak_dipidana');
    }

    public function store_tidak_dipidana(Request $request)
    {
        // ✅ Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|max:50',
            'pekerjaan' => 'required|string|max:255',
            'alamat_sesuai_identitas' => 'required|string',
            'alamat_domisili' => 'required|string',
            'keperluan' => 'required|string|max:255',
        ]);

        // ✅ Simpan ke database
        PermohonanTidakDipidana::create($validatedData);

        // ✅ Redirect ke halaman sukses
        return redirect()
            ->back()
            ->with('success', 'Permohonan berhasil dikirim. Silakan menginformasikan kepada petugas PTSP agar mencetak surat permohonan sesuai data yang telah Anda isi.');
    }
}