<div class="card">
  <div class="card-header">
    <h3 class="card-title">Condensed Full Width Table</h3>
    @isset($buttons)
    <div class="float-right">
      @foreach ($buttons as $button)
      <a type="button" class="btn btn-sm btn-{{ $button['color'] }}" href="{{ $button['url'] }}">{{ $button['name'] }}</a>
      @endforeach
    </div>
    @endisset
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    {{ $content }}
  </div>
  <!-- /.card-body -->
</div>