<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricesRegion extends Model
{

    protected $table = 'prices_region';
    protected $guarded = [];

    public function region()
    {
        return $this->hasOne('App\Models\Region');
    }

    public function product()
    {
        return $this->hasOne('App\Models\Product');
    }

}
