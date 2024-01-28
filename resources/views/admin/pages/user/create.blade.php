@extends('admin.layouts.index')

@section('content')
	@component('admin.components.card')
		@slot('content')
			<form action="{{ route('admin.user.index') }}" method="POST">
				@include('admin.pages.user.form')
			</form>
		@endslot
	@endcomponent
@stop