<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nighborhood extends Model
{
    protected $table = 'nighbourhoods';
    public function city(){
        return $this->belongsTo(City::class);
    }
}
