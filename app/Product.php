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
        'description',
        'qty',
        'image',
        'price',
    ];
    protected $appends = ['ImageUrl', 'ProductId'];
    public function orders (){
        return $this->hasMany( Order::class);
    }
    public function getImageUrlAttribute(){
        return asset($this->image);
    }
    public function getProductIdAttribute(){
        return $this->id;
    }
    public function category()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }


}