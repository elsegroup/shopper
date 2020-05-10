<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $product = Product::find($this->product_id);

        return parent::toArray([
            'productID' => $this->product_id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $product->quantity
        ]);
    }
}
