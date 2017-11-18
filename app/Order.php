<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    static $model = 'order';

    protected $fillable = [
        'id',
         'prescription',
         'notes',
         'patient_id',
         'doctor_id',
         'partner_id',
         'product_id',
        'status_id',
         'user_id'
    ];
    public function partner (){
    	return $this->belongsTo(Partner::class);
    }
    public function product (){
    	return $this->belongsTo(Product::class);
    }
    public function doctor (){
    	return $this->belongsTo(Doctor::class);
    }
    public function patient (){
    	return $this->belongsTo(Patient::class);
    }
    public function transactions (){
    	return $this->hasOne(Transaction::class);
    }
    public function Owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function status(){
        return $this->belongsTo(Status::class);
    }
}
