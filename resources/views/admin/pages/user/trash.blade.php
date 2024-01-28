@extends('admin.layouts.index')

@section('content')
	@component('admin.components.card')
		@slot('content')
			<x-admin.datatable :cols="[
			'name' => 'width:40%;',
			'email' => 'width:30%;',
			'verified' => 'width:20%;',
			'action' => 'width:10%;',
			]" />
		@endslot
	@endcomponent
@stop

@push('post-js')
<script>
$(document).ready(function() {
  const columns = [
		{
            data: 'name',//recerved
            name: 'users.name'// DB column name
        }, {
            data: 'email',
            name: 'email'
        }, {
            data: 'deleted_at',
            sortable: false,
            searchable: false,
            render: function(data,type, row){
              return (data) ? ((data.removable_id) ? 'YES + PD' : 'YES') : 'NO';
            }
        }, {
            data: null,
            sortable: false,
            searchable: false,
            render: function(data, type, row) {
                let options = '<div class="btn-group">'+
                        '<button type="button" class="btn btn-light">Action</button>'+
                        '<button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">'+
                        '<span class="sr-only">Toggle Dropdown</span>'+
                        '</button>'+
                        '<div class="dropdown-menu" role="menu">'+
                        '<form action="{{ route('admin.user.trash') }}'+'/'+row.id+'" method="POST">'+
                        '<input type="hidden" name="_token" value="{{ csrf_token() }}"/>'+
                        '<button class="dropdown-item dt-restore" type="button">Restore</button>'+
                        '</form>'+
                        '</div>'+
                        '</div>';
                        return options;
            }
        }];
    new dt({columns});
});
</script>
@endpush