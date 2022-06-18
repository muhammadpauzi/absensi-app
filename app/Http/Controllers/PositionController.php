<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        return view('positions.index', [
            "title" => "Jabatan / Posisi"
        ]);
    }

    public function create()
    {
        return view('positions.create', [
            "title" => "Tambah Data Jabatan / Posisi"
        ]);
    }
}
