<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Floor;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    /**
     * Store a newly created floor.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:floors,name',
        ]);

        $nextOrder = (int) Floor::max('sort_order') + 1;

        Floor::create([
            'name' => $validated['name'],
            'sort_order' => $nextOrder,
        ]);

        return redirect()->back()->with('success', 'Floor added successfully.');
    }

    /**
     * Remove the specified floor, as long as no rooms are assigned to it.
     */
    public function destroy(Floor $floor)
    {
        if ($floor->rooms()->exists()) {
            return redirect()->back()->with(
                'error',
                "Can't delete \"{$floor->name}\" — it still has rooms assigned to it."
            );
        }

        $floor->delete();

        return redirect()->back()->with('success', 'Floor removed.');
    }
}
