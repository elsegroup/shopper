<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected $table = 'carts';
    public $incrementing = false;
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany('App\Models\CartItem');
    }
}
