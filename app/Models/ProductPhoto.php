<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{

    protected $table = 'product_photos';

    protected $guarded = [];

    public function product()
    {
        return $this->hasOne('App\Models\Product');
    }
}
