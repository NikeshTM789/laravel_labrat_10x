@extends('admin.layouts.index')

@section('content')
	@component('admin.components.card')
		@slot('content')
			<form action="{{ route('admin.user.update', $user->id) }}" method="POST">
				@method('PATCH')
				@include('admin.pages.user.form')
			</form>
		@endslot
	@endcomponent
@stop