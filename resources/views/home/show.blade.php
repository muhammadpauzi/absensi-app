@extends('layouts.home')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="row">
                <div class="col-md-7">
                    <div class="mb-2">
                        @include('partials.attendance-badges')
                    </div>
                    <h1 class="fs-2">{{ $attendance->title }}</h1>
                    <p class="text-muted">{{ $attendance->description }}</p>
                    <div>
                        <span class="badge text-bg-light border shadow-sm">Masuk : {{
                            substr($attendance->data->start_time, 0 , -3) }} - {{
                            substr($attendance->data->batas_start_time,0,-3 )}}</span>
                        <span class="badge text-bg-light border shadow-sm">Pulang : {{
                            substr($attendance->data->end_time, 0 , -3) }} - {{
                            substr($attendance->data->batas_end_time,0,-3 )}}</span>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            @if ($attendance->data->is_start or $attendance->data->is_end)
                            @if ($attendance->data->is_using_qrcode)
                            <img src="{{ $qrcode }}" alt="">
                            @endif
                            @else
                            <span class="text-danger">Belum bisa melakukan absensi.</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection