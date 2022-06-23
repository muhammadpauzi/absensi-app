<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\FlareClient\Http\Exceptions\NotFound;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PresenceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::all()->sortByDesc('data.is_end')->sortByDesc('data.is_start');

        return view('presences.index', [
            "title" => "Daftar Absensi Dengan Kehadiran",
            "attendances" => $attendances
        ]);
    }

    public function show(Attendance $attendance)
    {
        $attendance->load(['positions', 'presences']);

        // dd($qrcode);
        return view('presences.show', [
            "title" => "Data Detail Kehadiran",
            "attendance" => $attendance,
        ]);
    }

    public function showQrcode()
    {
        $code = request('code');
        $qrcode = $this->getQrCode($code);

        return view('presences.qrcode', [
            "title" => "Generate Absensi QRCode",
            "qrcode" => $qrcode,
            "code" => $code
        ]);
    }

    public function downloadQrCodePDF()
    {
        $code = request('code');
        $qrcode = $this->getQrCode($code);

        $html = '<img src="' . $qrcode . '" />';
        return Pdf::loadHTML($html)->setWarnings(false)->download('qrcode.pdf');
    }

    public function getQrCode(?string $code): string
    {
        if (!Attendance::query()->where('code', $code)->first())
            throw new NotFoundHttpException(message: "Tidak ditemukan absensi dengan code '$code'.");

        $qrcodeUrl = URL::route('home.qrcode', ['code' => $code]);
        $qrcode = "data:image/svg+xml;base64," . base64_encode(QrCode::size(300)->style('round')->generate($qrcodeUrl));

        return $qrcode;
    }
}
