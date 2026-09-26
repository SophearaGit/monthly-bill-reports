<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * Switches room_id foreign keys from CASCADE to RESTRICT so that
     * hard-deleting a room can no longer silently wipe its billing
     * history (meter readings / invoices). Rooms should be soft-deleted
     * instead (see the previous migration).
     *
     * Also enforces one tenant record per room at the database level,
     * matching the app's existing "one active tenant per room" rule
     * (previously only enforced in the controller's validation).
     */
    public function up(): void
    {
        Schema::table('meter_readings', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('restrict');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('restrict');
        });

        Schema::table('tenents', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('restrict');
            $table->unique('room_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenents', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropUnique(['room_id']);
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });

        Schema::table('meter_readings', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });
    }
};
