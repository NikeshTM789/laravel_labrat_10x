@php
$form_id = strtolower($label);
@endphp
<div class="form-group">
    <label>{{ ucwords($label) }}</label>
    <form action="{{ $action }}" class="dropzone" id="{{ $form_id }}"></form>
</div>

@push('pre-css')
<link rel="stylesheet" href="{{ asset('packages/dropzone/dropzone.min.css') }}"/>
@endpush

@pushOnce('pre-js')
<script src="{{ asset('packages/dropzone/dropzone.min.js') }}"></script>
@endPushOnce
