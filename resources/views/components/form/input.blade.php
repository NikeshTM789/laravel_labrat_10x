@php
$id = str_replace(' ', '_', strtolower($label));
@endphp
<div class="form-group {{ $class ?? 'col' }}">
    <label for="{{ $id }}">{{ ucwords($label) }}</label>
    <input name="{{ $name }}" value="{{ $value ?? old($name) }}" type="{{ $type }}" class="form-control <?= ($errors->get($name))?'is-invalid':'' ?>" id="{{ $id }}" placeholder="{{ $placeholder }}" {{ $attr }}/>
        @error($name)
        <div class="error invalid-feedback">{{ $message }}</div>
        @enderror
</div>