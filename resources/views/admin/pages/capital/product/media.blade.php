@extends('admin.layouts.index')

@section('content')
	@component('admin.components.card')
		<x-form.dropzone :action="route('admin.product.media', ['type' => 'featured', 'product' => $product->uuid])" :label="'featured'" />
		<x-form.dropzone :action="route('admin.product.media', ['type' => 'gallery', 'product' => $product->uuid])" :label="'gallery'" />
	@endcomponent
@stop



@push('post-js')
<script>
const csrf_token = '{{ csrf_token() }}';

let preloaded_gallery_files = @json($gallery);
let preloaded_featured_files = @json($featured);

new dz({form_id:'featured', csrf_token, max_files: 1, preloaded_files: preloaded_featured_files});
new dz({form_id:'gallery', csrf_token, upload_multiple: true, max_files: 30, preloaded_files: preloaded_gallery_files});
</script>
@endpush

