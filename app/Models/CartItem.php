<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{

    protected $table = 'cart_items';
    protected $guarded = [];

    public function cart()
    {
        return $this->hasOne('App\Models\Cart');
    }
}
