<div>
    <form wire:submit.prevent="saveHolidays" method="post" novalidate>
        @include('partials.alerts')
        @foreach ($holidays as $i => $holiday)
        <div class="mb-3">
            <div class="w-100">
                <div class="mb-3">
                    <x-form-label id="title{{ $i }}" label='Nama/Judul Hari Libur ({{ $i + 1 }})' />
                    <x-form-input id="title{{ $i }}" name="title{{ $i }}" wire:model.defer="holidays.{{ $i }}.title" />
                    <x-form-error key="holidays.{{ $i }}.title" />
                </div>
                <div class="mb-3">
                    <x-form-label id="description{{ $i }}" label='Keterangan ({{ $i + 1 }})' />
                    <textarea id="description{{ $i }}" name="description{{ $i }}" class="form-control"
                        wire:model.defer="holidays.{{ $i }}.description"></textarea>
                    <x-form-error key="holidays.{{ $i }}.description" />
                </div>
                <div class="mb-3">
                    <x-form-label id="holiday_date{{ $i }}" label='Tanggal Hari Libur ({{ $i + 1 }})' />
                    <x-form-input type="date" id="holiday_date{{ $i }}" name="holiday_date{{ $i }}" class="form-control"
                        wire:model.defer="holidays.{{ $i }}.holiday_date" />
                    <small class="text-muted d-block mt-2">Perhatikan format tanggal d (Hari), m (Bulan) dan y
                        (Tahun)</small>
                    <x-form-error key="holidays.{{ $i }}.holiday_date" />
                </div>
            </div>
        </div>
        <hr>
        @endforeach

        <div class="d-flex justify-content-between align-items-center mb-5">
            <button class="btn btn-primary">
                Simpan
            </button>
        </div>
    </form>
</div>