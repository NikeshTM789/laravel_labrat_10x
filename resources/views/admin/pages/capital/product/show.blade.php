@extends('admin.layouts.index')

@inject('PDT','App\Models\Product')

@section('page','Product Description')

@push('post-js')
<script src="{{ asset('packages\photoviewer\photoviewer.min.js') }}"></script>
<script>
$('[data-gallery=gallery_small]').click(function (e) {
  e.preventDefault();
  var items = [],
    options = {
      index: $(this).index()
    };
  $('[data-gallery=gallery_big]').each(function () {
    let src = $(this).attr('href');
    items.push({
      src: src
    });
  });
  new PhotoViewer(items, options);
});
$('[data-gallery=featured_small]').click(function (e) {
  e.preventDefault();
  var items = [],
    options = {
      index: $(this).index()
    };
  $('[data-gallery=featured_big]').each(function () {
    let src = $(this).attr('href');
    items.push({
      src: src
    });
  });
  new PhotoViewer(items, options);
});
</script>
@endpush

@push('post-css')
<link rel="stylesheet" type="text/css" href="{{ asset('packages\photoviewer\photoviewer.min.css') }}">
@endpush

@section('content')
        <div class="row">
          <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">{{ $product->name }}</h3>
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Details</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Description</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Media</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
	                <table class="table table-sm">
	                  <tbody>
	                    <tr>
	                      <td>Slug</td>
	                      <td>{{ $product->slug }}</td>
	                    </tr>
	                    <tr>
	                      <td>Quantity</td>
	                      <td>{{ $product->quantity }}</td>
	                    </tr>
	                    <tr>
	                      <td>Product</td>
	                      <td>{{ $product->price }}</td>
	                    </tr>
	                    <tr>
	                      <td>Discount</td>
	                      <td>{{ $product->discount }}</td>
	                    </tr>
	                    @admin
	                    <tr>
	                      <td>Featured</td>
	                      <td>{{ $product->featured }}</td>
	                    </tr>
	                    @endadmin
	                    <tr>
	                      <td>Categories</td>
	                      {{-- @dd($product->categories) --}}
	                      <td>{{ $product->categories->pluck('name')->implode(', ') }}</td>
	                    </tr>
	                  </tbody>
	                </table>

                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_2">{!! $product->details !!}</div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_3">
	                  <div>
	                  	<h3>Featured Image</h3>
	                  	<div>
		                  	@foreach ($product->getMedia($PDT::MEDIA['featured']) as $media)
			                  	<a data-gallery="featured_big" href="{{ $media->getUrl() }}">
								  <img data-gallery="featured_small" src="{{ $media->getUrl('thumbnail') }}">
								</a>
		                  	@endforeach
	                  	</div>
	                  </div>
	                  <div>
	                  	<h3>Gallery</h3>
	                  	<div>
	                  		@foreach ($product->getMedia($PDT::MEDIA['gallery']) as $media)
		                  	<a data-gallery="gallery_big" href="{{ $media->getUrl() }}">
							  <img data-gallery="gallery_small" src="{{ $media->getUrl('thumbnail') }}">
							</a>
	                  		@endforeach
	                  	</div>
	                  </div>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- ./card -->
          </div>
          <!-- /.col -->
        </div>
@stop