<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    static $model = 'product';

    protected $fillable = [
        'id',
        'title',
        'description',
        'qty',
        'image',
        'price',
    ];

    public function orders (){
        return $this->hasMany( Order::class);
    }

    public function category()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }


}