<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    static $model = 'user';

    protected $fillable = [
        'id',
        'username',
        'email',
        'password',
        'name',
        'user_group_id',
        'partner_id'
    ];


    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function userGroup(){

         return $this->belongsTo( UserGroup::class);

    }
    public function Partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id', 'id');
    }

    public function messages(){

        return $this->hasMany( Message::class);

    }

    public function isAdmin(){
        if($this->usergroup->id === 1)
            return true;
        return false;
    }

    public function ableTo($ability, $model)
    {
        if($this->isAdmin())
            return true;

        $actions = ['view', 'add' ,'edit' ,'delete'];
        $abilities = unserialize($this->usergroup->action);
        if(!is_array($abilities)) $abilities = [];
        if(array_key_exists(strtolower($model), $abilities) && in_array(strtolower($ability), $actions))
            return (bool) $abilities[$model][array_search($ability, $actions)];
        return false;
    }


    public function isPartner(){
        if ($this->usergroup->id == 2)
            return true;
        return false;
    }

}
