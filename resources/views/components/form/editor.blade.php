@php
$id = str_replace(' ', '_', strtolower($label));
@endphp
<div class="form-group">
    <label for="{{ $id }}">{{ ucwords($label) }}</label>
    <textarea id="{{ $id }}" name="{{ $name }}">{{ $value ?? old($name) }}</textarea>
    @error($name)
    <div class="text-danger text-sm">{{ $message }}</div>
    @enderror
</div>

@pushOnce('post-js')
<script src="{{ asset('packages/tinymce/tinymce.min.js') }}"></script>
<script>
    tinymce.init({
      selector: '#{{ $id }}'
    });
</script>
@endPushOnce
