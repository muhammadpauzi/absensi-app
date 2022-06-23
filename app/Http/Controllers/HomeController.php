<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $attendances = Attendance::query()
            // ->with('positions')
            ->forCurrentUser(auth()->user()->position_id)
            ->get()
            ->sortByDesc('data.is_end')
            ->sortByDesc('data.is_start');

        return view('home.index', [
            "title" => "Beranda",
            "attendances" => $attendances
        ]);
    }

    public function show(Attendance $attendance)
    {
        $attendance->load(['presences']);

        return view('home.show', [
            "title" => "Informasi Absensi Kehadiran",
            "attendance" => $attendance,
            'qrcode' => $this->getQrCode($attendance->code)
        ]);
    }
}
