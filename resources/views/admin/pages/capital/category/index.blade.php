@extends('admin.layouts.index')

@section('content')
    @component('admin.components.card', [
        'buttons' => [
            ['name' => 'ADD', 'color' => 'success', 'url' => route('admin.category.create')],
            ['name' => 'Trash', 'color' => 'danger', 'url' => route('admin.category.trash')]
        ]
        ])
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