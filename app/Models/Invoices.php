<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    protected $fillable = [
        'room_id',
        'tenant_id',
        'month',
        'water_used',
        'electric_used',
        'water_cost',
        'electric_cost',
        'rent_cost',
        'total_amount',
        'status',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }
    public function tenant()
    {
        return $this->belongsTo(Tenent::class, 'tenant_id', 'id');
    }
}
