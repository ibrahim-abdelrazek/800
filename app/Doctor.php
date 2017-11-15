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
        'contact_details',
        'partner_id',
        'nurse_id',
        'user_id'
    ];


    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function nurse()
    {
        return $this->belongsTo(Nurse::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
