@extends('admin.layouts.index')

@section('page','Product Trashed')

@section('content')
    @component('admin.components.card')
        <x-admin.datatable :cols="[
        'name' => 'width:40%;',
        'quantity' => 'width:20%;',
        'price' => 'width:20%;',
        'featured' => 'width:10%;',
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
            name: 'name'// DB column name
        }, {
            data: 'quantity',
            name: 'quantity'
        }, {
            data: 'price',
            name: 'price'
        }, {
            data: 'featured',
            name: 'featured'
        }, {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        }
    ];
    const DT = new dt({columns});
});
</script>
@endpush