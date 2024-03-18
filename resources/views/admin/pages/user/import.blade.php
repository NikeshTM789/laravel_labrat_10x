@extends('admin.layouts.index')

@section('page','User Import')

@section('content')
	@component('admin.components.card')
		@session ('import_errors')
			<div class="alert alert-danger">
					@foreach ($value as $key => $error)
						<li>{{ 'Row '.$key.' : '.implode(' | ',$error) }}</li>
					@endforeach
			</div>
		@endsession
		<form action="{{ route('admin.user.import') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="text-center">
				<input type="file" name="excel" value="" placeholder="" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
				@error('excel')
				<div class="text-danger">{{ $message }}</div>
				@enderror
			</div>
			<div>
				<button type="submit" class="btn btn-outline-success">Import</button>
			</div>
		</form>
	@endcomponent
@stop