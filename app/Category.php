<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    static $model = 'category';
    protected $table = 'category';
    protected $fillable = [
        'id',
        'name',
        'parent'
    ];



    public function children()
    {
        return $this->hasMany(self::class, 'parent');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }

}