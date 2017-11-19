<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelGuest extends Model
{

    static $model = 'hotelguest';
    protected $table = "hotel_guests";

    protected $fillable = [
        'id',
        'name',
        'officer_name',
        'contact_number',
        'guest_room_number',
        'guest_first_name',
        'guest_last_name',
        'items',
        'partner_id',
        'user_id'
    ];


    public function partner()
    {
        return $this->belongsTo(Partner::class);

    }

}
