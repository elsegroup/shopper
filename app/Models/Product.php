<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';

    protected $guarded = [];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    public function photos()
    {
        return $this->belongsTo('App\Models\ProductPhoto');
    }

    public function orderItems()
    {
        return $this->belongsTo('App\Models\OrderItem');
    }

    public function cartItem()
    {
        return $this->belongsTo('App\Models\CartItem');
    }

    public function pricesRegion()
    {
        return $this->belongsTo('App\Models\PricesRegion');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

}
