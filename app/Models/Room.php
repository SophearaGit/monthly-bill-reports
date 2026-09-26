<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'number',
        'type',
        'floor_id',
        'rent_price',
        'deposit_amount',
        'status',
        'water_meter_no',
        'electric_meter_no',
        'description',
    ];

    public function floor()
    {
        return $this->belongsTo(Floor::class, 'floor_id', 'id');
    }

    public function meterReadings()
    {
        return $this->hasMany(MeterReading::class, 'room_id', 'id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoices::class, 'room_id', 'id');
    }

    public function tenant()
    {
        return $this->hasOne(Tenent::class)->where('status', 'active');
    }
}
