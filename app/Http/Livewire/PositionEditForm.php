<?php

namespace App\Http\Livewire;

use App\Models\Position;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class PositionEditForm extends Component
{
    public $positions = [];

    public function mount(Collection $positions)
    {
        $this->positions = []; // hapus positions collection
        foreach ($positions as $position) {
            $this->positions[] = ['id' => $position->id, 'name' => $position->name];
        }
    }

    public function savePositions()
    {
        // tidak mengimplementasikan validasi, karena jika input kosong berarti data tersebut tidak akan diubah
        // ambil input/request dari position yang berisi
        $positions = array_filter($this->positions, function ($a) {
            return trim($a['name']) !== "";
        });

        $affected = 0;
        foreach ($positions as $position) {
            $affected += Position::find($position['id'])->update(['name' => $position['name']]);
        }

        $message = $affected === 0 ?
            "Tidak ada data jabatan yang diubah." :
            "Ada $affected data jabatan yang berhasil diedit.";

        return redirect()->route('positions.index')->with('success', $message);
    }

    public function render()
    {
        return view('livewire.position-edit-form');
    }
}
