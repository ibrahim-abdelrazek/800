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
        'insurance_file',
        'insurance_provider',
        'card_number',
        'insurance_expiry',
        'id_file',
        'id_expiry',
        'id_number',
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
    public function city(){
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
    public function area(){
        return $this->belongsTo(Nighborhood::class, 'nighborhood_id', 'id');
    }
}
