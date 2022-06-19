<div>
    <form wire:submit.prevent="saveEmployees" method="post" novalidate>
        @include('partials.alerts')
        @foreach ($employees as $employee)

        <div class="mb-3">
            <div class="w-100">
                <div class="mb-3">
                    <x-form-label id="name{{ $employee['id'] }}"
                        label="Nama Karyawaan {{ $loop->iteration }} (ID: {{ $employee['id'] }})" />
                    <x-form-input id="name{{ $employee['id'] }}" name="name{{ $employee['id'] }}"
                        wire:model.defer="employees.{{ $loop->index }}.name" />
                    <x-form-error key="employees.{{ $loop->index }}.name" />
                </div>
                <div class="mb-3">
                    <x-form-label id="email{{ $employee['id'] }}" label='Email Karyawaan {{ $loop->iteration }}' />
                    <x-form-input id="email{{ $employee['id'] }}" name="email{{ $employee['id'] }}" type="email"
                        wire:model.defer="employees.{{ $loop->index }}.email" placeholder="Email aktif" />
                    <x-form-error key="employees.{{ $loop->index }}.email" />
                </div>
                <div class="mb-3">
                    <x-form-label id="phone{{ $employee['id'] }}" label='No. Telp {{ $loop->iteration }}' />
                    <x-form-input id="phone{{ $employee['id'] }}" name="phone{{ $employee['id'] }}"
                        wire:model.defer="employees.{{ $loop->index }}.phone" placeholder="Format: 08**" />
                    <x-form-error key="employees.{{ $loop->index }}.phone" />
                </div>
                <div class="mb-3">
                    <x-form-label id="password{{ $employee['id'] }}" label='Password hanya bisa diubah oleh karyawaan'
                        required="false" />
                    <x-form-input id="password{{ $employee['id'] }}" name="password{{ $employee['id'] }}" disabled
                        required="false" />
                </div>
                <div class="mb-3">
                    <x-form-label id="position_id{{ $employee['id'] }}"
                        label='Jabatan / Posisi Karyawaan {{ $loop->iteration }}' />
                    <select class="form-select" aria-label="Default select example" name="position_id"
                        wire:model.defer="employees.{{ $loop->index }}.position_id">
                        <option selected disabled>-- Pilih Role --</option>
                        @foreach ($positions as $position)
                        <option value="{{ $position->id }}">{{ ucfirst($position->name) }}</option>
                        @endforeach
                    </select>
                    <x-form-error key="employees.{{ $loop->index }}.role_id" />
                </div>
                <div class="mb-3">
                    <x-form-label id="role_id{{ $employee['id'] }}" label='Role {{ $loop->iteration }}' />
                    <select class="form-select" aria-label="Default select example" name="role_id"
                        wire:model.defer="employees.{{ $loop->index }}.role_id">
                        <option selected disabled>-- Pilih Role --</option>
                        @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                    <x-form-error key="employees.{{ $loop->index }}.role_id" />
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