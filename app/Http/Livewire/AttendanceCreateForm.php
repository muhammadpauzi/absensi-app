<?php

namespace App\Http\Livewire;

use App\Models\Attendance;
use \Illuminate\Support\Str;

class AttendanceCreateForm extends AttendanceAbstract
{
    public function save()
    {
        // filter value before validate
        $this->position_ids = array_filter($this->position_ids, function ($id) {
            return is_numeric($id);
        });

        $position_ids = array_values($this->position_ids);

        $this->validate();

        if (array_key_exists("code", $this->attendance) && $this->attendance['code']) // jika menggunakan qrcode
            $this->attendance['code'] = Str::random();

        $attendance = Attendance::create($this->attendance);
        $attendance->positions()->attach($position_ids);

        redirect()->route('attendances.index')->with('success', "Data absensi berhasil ditambahkan.");
    }

    public function render()
    {
        return view('livewire.attendance-create-form');
    }
}
