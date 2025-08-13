<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index()
    {
        return view('pengguna.index', [
            'breadcrumbs' => ['Pengguna'],
            'pengguna' => User::all(),
        ]);
    }

    public function create()
    {
        return view('pengguna.create', [
            'breadcrumbs' => ['Pengguna', 'Tambah Pengguna'],
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'role'         => 'required|string|max:255',
            'username'     => 'required|string|max:255|unique:users,username',
            'password'     => 'required|string|min:6',
        ]);

        try {
            // Hash password
            $validatedData['password'] = bcrypt($validatedData['password']);

            // Simpan user baru
            User::create($validatedData);

            Alert::success('Sukses!', 'Data Berhasil Ditambah');
            return redirect()->route('pengguna.index');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan user baru', ['error' => $e->getMessage()]);
            Alert::error('Error', 'Terjadi kesalahan saat menyimpan data');
            return back()->withInput();
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}