<?php

namespace App\Http\Livewire;

use App\Models\Presence;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class PresenceTable extends PowerGridComponent
{
    use ActionButton;

    public $attendanceId;
    //Table sort field
    public string $sortField = 'presences.created_at';
    public string $sortDirection = 'desc';

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
     * @return Builder<\App\Models\Presence>
     */
    public function datasource(): Builder
    {
        return Presence::query()
            ->where('attendance_id', $this->attendanceId)
            ->join('users', 'presences.user_id', '=', 'users.id')
            ->select('presences.*', 'users.name as user_name');
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
            ->addColumn('user_name')
            ->addColumn("presence_date")
            ->addColumn("presence_enter_time")
            ->addColumn("presence_out_time", fn (Presence $model) => $model->presence_out_time ?? '<span class="badge text-bg-danger">Belum Absensi Pulang</span>')
            ->addColumn("is_permission", fn (Presence $model) => $model->is_permission ?
                '<span class="badge text-bg-warning">Izin</span>' : '<span class="badge text-bg-success">Hadir</span>')
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', fn (Presence $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
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

            Column::make('Nama', 'user_name')
                ->searchable()
                ->makeInputText('users.name')
                ->sortable(),

            Column::make('Tanggal Hadir', 'presence_date')
                ->makeInputDatePicker()
                ->searchable()
                ->sortable(),

            Column::make('Jam Absen Masuk', 'presence_enter_time')
                ->searchable()
                // ->makeInputRange('presence_enter_time') // terlalu banyak menggunakan bandwidth (ukuran data yang dikirim terlalu besar)
                ->makeInputText('presence_enter_time')
                ->sortable(),

            Column::make('Jam Absen Pulang', 'presence_out_time')
                ->searchable()
                // ->makeInputRange('presence_out_time') // ini juga
                ->makeInputText('presence_out_time')
                ->sortable(),

            Column::make('Status', 'is_permission')
                ->sortable(),

            Column::make('Created at', 'created_at')
                ->hidden(),

            Column::make('Created at', 'created_at_formatted')
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
     * PowerGrid Presence Action Buttons.
     *
     * @return array<int, Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::make('edit', 'Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('presence.edit', ['presence' => 'id']),

           Button::make('destroy', 'Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('presence.destroy', ['presence' => 'id'])
               ->method('delete')
        ];
    }
    */

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid Presence Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($presence) => $presence->id === 1)
                ->hide(),
        ];
    }
    */
}
