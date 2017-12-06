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
    protected $appends = ['ImageUrl'];
    public function orders (){
        return $this->hasMany( Order::class);
    }
    public function getImageUrlAttribute(){
        return asset($this->image);
    }
}