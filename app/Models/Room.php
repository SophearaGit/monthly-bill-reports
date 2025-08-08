<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'number',
        'type',
        'rent_price',
    ];

    public function meterReadings()
    {
        return $this->hasMany(MeterReading::class, 'room_id', 'id');
    }

    public function tenant()
    {
        return $this->hasOne(Tenent::class);
    }


}
