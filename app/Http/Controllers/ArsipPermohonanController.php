<?php

namespace App\Http\Controllers;

use App\Models\ArsipPermohonan;
use Illuminate\Http\Request;

class ArsipPermohonanController extends Controller
{
    public function index()
    {
        return view('arsip_permohonan.index', [
            'breadcrumbs' => ['Arsip Permohonan'],
            'arsip_permohonan' => ArsipPermohonan::all()
        ]);
    }
}