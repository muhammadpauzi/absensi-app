@if ($attendance->data->is_start)
<span class="badge bg-primary rounded-pill">Masuk</span>
@elseif($attendance->data->is_end)
<span class="badge text-bg-warning rounded-pill">Pulang</span>
@else
<span class="badge text-bg-danger rounded-pill">Tutup</span>
@endif