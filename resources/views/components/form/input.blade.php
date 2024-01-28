<div class="form-group {{ $class }}">
    <label for="{{ str_replace(' ', '_', strtolower($label)) }}">{{ ucwords($label) }}</label>
    <input name="{{ $name }}" value="{{ $value }}" type="{{ $type }}" class="form-control <?= ($errors->get($name))?'is-invalid':'' ?>" id="{{ str_replace(' ', '_', strtolower($label)) }}" placeholder="{{ $placeholder }}" {{ $attr }}/>
        @error($name)
        <div class="error invalid-feedback">{{ $message }}</div>
        @enderror
</div>