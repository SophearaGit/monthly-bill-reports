<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantSocialLink extends Model
{
    protected $fillable = [
        'tenant_id',
        'platform',
        'url',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenent::class, 'tenant_id', 'id');
    }
}
