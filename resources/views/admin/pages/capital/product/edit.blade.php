@extends('admin.layouts.index')

@section('content')
	@component('admin.components.card')
		@slot('content')
			<form action="{{ route('admin.product.update', $product->id) }}" method="POST" id="category_form">
				@method('PATCH')
				@include('admin.pages.capital.product.form')
			</form>
		@endslot
	@endcomponent
@stop