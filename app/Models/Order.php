<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany('App\Models\OrderItem');
    }

    public function customer()
    {
        return $this->hasOne('App\Models\Customer');
    }

    public function orderTotal()
    {
        return $this->belongsTo('App\Models\OrderTotal');
    }

    public function orderStatus()
    {
        return $this->hasOne('App\Models\OrderStatus');
    }

    public function voucher()
    {
        return $this->belongsTo('App\Models\Voucher');
    }

}
