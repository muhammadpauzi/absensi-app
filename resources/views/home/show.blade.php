@extends('layouts.home')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6 mb-3 mb-md-0">
            <div class="mb-2">
                @include('partials.attendance-badges')
            </div>
            @include('partials.alerts')

            <h1 class="fs-2">{{ $attendance->title }}</h1>
            <p class="text-muted">{{ $attendance->description }}</p>

            <div class="mb-4">
                <span class="badge text-bg-light border shadow-sm">Masuk : {{
                    substr($attendance->data->start_time, 0 , -3) }} - {{
                    substr($attendance->data->batas_start_time,0,-3 )}}</span>
                <span class="badge text-bg-light border shadow-sm">Pulang : {{
                    substr($attendance->data->end_time, 0 , -3) }} - {{
                    substr($attendance->data->batas_end_time,0,-3 )}}</span>
            </div>

            @if (!$attendance->data->is_using_qrcode)
            <livewire:presence-form :attendance="$attendance" :data="$data" :holiday="$holiday">
                @else
                @include('home.partials.qrcode-presence')
                @endif
        </div>
        <div class="col-md-6">
            <h5 class="mb-3">Histori 30 Hari Terakhir</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Jam Masuk</th>
                            <th scope="col">Jam Pulang</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($priodDate as $date)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            {{-- not presence / tidak hadir --}}
                            @php
                            $histo = $history->where('presence_date', $date)->first();
                            @endphp
                            @if (!$histo)
                            <td>{{ $date }}</td>
                            <td colspan="3">
                                @if($date == now()->toDateString())
                                <div class="badge text-bg-info">Belum Hadir</div>
                                @else
                                <div class="badge text-bg-danger">Tidak Hadir</div>
                                @endif
                            </td>
                            @else
                            <td>{{ $histo->presence_date }}</td>
                            <td>{{ $histo->presence_enter_time }}</td>
                            <td>@if($histo->presence_out_time)
                                {{ $histo->presence_out_time }}
                                @else
                                <span class="badge text-bg-danger">Belum Absensi Pulang</span>
                                @endif
                            </td>
                            <td>
                                @if ($histo->is_permission)
                                <div class="badge text-bg-warning">Izin</div>
                                @else
                                <div class="badge text-bg-success">Hadir</div>
                                @endif
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection