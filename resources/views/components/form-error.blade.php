@props(['key'])

@error($key)
<small class="text-danger">
    {{ $message }}
</small>
@enderror