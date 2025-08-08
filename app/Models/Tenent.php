<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenent extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'room_id',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }


}
