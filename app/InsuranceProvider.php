<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsuranceProvider extends Model
{
    //
    protected $table = 'insurance_companies';

    protected function patients(){
        return $this->hasMany(Patient::class, 'insurance_provider', 'id');
    }
}
