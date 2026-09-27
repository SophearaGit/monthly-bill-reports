<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantDocument extends Model
{
    protected $fillable = [
        'tenant_id',
        'label',
        'file_path',
        'original_name',
        'mime_type',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenent::class, 'tenant_id', 'id');
    }
}
