<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getStatusAttribute()
    {
        $statusMapping = [
            10 => 'pending',
            20 => 'process',
            30 => 'sending',
            40 => 'received',
            50 => 'return',
            90 => 'cancel',
            91 => 'payment expired',
        ];

        return $statusMapping[$this->attributes['status']] ?? null;
    }
}
