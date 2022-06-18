<div>
    <form wire:submit.prevent="savePositions" method="post">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="m-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @foreach ($positions as $position)
        <div class="mb-3 position-relative">
            <x-form-label id="name{{ $position['id'] }}"
                label="Nama Jabatan {{ $loop->iteration }} (ID: {{ $position['id'] }})" />
            <div class="d-flex align-items-center">
                <x-form-input id="name{{ $position['id'] }}" name="name{{ $position['id'] }}"
                    wire:model.defer="positions.{{ $loop->index }}.name" value="{{ $position['name'] }}" />
            </div>
        </div>
        @endforeach

        <div class="d-flex justify-content-between align-items-center">
            <button class="btn btn-primary">
                Simpan
                <div wire:loading>
                    ...
                </div>
            </button>
        </div>
    </form>
</div>