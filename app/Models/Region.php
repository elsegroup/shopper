<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{

    protected $table = 'regions';
    protected $guarded = [];

    public function prices()
    {
        return $this->belongsTo('App\Models\PricesRegion');
    }

}
