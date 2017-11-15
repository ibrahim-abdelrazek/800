<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    //
    static $model = 'usergroup';

    protected $table="user_groups";

     protected $fillable = [
         'id',
         'group_name',
         'action',
         'partner_id'
     ];

    public function users(){
    	return $this->hasMany( User::class);
    }
}
