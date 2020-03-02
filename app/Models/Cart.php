<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected $table = 'carts';
    protected $guarded = [];

    public function items()
    {
        return $this->belongsTo('App\Models\CartItem');
    }
}
