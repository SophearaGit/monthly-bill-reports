<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->foreignId('floor_id')->nullable()->after('type')->constrained('floors')->nullOnDelete();
        });

        // Best-effort migrate any existing free-text floor values to the new
        // lookup table before dropping the old column.
        $rooms = \DB::table('rooms')->whereNotNull('floor')->where('floor', '!=', '')->get();
        foreach ($rooms as $room) {
            $floor = \DB::table('floors')->whereRaw('LOWER(name) = ?', [strtolower(trim($room->floor))])->first();
            if (! $floor) {
                $floorId = \DB::table('floors')->insertGetId([
                    'name' => trim($room->floor),
                    'sort_order' => 99,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $floorId = $floor->id;
            }
            \DB::table('rooms')->where('id', $room->id)->update(['floor_id' => $floorId]);
        }

        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn('floor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->string('floor')->nullable()->after('type');
        });

        $rooms = \DB::table('rooms')->whereNotNull('floor_id')->get();
        foreach ($rooms as $room) {
            $floor = \DB::table('floors')->find($room->floor_id);
            if ($floor) {
                \DB::table('rooms')->where('id', $room->id)->update(['floor' => $floor->name]);
            }
        }

        Schema::table('rooms', function (Blueprint $table) {
            $table->dropForeign(['floor_id']);
            $table->dropColumn('floor_id');
        });
    }
};
