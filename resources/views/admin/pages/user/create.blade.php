@extends('admin.layouts.index')

@section('content')
	@component('admin.components.card')
		<form action="{{ route('admin.user.index') }}" method="POST">
			@include('admin.pages.user.form')
		</form>
	@endcomponent
@stop