@extends('admin.layouts.index')

@section('content')
    @component('admin.components.card')
        @slot('content')
            <x-admin.datatable :cols="[
            'name' => 'width:40%;',
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
            name: 'name'// DB column name
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