@extends('admin.layouts.index')

@section('page','Product List')

@section('content')
    @component('admin.components.card', [
        'buttons' => [
            ['name' => 'Add', 'color' => 'success', 'url' => route('admin.product.create')],
            ['name' => 'Trash', 'color' => 'danger', 'url' => route('admin.product.trash')]
        ]
        ])
        @slot('content')
            <x-admin.datatable :cols="[
            'name' => 'width:40%;',
            'quantity' => 'width:20%;',
            'price' => 'width:20%;',
            'featured' => 'width:10%;',
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
    const callback = [(DT) => {
                Array.from(document.getElementsByClassName('dt-ajax-delete')).forEach(e => {
                    e.addEventListener('click', function(_e) {
                        Swal.fire({
                            title: 'Are you sure?',
                            // text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                sendAjaxRequest({
                                    url: _e.target.dataset.url,
                                    token: "{{ csrf_token() }}",
                                    method:'delete',
                                    formEl: e.target.parentElement,
                                    success: function(response){
                                        refresh();
                                        toastr.success(response.message);
                                    },
                                    error: function(response){
                                        toastr.error(response.message);
                                    }
                                });
                            }
                        });
                    });
            });
        }];
    const DT = new dt({columns,callback});
    function refresh(){
        DT.draw();
    }
});
</script>
@endpush