@extends('admin.layouts.index')

@section('content')
	@component('admin.components.card')
		<form action="{{ route('admin.role.store') }}" method="POST" id="category_form">
			@include('admin.pages.role.form')
		</form>
	@endcomponent
@stop