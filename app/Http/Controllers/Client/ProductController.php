<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    function allProduct(){
        $product = Product::with('media')->latest()->paginate(25);
        return ProductResource::collection($product);
    }
}
