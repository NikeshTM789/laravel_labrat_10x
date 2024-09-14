<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    function allProduct(Request $request){
        if ($request->ajax()) {
            $results = DB::table('products')
                        ->select('id','name')
                        ->where('name','like', $request->key.'%')
                        ->limit(10)
                        ->get();
            return response($results);
        }
        $top_posts = DB::table('products')->latest()->take(50)->pluck('id')->all();
        $product = Product::with('media')->whereIn('id',$top_posts)->paginate(5);
        return ProductResource::collection($product);
    }
}
