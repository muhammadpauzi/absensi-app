@props(['id', 'type' => 'text', 'name', 'placeholder' => ''])

<input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" placeholder="{{ $placeholder }}" {{
    $attributes->merge(['class' => 'form-control']) }} {{ $attributes->get('wire') }} >