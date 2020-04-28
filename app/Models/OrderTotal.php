<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTotal extends Model
{
    protected $table = 'order_totals';
    protected $guarded = [];

    public function order()
    {
        return $this->hasOne('App\Models\Order');
    }
}
