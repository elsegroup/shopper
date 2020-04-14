<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;

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
    public function index()
    {
        return new ProductCollection(
            Product::whereStatus(Product::STATUS_ACTIVE)->paginate(1)
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

}
