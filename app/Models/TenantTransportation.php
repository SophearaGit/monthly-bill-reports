<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantTransportation extends Model
{
    protected $fillable = [
        'tenant_id',
        'type',
        'brand',
        'license_plate',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenent::class, 'tenant_id', 'id');
    }
}
