<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'vouchers';
    protected $guarded = [];

    public function order()
    {
        return $this->hasOne('App\Models\Orded');
    }
}
