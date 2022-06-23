@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card mb-3" style="max-width: min-content">
            <div class="card-body">
                <img src="{{ $qrcode }}" alt="" id="qrcode">
            </div>
        </div>
        <div class="mb-3">
            <a href="{{ route('presences.qrcode.download-pdf', ['code' => $code]) }}" class="btn btn-primary">Download
                PDF</a>
        </div>
        <div><small class="text-muted">Untuk mendownload QrCode SVG (agar bisa diedit) silahkan klik kiri pada
                gambar qrcode, lalu download.</small></div>
    </div>
</div>
@endsection