<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Partner;


class Doctor extends Model
{

    static $model = 'doctor';
    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new OrderScope('created_at', 'desc'));
    }
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

    public function nurses()
    {
        return $this->belongsToMany(Nurse::class, 'doctor_nurse');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
