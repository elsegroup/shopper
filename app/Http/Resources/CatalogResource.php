<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CatalogResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'name' => $this->name,
                'description' => $this->description,
                'image' => $this->image,
                'parent_id' => $this->parent_id,
                'products' => ProductCollection::make($this->products),
                'slug' => $this->slug,
            ]
        ];
    }
}
