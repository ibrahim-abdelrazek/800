<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Partner;


class Doctor extends Model
{

    static $model = 'doctor';
    protected $fillable = [
        'id',
        'name',
        'specialty',
        'contact_email',
        'contact_number',
        'photo',
        'partner_id',
        'user_id'
    ];


    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function nurse()
    {
        return $this->belongsToMany(Nurse::class, 'doctor_nurse');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
