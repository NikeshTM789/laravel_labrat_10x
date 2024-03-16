@extends('admin.layouts.index')

@section('page','User List')

@section('content')
	@component('admin.components.card', [
        'buttons' => [
            ['name' => 'ADD', 'color' => 'success', 'url' => route('admin.user.create')],
            ['name' => 'Trash', 'color' => 'danger', 'url' => route('admin.user.trash')]
        ]
        ])
		<x-admin.datatable :cols="[
		'name' => 'width:40%;',
		'email' => 'width:30%;',
		'verified' => 'width:20%;',
		'action' => 'width:10%;',
		]" />
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
                        '<button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">'+
                        '<span class="sr-only">Toggle Dropdown</span>'+
                        '</button>'+
                        '<div class="dropdown-menu" role="menu">'+
                        '<a class="dropdown-item" href="'+(window.location.href.split('#')[0]+'/'+row.id+'/edit')+'">Edit</a>'+
                        '<form action="{{ route('admin.user.index') }}'+'/'+row.id+'" method="POST">'+
                        '<input type="hidden" name="_token" value="{{ csrf_token() }}"/>'+
                        '<input type="hidden" name="_method" value="DELETE"/>'+
                        '<button class="dropdown-item dt-delete" type="button">Delete</button>'+
                        '</form>'+
                        '<a class="dropdown-item" href="#">Show</a>'+
                        '</div>'+
                        '</div>';
                        return options;
            }
        }];
    new dt({columns});
});
</script>
@endpush