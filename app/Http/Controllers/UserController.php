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
            'pengguna' => User::latest()->get()
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

    public function edit(User $user)
    {
        return view('pengguna.edit', [
            'breadcrumbs' => ['Pengguna', 'Edit Pengguna'],
            'pengguna' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'role'         => 'required|string|max:255',
            'username'     => 'required|string|max:255|unique:users,username,' . $user->id . ',id',
            'password'     => 'nullable|string|min:6',
        ]);

        try {
            if (!empty($validatedData['password'])) {
                $validatedData['password'] = bcrypt($validatedData['password']);
            } else {
                unset($validatedData['password']);
            }

            // Update data pengguna tanpa foto dulu
            $user->update($validatedData);

            Alert::success('Sukses!', 'Data Berhasil Diupdate');
            return redirect()->route('pengguna.index');
        } catch (\Exception $e) {
            Log::error('Gagal update pengguna', ['error' => $e->getMessage()]);
            Alert::error('Error', 'Terjadi kesalahan saat mengupdate data');
            return back()->withInput();
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();

            Alert::success('Berhasil', 'Data berhasil dihapus');
            return redirect()->route('pengguna.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus data');
            return back();
        }
    }
}