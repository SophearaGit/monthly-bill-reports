<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 32; $i++) {
            $roomData = [
                'number' => 'R' . $i,
                'type' => 'standard',
                'rent_price' => 80.00,
                'status' => 'rented',
            ];

            if ($i == 21) {
                $roomData['type'] = 'deluxe';
                $roomData['rent_price'] = 100.00;
                $roomData['status'] = 'rented';
            }

            Room::create($roomData);
        }
        for ($i = 1; $i <= 4; $i++) {
            Room::create([
                'number' => 'RA' . $i,
                'type' => 'vip',
                'rent_price' => 100.00,
                'status' => 'rented',
            ]);
        }
    }
}
