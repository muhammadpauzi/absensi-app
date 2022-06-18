@extends('layouts.app')

@push('style')
@powerGridStyles
@endpush

@section('buttons')
<div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
        <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
    </div>
    <div>
        <a href="{{ route('positions.create') }}" class="btn btn-sm btn-primary">Tambah Data Jabatan</a>
    </div>
</div>
@endsection

@section('content')
<div class="mb-3">
    @include('partials.alerts')
</div>

<livewire:position-table />
@endsection

@push('script')
@powerGridScripts
@endpush