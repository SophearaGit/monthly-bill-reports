<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Invoices;
use App\Models\MeterReading;
use App\Models\Room;
use App\Models\Tenent;
use Illuminate\Http\Request;

class MeterReadingController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'pageTitle' => 'Admin | Meter Readings',
            'month' => $request->get('month', now()->format('Y-m')),
            'rooms' => Room::with([
                'meterReadings' => function ($q) use ($request) {
                    $q->where('month', $request->get('month', now()->format('Y-m')));
                }
            ])->get(),
        ];
        return view('backend.pages.meter-readings.index', $data);
    }

    public function store(Request $request)
    {
        $month = $request->input('month');
        $readings = $request->input('readings', []);

        foreach ($readings as $roomId => $data) {
            $room = Room::find($roomId);
            $previous = MeterReading::where('room_id', $roomId)
                ->where('month', now()->subMonth()->format('Y-m'))
                ->first();

            $waterUsed = $data['water'] - ($previous->water_reading ?? 0);
            $electricUsed = $data['electric'] - ($previous->electric_reading ?? 0);

            MeterReading::updateOrCreate(
                ['room_id' => $roomId, 'month' => $month],
                [
                    'water_reading' => $data['water'],
                    'electric_reading' => $data['electric'],
                ]
            );

            $tenant = Tenent::where('room_id', $roomId)->first();

            Invoices::updateOrCreate(
                ['room_id' => $roomId, 'month' => $month],
                [
                    'tenant_id' => $tenant?->id,
                    'water_used' => $waterUsed,
                    'electric_used' => $electricUsed,
                    'water_cost' => round($waterUsed * 0.63, 2),
                    'electric_cost' => round($electricUsed * 0.50, 2),
                    'rent_cost' => $room->rent_price,
                    'total_amount' => round($room->rent_price + ($waterUsed * 0.63) + ($electricUsed * 0.50), 2),
                    'status' => 'unpaid'
                ]
            );
        }

        return redirect()->route('meter_readings.index', ['month' => $month])->with('success', 'Readings saved and invoices updated.');
    }
}
