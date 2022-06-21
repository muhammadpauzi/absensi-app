<?php

namespace App\Http\Livewire;

use App\Models\Attendance;

class AttendanceEditForm extends AttendanceAbstract
{
    public function mount()
    {
        parent::mount();
        $this->attendance['code'] = $this->attendance['code'] ? true : false;
        $this->position_ids = $this->attendance->positions()->pluck('positions.id', 'positions.id')->toArray();
    }

    public function save()
    {
        // filter value before validate
        $this->position_ids = array_filter($this->position_ids, function ($id) {
            return is_numeric($id);
        });
        $position_ids = array_values($this->position_ids);
        $this->validate();

        $attendance = [];
        if (!$this->attendance->code) {
            $this->attendance->code = null;
            $attendance = $this->attendance;
        } else {
            $attendance = $this->attendance->get()->except(['code'])->toArray();
        }

        $this->attendance->update($attendance);
        $this->attendance->positions()->sync($position_ids);

        redirect()->route('attendances.index')->with('success', "Data absensi berhasil diubah.");
    }

    public function render()
    {
        return view('livewire.attendance-edit-form');
    }
}
