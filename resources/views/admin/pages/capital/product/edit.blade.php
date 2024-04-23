@extends('admin.layouts.index')

@section('page','Product Edit')

@section('content')
	@component('admin.components.card')
		<form action="{{ route('admin.product.update', $product->uuid) }}" method="POST" id="category_form">
			@method('PATCH')
			@include('admin.pages.capital.product.form')
		</form>
	@endcomponent
@stop