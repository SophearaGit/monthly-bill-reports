<?php

namespace Database\Seeders;

use App\Models\Invoices;
use App\Models\MeterReading;
use App\Models\Room;
use App\Models\Tenent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoicesSeeder extends Seeder
{
    /**
     * Backfill invoices from existing meter readings, using the same
     * calculation as MeterReadingController@store (rent + water usage
     * at 0.63/unit + electric usage at 0.50/unit).
     */
    public function run(): void
    {
        $readingsByRoom = MeterReading::orderBy('month')
            ->get()
            ->groupBy('room_id');

        $rooms = Room::all()->keyBy('id');
        $tenants = Tenent::all()->keyBy('room_id');

        foreach ($readingsByRoom as $roomId => $readings) {
            $room = $rooms->get($roomId);
            if (! $room) {
                continue;
            }

            $tenant = $tenants->get($roomId);
            $previous = null;

            foreach ($readings as $reading) {
                $waterOld = $previous->water_reading ?? 0;
                $waterNew = $reading->water_reading ?? 0;
                $waterUsed = $waterNew - $waterOld;
                $waterUsedPrice = round($waterUsed * 0.63, 2);

                $electricOld = $previous->electric_reading ?? 0;
                $electricNew = $reading->electric_reading ?? 0;
                $electricUsed = $electricNew - $electricOld;
                $electricUsedPrice = round($electricUsed * 0.50, 2);

                Invoices::updateOrCreate(
                    ['room_id' => $roomId, 'month' => $reading->month],
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

                $previous = $reading;
            }
        }
    }
}
