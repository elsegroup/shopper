<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $guarded = [];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }
}
