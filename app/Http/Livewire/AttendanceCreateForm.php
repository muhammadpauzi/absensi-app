<?php

namespace App\Http\Livewire;

use App\Models\Attendance;
use App\Models\Position;
use Livewire\Component;
use \Illuminate\Support\Str;

class AttendanceCreateForm extends Component
{
    public $attendance;
    public $positions;
    public $position_ids;

    protected $rules = [
        'attendance.title' => 'required|string|min:6',
        'attendance.description' => 'required|string|max:500',
        'attendance.start_time' => 'required|date_format:H:i',
        'attendance.batas_start_time' => 'required|date_format:H:i|after:start_time',
        'attendance.end_time' => 'required|date_format:H:i',
        'attendance.batas_end_time' => 'required|date_format:H:i|after:end_time',
        'attendance.code' => 'present|boolean',
        'position_ids' => 'required|array',
        "position_ids.*"  => "required|string|distinct|numeric",
    ];

    public function mount()
    {
        $this->positions = Position::query()->select(['id', 'name'])->get();
    }

    public function save()
    {
        // filter value before validate
        $this->position_ids = array_values(array_filter($this->position_ids, function ($id) {
            return is_numeric($id);
        }));

        $this->validate();

        if ($this->attendance['code']) // jika menggunakan qrcode
            $this->attendance['code'] = Str::random();

        $attendance = Attendance::create($this->attendance);
        $attendance->positions()->attach($this->position_ids);

        redirect()->route('attendances.index')->with('success', "Data absensi berhasil ditambahkan.");
    }

    public function render()
    {
        return view('livewire.attendance-create-form');
    }
}
