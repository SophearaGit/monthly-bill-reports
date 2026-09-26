<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Tenent extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'phone',
        'room_id',
        'move_in_date',
        'move_out_date',
        'status',
        'email',
        'password',
        'id_card_number',
        'emergency_contact_name',
        'emergency_contact_phone',
        'occupants_count',
        'notes',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'move_in_date' => 'date',
        'move_out_date' => 'date',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoices::class, 'tenant_id', 'id');
    }

    /**
     * A tenant only has portal access once an admin has set a password
     * for them.
     */
    public function hasPortalAccess(): bool
    {
        return ! empty($this->password);
    }
}
