<?php

namespace App\Http\Livewire;

use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class EmployeeCreateForm extends Component
{
    public $employees;
    public Collection $roles;
    public Collection $positions;

    public function mount()
    {
        $this->positions = Position::all();
        $this->roles = Role::all();
        $this->employees = [
            ['name' => '', 'email' => '', 'phone' => '', 'password' => '', 'role_id' => User::USER_ROLE_ID, 'position_id' => $this->positions->first()->id]
        ];
    }

    public function addEmployeeInput(): void
    {
        $this->employees[] = ['name' => '', 'email' => '', 'phone' => '', 'password' => '', 'role_id' => User::USER_ROLE_ID, 'position_id' => $this->positions->first()->id];
    }

    public function removeEmployeeInput(int $index): void
    {
        unset($this->employees[$index]);
        $this->employees = array_values($this->employees);
    }

    public function saveEmployees()
    {
        // cara lebih cepat, dan kemungkinan data role tidak akan diubah/ditambah
        $roleIdRuleIn = join(',', $this->roles->pluck('id')->toArray());
        $positionIdRuleIn = join(',', $this->positions->pluck('id')->toArray());
        // $roleIdRuleIn = join(',', Role::all()->pluck('id')->toArray());

        // setidaknya input pertama yang hanya required,
        // karena nanti akan difilter apakah input kedua dan input selanjutnya apakah berisi
        $this->validate([
            'employees.*.name' => 'required',
            'employees.*.email' => 'required|email|unique:users,email',
            'employees.*.phone' => 'required|unique:users,phone',
            'employees.*.password' => '',
            'employees.*.role_id' => 'required|in:' . $roleIdRuleIn,
            'employees.*.position_id' => 'required|in:' . $positionIdRuleIn,
        ]);
        // cek apakah no. telp yang diinput unique
        $phoneNumbers = array_map(function ($employee) {
            return trim($employee['phone']);
        }, $this->employees);
        $uniquePhoneNumbers = array_unique($phoneNumbers);

        if (count($phoneNumbers) != count($uniquePhoneNumbers)) {
            // layar browser ke paling atas agar user melihat alert error
            $this->dispatchBrowserEvent('livewire-scroll', ['top' => 0]);
            return session()->flash('failed', 'Pastikan input No. Telp tidak mangandung nilai yang sama.');
        }

        // alasan menggunakan create alih2 mengunakan ::insert adalah karena tidak looping untuk menambahkan created_at dan updated_at
        $affected = 0;
        foreach ($this->employees as $employee) {
            if (trim($employee['password']) === '') $employee['password'] = '123';
            $employee['password'] = Hash::make($employee['password']);
            User::create($employee);
            $affected++;
        }

        redirect()->route('employees.index')->with('success', "Ada ($affected) data karyawaan yang berhasil ditambahkan.");
    }

    public function render()
    {
        return view('livewire.employee-create-form');
    }
}
