<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Invoices;
use App\Models\MeterReading;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    /**
     * Read-only tenant home: their own room, recent meter readings for
     * that room, and their own invoice history.
     */
    public function index(Request $request)
    {
        $tenant = $request->user('tenant')->load('room.floor');

        $meterReadings = $tenant->room
            ? MeterReading::where('room_id', $tenant->room_id)->latest('month')->take(12)->get()
            : collect();

        $invoices = Invoices::where('tenant_id', $tenant->id)->latest('month')->get();

        return view('tenant.portal.index', [
            'pageTitle' => 'My Room',
            'tenant' => $tenant,
            'meterReadings' => $meterReadings,
            'invoices' => $invoices,
        ]);
    }
}
