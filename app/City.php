<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';
    public function nighborhoods(){
        return $this->hasMany(Nighborhood::class);
    }
}
