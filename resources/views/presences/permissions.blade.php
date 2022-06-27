@extends('layouts.app')

@section('buttons')
<div class="btn-toolbar mb-2 mb-md-0">
    <div>
        <a href="{{ route('presences.show', $attendance->id) }}" class="btn btn-sm btn-light">
            <span data-feather="arrow-left-circle" class="align-text-bottom"></span>
            Kembali
        </a>
    </div>
</div>
@endsection

@section('content')
@include('partials.alerts')

<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3 mb-md-0">
                <h5 class="card-title">{{ $attendance->title }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ $attendance->description }}</h6>
                <div class="d-flex align-items-center gap-2">
                    <span href="" class="badge text-bg-warning">Izin</span>
                </div>
            </div>
            <div class="col-md-6">
                <form action="" method="get">
                    <div class="mb-3">
                        <label for="filterDate" class="form-label fw-bold">Tampilkan Berdasarkan Tanggal</label>
                        <div class="input-group mb-3">
                            <input type="date" class="form-control" id="filterDate" name="display-by-date"
                                value="{{ request('display-by-date') }}">
                            <button class="btn btn-primary" type="submit" id="button-addon1">Tampilkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div>
    <div class="p-3 rounded bg-light border my-3 d-flex align-items-center justify-content-between">
        <div>Hari : <span class="fw-bold">
                {{ \Carbon\Carbon::parse($date)->dayName }}
                {{ \Carbon\Carbon::parse($date)->isCurrentDay() ? '(Hari ini)' : '' }}
            </span>
        </div>
        <div>Tanggal : <span class="fw-bold">{{ $date }}</span></div>
        <div>Jumlah : <span class="fw-bold">{{ $permissions->count() }}</span></div>
    </div>
    @if (count($permissions) === 0)
    <small class="text-danger fw-bold">Tidak ada data yang bisa ditampilkan, <a href="">Tampilkan data berdasarkan hari
            ini.</a></small>
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Karyawan</th>
                    <th scope="col">Kontak</th>
                    <th scope="col">Posisi</th>
                    <th scope="col">Handle</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $permission->user->name }}</td>
                    <td>
                        <a href="mailto:{{ $permission->user->email }}">{{ $permission->user->email }}</a>
                        <span class="fw-bold"> / </span>
                        <a href="tel:{{ $permission->user->phone }}">{{ $permission->user->phone }}</a>
                    </td>
                    {{-- <td>{{ $permission['position']['name'] }}</td> --}}
                    {{-- <td>
                        <form action="{{ route('presences.present', $attendance->id) }}" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $permission['id'] }}">
                            <input type="hidden" name="presence_date" value="{{ $permission['not_presence_date'] }}">
                            <button class="badge text-bg-primary border-0" type="submit">Hadir</button>
                        </form>
                    </td> --}}
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

@endsection