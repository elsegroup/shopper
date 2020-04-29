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
    protected $productModel;

    public function __construct(Product $productModel)
    {
        return $this->productModel = $productModel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ProductsFilter $filters)
    {
        $products = Product::whereStatus(Product::STATUS_ACTIVE);

        $products = Product::filter($filters)->paginate(1);

        return new ProductCollection(
            $products
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getProductById(Product $product)
    {
        return ProductResource::make($product);
    }

    /*public function search(Request $request)
    {
        $products = Product::with('info');
        dd($products);
        $filters = (new ProductsFilter($products, $request)->apply()->get());
        return $filters;
    }*/

}
