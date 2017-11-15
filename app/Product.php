<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    static $model = 'product';

    protected $fillable = [
        'id',
         'name',
         'image',
         'price',
         'partner_id',
         'user_id'
    ];
    public function partner (){
    	return $this->belongsTo( Partner::class);
    }
    public function orders (){
    	return $this->hasMany( Order::class);
    }
}
