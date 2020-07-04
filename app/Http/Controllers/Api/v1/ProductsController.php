<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Filters\ProductsFilter;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;

class ProductsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ProductsFilter $filters)
    {

        $products = Product::filter($filters)
            ->whereStatus(Product::STATUS_ACTIVE)
            ->get();

        if (empty($products)) {
            return response()->json([
                'errors' => "Продукты по заданным фильтрам не найдены.",
            ], 400)->header('Access-Control-Allow-Origin', '*');
        }

        return new ProductCollection($products);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        if (empty($product)) {
            return response()->json([
                'errors' => "Продукт с таким идентификатором не найден.",
            ], 400);
        }
        return ProductResource::make($product);
    }

}
