<?php

namespace App\Models;

use App\Models\RajaOngkir\City;
use App\Models\RajaOngkir\Province;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'location'
    ];

    public function getCity()
    {
        return $this->belongsTo(City::class, 'city', 'city_id');
    }

    public function scopeWhereLike($query, $columns, $searchTerm)
    {
        $query->where(function ($query) use ($columns, $searchTerm) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'like', '%' . $searchTerm . '%');
            }
        });
    }

    function getLocationAttribute()
    {
        return $this->getCity->province->province_name . ', ' . $this->getCity->city_name;
    }

    public function applies(): HasMany
    {
        return $this->hasMany(ServiceApply::class);
    }
}
