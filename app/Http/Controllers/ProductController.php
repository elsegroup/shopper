<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    public function show($id)
    {
        $product = Product::where(['status' => Product::STATUS_ACTIVE])->firstOrFail($id);

        return view('product.show', ['product' => $product]);
    }
}
