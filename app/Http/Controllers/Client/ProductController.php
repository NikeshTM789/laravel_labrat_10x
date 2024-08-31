<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    function allProduct(){
        $product = Product::with('media')->latest()->take(30)->paginate(5);
        return ProductResource::collection($product);
    }
}
