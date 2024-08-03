<div class="form-group">
  <label>{{ ucwords($label) }}</label>
    <select
      name="{{ $name }}" 
      class="select2" 
      multiple="multiple" 
      data-placeholder="Select {{ $label }}" 
      style="width: 100%;"
      >
      @foreach ($options as $key => $option)
      <option 
        value="{{ $key }}" 
        @selected(
          (!empty($selected) && in_array($key, $selected))
          ||
          in_array($key, old('category', []))
          )
        >{{ ucwords(str_replace('_',' ',$option)) }}</option>
      @endforeach
    </select>
    @error(str_replace('[]', '', $name))
    <div class="text-danger text-sm">{{ $message }}</div>
    @enderror
</div>
<!-- /.form-group -->

@pushOnce('post-css')
<link rel="stylesheet" href="{{ asset('packages/select2/css/select2.min.css') }}">
<style>
    span.select2-selection__choice__display{
        color: #000;
        padding: 0px 5px !important;
    }
</style>
@endPushOnce

@pushOnce('pre-js')
<script src="{{ asset('packages/select2/js/select2.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $('.select2').select2();
</script>
@endPushOnce
