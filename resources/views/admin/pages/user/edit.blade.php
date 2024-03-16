@extends('admin.layouts.index')

@section('content')
	@component('admin.components.card')
		<form action="{{ route('admin.user.update', $user->id) }}" method="POST">
			@method('PATCH')
			@include('admin.pages.user.form')
		</form>
	@endcomponent
@stop