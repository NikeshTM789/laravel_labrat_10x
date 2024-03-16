@extends('admin.layouts.index')

@section('page','Dashboard')

@section('content')

@component('admin.components.card')
<button type="button" id="get-response" class="btn btn-block bg-gradient-success">GET RESPONSE</button>
@endcomponent

@stop

@push('post-js')
<script>
const token = "{{ csrf_token() }}";
const get_response_url = "{{ route('get_response') }}";
document.getElementById('get-response').addEventListener('click', (el) => {
	sendAjaxRequest({'url' : get_response_url, 'body':{}, method:'GET', token});
});
</script>
@endpush