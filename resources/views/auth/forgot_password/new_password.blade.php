@extends('auth.layout')

@section('content')

@include('components/errors')

<form action="{{ route('admin.new-password') }}" method="post">
  @csrf
  <input type="hidden" name="token" value="{{ $token }}">
  <div class="input-group mb-3">
    <input type="password" name="password" class="form-control" placeholder="Password">
    <div class="input-group-append">
      <div class="input-group-text">
        <span class="fas fa-lock"></span>
      </div>
    </div>
  </div>
  <div class="input-group mb-3">
    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
    <div class="input-group-append">
      <div class="input-group-text">
        <span class="fas fa-lock"></span>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <button type="submit" class="btn btn-primary btn-block">Change password</button>
    </div>
    <!-- /.col -->
  </div>
</form>
@stop