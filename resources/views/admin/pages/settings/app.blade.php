@extends('admin.layouts.index')

@section('page','Setting')

@section('content')

	@component('admin.components.card')
	<form method="POST" action="{{ route('admin.app') }}" enctype="multipart/form-data">
		@csrf
		<div class="row">
			<x-form.input :label="'app name'" :name="'app_name'" :value="$settings" :class="'col'"/>
		</div>
		<div class="row">
			<x-form.input :label="'logo'" :type="'file'" :name="'logo'" :value="$settings" :class="'col'"/>
		</div>
		<x-form.button :class="['float-right','btn-outline-success']"/>
	</form>
	@endcomponent

@stop