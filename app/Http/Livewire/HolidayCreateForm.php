<?php

namespace App\Http\Livewire;

use App\Models\Holiday;
use Livewire\Component;

class HolidayCreateForm extends Component
{
    public $holidays;
    private $initialValue = ['title' => '', 'description' => '', 'holiday_date' => ''];

    public function mount()
    {
        $this->holidays = [$this->initialValue];
    }

    public function addHolidayInput(): void
    {
        $this->holidays[] = $this->initialValue;
    }

    public function removeHolidayInput(int $index): void
    {
        unset($this->holidays[$index]);
        $this->holidays = array_values($this->holidays);
    }

    public function saveHolidays()
    {
        $this->validate([
            'holidays.*.title' => 'required',
            'holidays.*.description' => 'required',
            'holidays.*.holiday_date' => 'required|date|unique:holidays',
        ]);

        // alasan menggunakan create alih2 mengunakan ::insert adalah karena tidak looping untuk menambahkan created_at dan updated_at
        foreach ($this->holidays as $holiday) {
            Holiday::create($holiday);
        }

        redirect()->route('holidays.index')->with('success', 'Data hari libur berhasil ditambahkan.');
    }

    public function render()
    {
        return view('livewire.holiday-create-form');
    }
}
