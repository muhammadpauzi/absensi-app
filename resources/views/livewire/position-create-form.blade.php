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

        @foreach ($positions as $i => $position)
        <div class="mb-3 position-relative">
            <x-form-label id="name{{ $i }}" label='Nama Jabatan {{ $i + 1 }}' />
            <div class="d-flex align-items-center">
                <x-form-input id="name{{ $i }}" name="name{{ $i }}" wire:model.defer="positions.{{ $i }}.name" />
                @if ($i > 0)
                <button class="btn btn-danger ms-2" wire:click="removePositionInput({{ $i }})"
                    wire:target="removePositionInput({{ $i }})" type="button"
                    wire:loading.attr="disabled">Hapus</button>
                @endif
            </div>
        </div>
        @endforeach

        <div class="d-flex justify-content-between align-items-center">
            <button class="btn btn-primary">
                Simpan
            </button>
            <button class="btn btn-light" type="button" wire:click="addPositionInput" wire:loading.attr="disabled">
                Tambah Input
            </button>
        </div>
    </form>
</div>