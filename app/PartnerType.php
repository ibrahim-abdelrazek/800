<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartnerType extends Model
{
    static $model = 'partnertype';

    protected $table = 'partner_types';
    //
     protected $fillable = [
        'id',
         'name',
         'status'
    ];
    public function partners(){
    	return $this->hasMany(Partner::class);
    }
}
