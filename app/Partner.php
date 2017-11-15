<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    static $model = 'partner';
    protected $appends = ['user'];
     protected $fillable = [
        'id',
         'name',
         'location',
         'partner_type_id'
    ];



    public function doctors (){
    	return $this->hasMany(Doctor::class);
    }
    public function nurses (){
    	return $this->hasMany(Nurse::class);
    }
    public function  transactions(){
    	return $this->hasMany(Transaction::class);
    }
    public function patients (){
    	return $this->hasMany(Patient::class);
    }
    public function products (){
    	return $this->hasMany(Prduct::class);
    }
    public function orders (){
    	return $this->hasMany(Order::class);
    }
    public function partnerType(){
    	return $this->belongsTo(PartnerType::class);
    }
    public function hotelGuests (){
    	return $this->hasMany(HotelGuest::class);
    }
    public function getUserAttribute(){
        $id = $this->id;
        return Partner::join('users', function($q) use ($id){
            $q->where('users.partner_id', $id);
        })->first(['partners.name','partners.partner_type_id','location','users.name','users.username','users.email','users.password','users.partner_id']);
    }
    //join('user_groups', function($q){ $q->where('user_groups.id', 2); })->

}
