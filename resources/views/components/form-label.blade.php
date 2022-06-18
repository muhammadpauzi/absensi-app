@props(['required' => true, 'label', 'id'])

<label for="{{ $id }}" class="form-label fw-bold">{{ $label }} @if($required) <sup class="text-danger">*</sup>
    @endif</label>