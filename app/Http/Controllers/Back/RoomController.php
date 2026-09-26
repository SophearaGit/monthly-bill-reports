<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Floor;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'pageTitle' => 'Admin | Rooms',
            'rooms' => Room::with(['floor', 'tenant'])->get(),
            'floors' => Floor::withCount('rooms')->orderBy('sort_order')->get(),
        ];
        return view('backend.pages.rooms.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:50|unique:rooms,number',
            'type' => 'required|in:standard,vip,deluxe',
            'floor_id' => 'nullable|exists:floors,id',
            'rent_price' => 'required|numeric|min:0',
            'deposit_amount' => 'nullable|numeric|min:0',
            'water_meter_no' => 'nullable|string|max:100',
            'electric_meter_no' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'status' => 'nullable|in:available,booked,rented',
        ]);

        Room::create([
            'number' => $validated['number'],
            'type' => $validated['type'],
            'floor_id' => $validated['floor_id'] ?? null,
            'rent_price' => $validated['rent_price'],
            'deposit_amount' => $validated['deposit_amount'] ?? null,
            'water_meter_no' => $validated['water_meter_no'] ?? null,
            'electric_meter_no' => $validated['electric_meter_no'] ?? null,
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'] ?? 'available',
        ]);

        return redirect()->back()->with('success', 'Room added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:50|unique:rooms,number,' . $room->id,
            'type' => 'required|in:standard,vip,deluxe',
            'floor_id' => 'nullable|exists:floors,id',
            'rent_price' => 'required|numeric|min:0',
            'deposit_amount' => 'nullable|numeric|min:0',
            'water_meter_no' => 'nullable|string|max:100',
            'electric_meter_no' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'status' => 'nullable|in:available,booked,rented',
        ]);

        $room->update([
            'number' => $validated['number'],
            'type' => $validated['type'],
            'floor_id' => $validated['floor_id'] ?? null,
            'rent_price' => $validated['rent_price'],
            'deposit_amount' => $validated['deposit_amount'] ?? null,
            'water_meter_no' => $validated['water_meter_no'] ?? null,
            'electric_meter_no' => $validated['electric_meter_no'] ?? null,
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'] ?? $room->status,
        ]);

        return redirect()->back()->with('success', 'Room updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        if ($room->tenant()->exists()) {
            return redirect()->back()->with(
                'error',
                "Can't delete room {$room->number} — it still has a tenant assigned."
            );
        }

        $room->delete();

        return redirect()->back()->with('success', 'Room removed.');
    }
}
