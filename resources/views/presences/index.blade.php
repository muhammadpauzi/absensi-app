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
                @include('partials.attendance-badges')
            </a>
            @endforeach
        </ul>
    </div>
</div>
@endsection