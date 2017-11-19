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
    ];

    public function orders (){
        return $this->hasMany( Order::class);
    }
}