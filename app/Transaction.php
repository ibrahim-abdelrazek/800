<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    static $model = 'transaction';

    protected $fillable = [
        'id',
        'text',
        'amount',
        'partner_id',
        'order_id',
        'user_id'
    ];

    public function orders()
    {
        return $this->belongsTo( Order::class);
    }

    public function partner()
    {
        return $this->belongsTo( Partner::class);
    }
}
