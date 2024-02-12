<form action="{{ $action }}" class="dropzone" id="my-dropzone"></form>

@pushOnce('post-css')
<link rel="stylesheet" href="{{ asset('packages\dropzone\min\dropzone.min.css') }}"/>
@endpushonce

@pushOnce('post-js')
<script src="{{ asset('packages\dropzone\min\dropzone.min.js') }}"></script>
@endpushonce