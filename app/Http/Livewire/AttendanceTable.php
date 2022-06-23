<?php

namespace App\Http\Livewire;

use App\Models\Attendance;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Detail, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class AttendanceTable extends PowerGridComponent
{
    use ActionButton;

    //Table sort field
    public string $sortField = 'attendances.created_at';
    public string $sortDirection = 'desc';

    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(),
            [
                'bulkCheckedDelete',
                'bulkCheckedEdit'
            ]
        );
    }

    public function header(): array
    {
        return [
            Button::add('bulk-checked')
                ->caption(__('Hapus'))
                ->class('btn btn-danger border-0')
                ->emit('bulkCheckedDelete', []),
        ];
    }

    public function bulkCheckedDelete()
    {
        if (auth()->check()) {
            $ids = $this->checkedValues();

            if (!$ids)
                return $this->dispatchBrowserEvent('showToast', ['success' => false, 'message' => 'Pilih data yang ingin dihapus terlebih dahulu.']);

            try {
                Attendance::whereIn('id', $ids)->delete();
                $this->dispatchBrowserEvent('showToast', ['success' => true, 'message' => 'Data absensi berhasi dihapus.']);
            } catch (\Illuminate\Database\QueryException $ex) {
                $this->dispatchBrowserEvent('showToast', ['success' => false, 'message' => 'Data gagal dihapus, kemungkinan ada data lain yang menggunakan data tersebut.']);
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput()->showToggleColumns(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
     * PowerGrid datasource.
     *
     * @return Builder<\App\Models\Attendance>
     */
    public function datasource(): Builder
    {
        return Attendance::query();
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('title')
            ->addColumn('description')
            ->addColumn('start_time', fn (Attendance $model) => substr($model->start_time, 0, -3) . "-" . substr($model->batas_start_time, 0, -3))
            ->addColumn('end_time', fn (Attendance $model) => substr($model->end_time, 0, -3) . "-" . substr($model->batas_end_time, 0, -3))
            // ->addColumn('batas_start_time')
            // ->addColumn('end_time')
            // ->addColumn('batas_end_time')
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', fn (Attendance $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('Nama', 'title')
                ->searchable()
                ->makeInputText('title')
                ->sortable(),

            Column::make('Keterangan', 'description'),

            Column::make('Waktu Absen Masuk', 'start_time', 'start_time')
                ->searchable()
                ->makeInputText('start_time')
                ->sortable(),

            Column::make('Waktu Absen Keluar', 'end_time', 'end_time')
                ->searchable()
                ->makeInputText('end_time')
                ->sortable(),

            // Column::make('Batas Akhir Absen Masuk', 'batas_start_time', 'batas_start_time')
            //     ->searchable()
            //     ->makeInputText('batas_start_time')
            //     ->sortable(),

            // Column::make('Waktu Mulai Absen Pulang', 'end_time', 'end_time')
            //     ->searchable()
            //     ->makeInputText('end_time')
            //     ->sortable(),

            // Column::make('Batas Akhir Absen Pulang', 'batas_end_time', 'batas_end_time')
            //     ->searchable()
            //     ->makeInputText('batas_end_time')
            //     ->sortable(),

            Column::make('Created at', 'created_at')
                ->hidden(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->makeInputDatePicker()
                ->searchable()
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid Attendance Action Buttons.
     *
     * @return array<int, Button>
     */

    public function actions(): array
    {
        return [
            Button::make('edit', 'Edit')
                ->class('badge text-bg-success')
                ->target('')
                ->route('attendances.edit', ['id' => 'id']),

            //    Button::make('destroy', 'Delete')
            //        ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
            //        ->route('attendance.destroy', ['attendance' => 'id'])
            //        ->method('delete')
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid Attendance Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($attendance) => $attendance->id === 1)
                ->hide(),
        ];
    }
    */
}
