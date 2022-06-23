@extends('layouts.app')

@section('content')
@include('partials.alerts')

<div class="row">
    <div class="col-md-7">
        <ul class="list-group">
            @foreach ($attendances as $attendance)
            <a href="{{ route('presences.show', $attendance->id) }}"
                class="list-group-item d-flex justify-content-between align-items-start py-3">
                <div class="ms-2 me-auto">
                    <div class="fw-bold">{{ $attendance->title }}</div>
                    <p class="mb-0">{{ $attendance->description }}</p>
                </div>
                @if ($attendance->data->is_start)
                <span class="badge bg-primary rounded-pill">Masuk</span>
                @elseif($attendance->data->is_end)
                <span class="badge text-bg-warning rounded-pill">Pulang</span>
                @else
                <span class="badge text-bg-danger rounded-pill">Tutup</span>
                @endif
            </a>
            @endforeach
        </ul>
    </div>
</div>
@endsection