<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\{ProductResource, ProductCollection};
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends BaseApiController {
	function allProduct() {
		$top_posts = DB::table('products')->latest()->take(50)->pluck('id')->all();
		$products = Product::with('media')->whereIn('id', $top_posts)->paginate(5);
		/**
		 *
		 * Avoid using response(new ProductCollection($products))
		 * because by using this it will not contains extra
		 * informations like pagination links and meta data
		 */
		return new ProductCollection($products);
	}

	function searchProduct(Request $request) {
		$results = DB::table('products')
			->select('id', 'name')
			->where('name', 'like', $request->key . '%')
			->limit(10)
			->get();
		return response($results);
	}

	function singleProduct(Request $request, Product $product) {
		return new ProductResource($product);
	}
}
