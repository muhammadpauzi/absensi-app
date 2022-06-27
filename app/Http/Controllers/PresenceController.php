<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Permission;
use App\Models\Presence;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
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

        return parent::getQrCode($code);
    }

    public function notPresent(Attendance $attendance)
    {
        $byDate = now()->toDateString();
        if (request('display-by-date'))
            $byDate = request('display-by-date');

        $presences = Presence::query()
            ->where('attendance_id', $attendance->id)
            ->where('presence_date', $byDate)
            ->get(['presence_date', 'user_id']);

        // jika semua karyawan tidak hadir
        if ($presences->isEmpty()) {
            $notPresentData[] =
                [
                    "not_presence_date" => $byDate,
                    "users" => User::query()
                        ->with('position')
                        ->onlyEmployees()
                        ->get()
                        ->toArray()
                ];
        } else {
            $notPresentData = $this->getNotPresentEmployees($presences);
        }


        return view('presences.not-present', [
            "title" => "Data Karyawan Tidak Hadir",
            "attendance" => $attendance,
            "notPresentData" => $notPresentData
        ]);
    }

    public function permissions(Attendance $attendance)
    {
        $byDate = now()->toDateString();
        if (request('display-by-date'))
            $byDate = request('display-by-date');

        $permissions = Permission::query()
            ->with(['user', 'user.position'])
            ->where('attendance_id', $attendance->id)
            ->where('permission_date', $byDate)
            ->get();

        return view('presences.permissions', [
            "title" => "Data Karyawan Izin",
            "attendance" => $attendance,
            "permissions" => $permissions,
            "date" => $byDate
        ]);
    }

    public function presentUser(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'user_id' => 'required|string|numeric',
            "presence_date" => "required|date"
        ]);

        $user = User::findOrFail($validated['user_id']);

        $presence = Presence::query()
            ->where('attendance_id', $attendance->id)
            ->where('user_id', $user->id)
            ->where('presence_date', $validated['presence_date'])
            ->first();

        // jika data user yang didapatkan dari request user_id, presence_date, sudah absen atau sudah ada ditable presences
        if ($presence || !$user)
            return back()->with('failed', 'Request tidak diterima.');

        Presence::create([
            "attendance_id" => $attendance->id,
            "user_id" => $user->id,
            "presence_date" => $validated['presence_date'],
            "presence_enter_time" => now()->toTimeString(),
            "presence_out_time" => now()->toTimeString()
        ]);

        return back()
            ->with('success', "Berhasil menyimpan data hadir atas nama \"$user->name\".");
    }

    public function acceptPermission(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'user_id' => 'required|string|numeric',
            "permission_date" => "required|date"
        ]);

        $user = User::findOrFail($validated['user_id']);

        $permission = Permission::query()
            ->where('attendance_id', $attendance->id)
            ->where('user_id', $user->id)
            ->where('permission_date', $validated['permission_date'])
            ->first();

        $presence = Presence::query()
            ->where('attendance_id', $attendance->id)
            ->where('user_id', $user->id)
            ->where('presence_date', $validated['permission_date'])
            ->first();

        // jika data user yang didapatkan dari request user_id, presence_date, sudah absen atau sudah ada ditable presences
        if ($presence || !$user)
            return back()->with('failed', 'Request tidak diterima.');

        Presence::create([
            "attendance_id" => $attendance->id,
            "user_id" => $user->id,
            "presence_date" => $validated['permission_date'],
            "presence_enter_time" => now()->toTimeString(),
            "presence_out_time" => now()->toTimeString(),
            'is_permission' => true
        ]);

        $permission->update([
            'is_accepted' => 1
        ]);

        return back()
            ->with('success', "Berhasil menerima data izin karyawan atas nama \"$user->name\".");
    }

    private function getNotPresentEmployees($presences)
    {
        $uniquePresenceDates = $presences->unique("presence_date")->pluck('presence_date');
        $uniquePresenceDatesAndCompactTheUserIds = $uniquePresenceDates->map(function ($date) use ($presences) {
            return [
                "presence_date" => $date,
                "user_ids" => $presences->where('presence_date', $date)->pluck('user_id')->toArray()
            ];
        });
        $notPresentData = [];
        foreach ($uniquePresenceDatesAndCompactTheUserIds as $presence) {
            $notPresentData[] =
                [
                    "not_presence_date" => $presence['presence_date'],
                    "users" => User::query()
                        ->with('position')
                        ->onlyEmployees()
                        ->whereNotIn('id', $presence['user_ids'])
                        ->get()
                        ->toArray()
                ];
        }
        return $notPresentData;
    }
}
