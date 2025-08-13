<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
        //
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