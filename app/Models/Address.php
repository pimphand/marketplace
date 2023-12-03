<?php

namespace App\Models;

use App\Models\RajaOngkir\City as RajaOngkirCity;
use App\Models\RajaOngkir\Province as RajaOngkirProvince;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['set_default'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    function newCity()
    {
        return $this->belongsTo(RajaOngkirCity::class, 'city_id', 'city_id');
    }

    public function newState()
    {
        return $this->belongsTo(RajaOngkirProvince::class, 'state_id', 'province_id');
    }
}
