<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    static $model = 'patient';
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'date',
        'gender',
        'contact_number',
        'email',
        'insurance_card_details',
        'emirates_id_details',
        'notes',
        'address',
        'partner_id',
        'user_id'
    ];
    public function partner(){
    	return $this->belongsTo(Partner::class);
    }
    public function orders (){
    	return $this->hasMany(Order::class);
    }
}
