@extends('admin.layouts.index')

@section('content')
	@component('admin.components.card')
		<form action="{{ route('admin.category.store') }}" method="POST" id="category_form">
			@include('admin.pages.capital.category.form')
		</form>
	@endcomponent
@stop

@push('post-js')
<script>
document.getElementById('submit').addEventListener('click', function(e) {
	console.log(e);
	const caller = {
		ok: function(response){
			toastr.success(response.message);
		},
		err: function(response){
			console.log('ER',response.message);
			toastr.error(response.message);
		},
		form_reset:true
	};
	ajax(e, caller);
});
</script>
@endpush