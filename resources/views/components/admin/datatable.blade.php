<table class="table datatable table-sm">
  <thead>
    <tr>
    @foreach ($cols as $key => $styles)
      <th style="<?= $styles ?>">{{ ucwords($key) }}</th>
    @endforeach
    </tr>
  </thead>
  <tbody></tbody>
</table>

@pushOnce('pre-css')
<link rel="stylesheet" type="text/css" href="{{ asset('packages/datatable/datatables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('packages/sweetalert2/sweetalert2.min.css') }}">
@endPushOnce

@pushOnce('pre-js')
<script src="{{ asset('packages/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('packages/sweetalert2/sweetalert2.min.js') }}"></script>
@endPushOnce