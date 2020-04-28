<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $guarded = ['password', 'remember_token', 'ip'];
    protected $hidden = ['password'];

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function voucher()
    {
        return $this->belongsTo('App\Models\Voucher');
    }
}
