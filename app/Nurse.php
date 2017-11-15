<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    static $model = 'nurse';
    protected $fillable = [
        'id',
         'name',
         'partner_id',
         'user_id'
    ];
    public function partner (){
    	return $this->belongsTo(Partner::class);
    }
}
