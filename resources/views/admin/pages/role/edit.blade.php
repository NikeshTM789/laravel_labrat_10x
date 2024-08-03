@extends('admin.layouts.index')

@section('content')
	@component('admin.components.card')
		<form action="{{ route('admin.role.update', $role->id) }}" method="POST">
			@method('PATCH')
			@include('admin.pages.role.form')
		</form>
	@endcomponent
@stop