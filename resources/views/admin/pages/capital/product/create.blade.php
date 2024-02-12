@extends('admin.layouts.index')

@section('content')
	@component('admin.components.card')
		@slot('content')
			<form action="{{ route('admin.product.store') }}" method="POST" id="category_form">
				@include('admin.pages.capital.product.form')
			</form>
		@endslot
	@endcomponent
@stop