<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employees.index', [
            "title" => "Karyawaan"
        ]);
    }

    public function create()
    {
        return view('employees.create', [
            "title" => "Tambah Data Karyawaan"
        ]);
    }

    public function edit()
    {
        $ids = request('ids');
        if (!$ids)
            return redirect()->back();
        $ids = explode('-', $ids);

        // ambil data user yang hanya memiliki User::USER_ROLE_ID / role untuk karyawaan
        $employees = User::query()
            ->whereIn('id', $ids)
            ->get();

        return view('employees.edit', [
            "title" => "Edit Data Karyawaan",
            "employees" => $employees
        ]);
    }
}
