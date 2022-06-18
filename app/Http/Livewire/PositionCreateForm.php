<?php

namespace App\Http\Livewire;

use App\Models\Position;
use Livewire\Component;
use phpDocumentor\Reflection\Types\Boolean;

class PositionCreateForm extends Component
{
    public $positions;

    public function mount()
    {
        $this->positions = [
            ['name' => '']
        ];
    }

    public function addPositionInput(): void
    {
        $this->positions[] = ['name' => ''];
    }

    public function removePositionInput(int $index): void
    {
        unset($this->positions[$index]);
        $this->positions = array_values($this->positions);
    }

    public function savePositions()
    {
        // setidaknya input pertama yang hanya required,
        // karena nanti akan difilter apakah input kedua dan input selanjutnya apakah berisi
        $this->validate([
            'positions.0.name' => 'required'
        ], ['positions.0.name.required' => 'Setidaknya input jabatan pertama wajib diisi.']);

        // ambil input/request dari position yang berisi
        $positions = array_filter($this->positions, function ($a) {
            return trim($a['name']) !== "";
        });

        // alasan menggunakan create alih2 mengunakan ::insert adalah karena tidak looping untuk menambahkan created_at dan updated_at
        foreach ($positions as $position) {
            Position::create($position);
        }

        redirect()->route('positions.index')->with('success', 'Data jabatan berhasil ditambahkan.');
    }

    public function render()
    {
        return view('livewire.position-create-form');
    }
}
