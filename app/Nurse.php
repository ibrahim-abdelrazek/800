<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    static $model = 'nurse';
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
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
    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'doctor_nurse');
    }
    
}
