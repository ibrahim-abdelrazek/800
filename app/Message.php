<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
     protected $fillable = [
        'id',
         'sender_id',
         'reciever_id',
         'message'
    ];
    
    public function user(){
    	return $this->belongsTo(User::class);
    }
   
}
