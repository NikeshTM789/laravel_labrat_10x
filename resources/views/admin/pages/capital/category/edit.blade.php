@extends('admin.layouts.index')

@section('content')
	@component('admin.components.card')
		<form action="{{ route('admin.category.update', $category->id) }}" method="POST" id="category_form">
			@method('PATCH')
			@include('admin.pages.capital.category.form')
		</form>
	@endcomponent
@stop

@push('post-js')
<script>
document.getElementById('submit').addEventListener('click', function(e) {
	console.log(e);
	e.preventDefault();
	const caller = {
		ok: function(response){
			toastr.success(response.message);
		},
		err: function(response){
			toastr.error(response.message);
		}
	};
	ajax(e,caller);
});
</script>
@endpush