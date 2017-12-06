<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notifier extends Model
{
    protected $table = 'order_notifier';

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
    
}
