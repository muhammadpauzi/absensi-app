@extends('layouts.app')

@section('buttons')
<div class="btn-toolbar mb-2 mb-md-0">
    <div>
        <a href="{{ route('positions.index') }}" class="btn btn-sm btn-light">
            <span data-feather="arrow-left-circle" class="align-text-bottom"></span>
            Kembali
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-7">
        <livewire:position-edit-form :positions="$positions" />
    </div>
</div>
@endsection