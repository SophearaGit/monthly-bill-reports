<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Tenent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TenentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'pageTitle' => 'Admin | Tenents',
            'tenants' => Tenent::with('room')->latest()->get(),
            'vacantRooms' => Room::doesntHave('tenant')->orderBy('number')->get(),
            'rooms' => Room::with('tenant')->orderBy('number')->get(),
        ];
        return view('backend.pages.tenents.index', $data);
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
        $validated = $this->validateTenant($request);
        $validated = $this->hashPasswordIfProvided($validated);

        Tenent::create($validated);

        if (($validated['status'] ?? 'active') === 'active') {
            Room::where('id', $validated['room_id'])->update(['status' => 'rented']);
        }

        return redirect()->back()->with('success', 'Tenant added successfully.');
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
    public function update(Request $request, Tenent $tenent)
    {
        $validated = $this->validateTenant($request, $tenent);
        $validated = $this->hashPasswordIfProvided($validated);

        $oldRoomId = $tenent->room_id;
        $oldStatus = $tenent->status;

        $tenent->update($validated);

        $newRoomId = $validated['room_id'];
        $newStatus = $validated['status'] ?? 'active';

        if ($oldStatus === 'active' && ($oldRoomId != $newRoomId || $newStatus !== 'active')) {
            Room::where('id', $oldRoomId)->update(['status' => 'available']);
        }

        if ($newStatus === 'active') {
            Room::where('id', $newRoomId)->update(['status' => 'rented']);
        }

        return redirect()->back()->with('success', 'Tenant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenent $tenent)
    {
        if ($tenent->status === 'active') {
            Room::where('id', $tenent->room_id)->update(['status' => 'available']);
        }

        $tenent->delete();

        return redirect()->back()->with('success', 'Tenant removed.');
    }

    /**
     * Shared validation rules for storing/updating a tenant.
     */
    protected function validateTenant(Request $request, ?Tenent $tenent = null): array
    {
        $roomIdRule = Rule::unique('tenents', 'room_id')
            ->where(fn ($query) => $query->where('status', 'active'));

        if ($tenent) {
            $roomIdRule = $roomIdRule->ignore($tenent->id);
        }

        $emailRule = Rule::unique('tenents', 'email');
        if ($tenent) {
            $emailRule = $emailRule->ignore($tenent->id);
        }

        return $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'room_id' => ['required', 'exists:rooms,id', $roomIdRule],
            'move_in_date' => 'required|date',
            'move_out_date' => 'nullable|date|after_or_equal:move_in_date',
            'status' => 'nullable|in:active,moved_out',
            'email' => ['nullable', 'email', 'max:255', $emailRule],
            'password' => 'nullable|string|min:6',
            'id_card_number' => 'nullable|string|max:100',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:30',
            'occupants_count' => 'nullable|integer|min:1|max:20',
            'notes' => 'nullable|string',
        ]);
    }

    /**
     * Hash the incoming password if one was provided, otherwise strip the
     * key entirely so an update doesn't wipe out an existing password
     * when the field is simply left blank.
     */
    protected function hashPasswordIfProvided(array $validated): array
    {
        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        return $validated;
    }
}
