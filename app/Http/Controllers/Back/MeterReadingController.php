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
                },
            ])->get(),
        ];
        return view('backend.pages.meter-readings.index', $data);
    }

    // public function store(Request $request)
    // {
    //     $month = $request->input('month');
    //     $readings = $request->input('readings', []);

    //     foreach ($readings as $roomId => $data) {
    //         $room = Room::find($roomId);
    //         $previous = MeterReading::where('room_id', $roomId)
    //             ->where('month', now()->subMonth()->format('Y-m'))
    //             ->first();

    //         $waterOld = $previous->water_reading ?? 0;
    //         $waterNew = $data['water'];
    //         $waterUsed = $data['water'] - ($previous->water_reading ?? 0);
    //         $waterUsedPrice = round($waterUsed * 0.63, 2);

    //         $electricOld = $previous->electric_reading ?? 0;
    //         $electricNew = $data['electric'];
    //         $electricUsed = $data['electric'] - ($previous->electric_reading ?? 0);
    //         $electricUsedPrice = round($electricUsed * 0.50, 2);

    //         MeterReading::updateOrCreate(
    //             ['room_id' => $roomId, 'month' => $month],
    //             [
    //                 'water_reading' => $data['water'] ?? 0,
    //                 'electric_reading' => $data['electric'] ?? 0,
    //             ]
    //         );

    //         $tenant = Tenent::where('room_id', $roomId)->first();

    //         Invoices::updateOrCreate(
    //             ['room_id' => $roomId, 'month' => $month],
    //             [
    //                 'tenant_id' => $tenant?->id,
    //                 'water_old' => $waterOld,
    //                 'water_new' => $waterNew ?? 0,
    //                 'water_used' => $waterUsed ?? 0,
    //                 'water_used_price' => $waterUsedPrice ?? 0,
    //                 'electric_old' => $electricOld,
    //                 'electric_new' => $electricNew ?? 0,
    //                 'electric_used' => $electricUsed ?? 0,
    //                 'electric_used_price' => $electricUsedPrice ?? 0,
    //                 'water_cost' => round($waterUsed * 0.63, 2),
    //                 'electric_cost' => round($electricUsed * 0.50, 2),
    //                 'rent_cost' => $room->rent_price,
    //                 'total_amount' => round($room->rent_price + ($waterUsed * 0.63) + ($electricUsed * 0.50), 2),
    //                 'status' => 'unpaid'
    //             ]
    //         );
    //     }

    //     return redirect()->route('meter_readings.index', ['month' => $month])->with('success', 'Readings saved and invoices updated.');
    // }

    public function store(Request $request)
    {
        $month = $request->input('month');
        $readings = $request->input('readings', []);

        // ✅ Calculate previous month from the submitted month, not from now()
        $previousMonth = \Carbon\Carbon::parse($month . '-01')
            ->subMonth()
            ->format('Y-m');

        foreach ($readings as $roomId => $data) {
            $room = Room::find($roomId);

            $previous = MeterReading::where('room_id', $roomId)
                ->where('month', $previousMonth) // ✅ use submitted month's previous
                ->first();

            $waterOld = $previous->water_reading ?? 0;
            $waterNew = $data['water'] ?? 0;
            $waterUsed = $waterNew - $waterOld;
            $waterUsedPrice = round($waterUsed * 0.63, 2);

            $electricOld = $previous->electric_reading ?? 0;
            $electricNew = $data['electric'] ?? 0;
            $electricUsed = $electricNew - $electricOld;
            $electricUsedPrice = round($electricUsed * 0.5, 2);

            MeterReading::updateOrCreate(
                ['room_id' => $roomId, 'month' => $month],
                [
                    'water_reading' => $waterNew,
                    'electric_reading' => $electricNew,
                ],
            );

            $tenant = Tenent::where('room_id', $roomId)->first();

            Invoices::updateOrCreate(
                ['room_id' => $roomId, 'month' => $month],
                [
                    'tenant_id' => $tenant?->id,
                    'water_old' => $waterOld,
                    'water_new' => $waterNew,
                    'water_used' => $waterUsed,
                    'water_used_price' => $waterUsedPrice,
                    'electric_old' => $electricOld,
                    'electric_new' => $electricNew,
                    'electric_used' => $electricUsed,
                    'electric_used_price' => $electricUsedPrice,
                    'water_cost' => $waterUsedPrice,
                    'electric_cost' => $electricUsedPrice,
                    'rent_cost' => $room->rent_price,
                    'total_amount' => round($room->rent_price + $waterUsedPrice + $electricUsedPrice, 2),
                    'status' => 'unpaid',
                ],
            );
        }

        return redirect()
            ->route('meter_readings.index', ['month' => $month])
            ->with('success', 'Readings saved and invoices updated.');
    }
}
