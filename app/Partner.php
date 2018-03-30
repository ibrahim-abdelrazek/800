<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    static $model = 'partner';
    protected $appends = ['user'];
     protected $fillable = [
         'id',
         'first_name',
         'last_name',
         'location',
         'photo',
         'partner_type_id',
         'logo',
         'phone',
         'email',
         'fax',
         'commission'
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
    	return $this->hasMany(Product::class);
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
        })->first(['partners.first_name','partners.last_name','partners.partner_type_id','location','users.first_name','users.last_name','users.email','users.password','users.partner_id']);
    }
    //join('user_groups', function($q){ $q->where('user_groups.id', 2); })->
    public function getTransactionAmount(){
        $amount = 0;
        if(!$this->transactions->count() > 0)
            return 0;

        foreach ($this->transactions as $transaction){
            $amount += $transaction->amount;
        }
        return $amount;
    }
}
