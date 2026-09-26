<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Adds proper move-in/move-out tracking plus a few standard rental
     * record fields. The blanket "one tenant per room, ever" unique
     * constraint is dropped in favor of an app-level rule of "one
     * *active* tenant per room" (enforced in TenentController), since a
     * hard unique constraint made it impossible to end a tenancy and
     * keep the tenant's history (their past invoices) once someone new
     * moved into the same room.
     */
    public function up(): void
    {
        Schema::table('tenents', function (Blueprint $table) {
            $table->date('move_in_date')->nullable()->after('room_id');
            $table->date('move_out_date')->nullable()->after('move_in_date');
            $table->enum('status', ['active', 'moved_out'])->default('active')->after('move_out_date');
            $table->string('email')->nullable()->after('phone');
            $table->string('id_card_number')->nullable()->after('status');
            $table->string('emergency_contact_name')->nullable()->after('id_card_number');
            $table->string('emergency_contact_phone')->nullable()->after('emergency_contact_name');
            $table->unsignedTinyInteger('occupants_count')->default(1)->after('emergency_contact_phone');
            $table->text('notes')->nullable()->after('occupants_count');
        });

        // Backfill move_in_date for existing tenants from their created_at,
        // since every current row is (by definition) an already-active
        // tenancy that started at some point in the past.
        DB::table('tenents')->whereNull('move_in_date')->update([
            'move_in_date' => DB::raw('DATE(created_at)'),
        ]);

        // MySQL won't let us drop `tenents_room_id_unique` while the
        // room_id foreign key still depends on it as its backing index,
        // so drop the foreign key first, drop the unique index, then
        // recreate the foreign key (MySQL will give it its own plain
        // index automatically).
        Schema::table('tenents', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
        });

        Schema::table('tenents', function (Blueprint $table) {
            $table->dropUnique(['room_id']);
        });

        Schema::table('tenents', function (Blueprint $table) {
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenents', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
        });

        Schema::table('tenents', function (Blueprint $table) {
            $table->unique('room_id');
        });

        Schema::table('tenents', function (Blueprint $table) {
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('restrict');
            $table->dropColumn([
                'move_in_date',
                'move_out_date',
                'status',
                'email',
                'id_card_number',
                'emergency_contact_name',
                'emergency_contact_phone',
                'occupants_count',
                'notes',
            ]);
        });
    }
};
