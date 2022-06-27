<?php

namespace App\Http\Livewire;

use App\Models\Permission;
use Livewire\Component;

class PermissionForm extends Component
{
    public $permission;
    public $attendanceId;

    protected $rules = [
        'permission.title' => 'required|string|min:6',
        'permission.description' => 'required|string|max:500',
    ];

    public function save()
    {
        $this->validate();

        Permission::create([
            "user_id" => auth()->user()->id,
            "attendance_id" => $this->attendanceId,
            "title" => $this->permission['title'],
            "description" => $this->permission['description'],
            "permission_date" => now()->toDateString()
        ]);

        return redirect()->route('home.show', $this->attendanceId)->with('success', 'Permintaan izin sedang diproses. Silahkan tunggu...');
    }

    public function render()
    {
        return view('livewire.permission-form');
    }
}
