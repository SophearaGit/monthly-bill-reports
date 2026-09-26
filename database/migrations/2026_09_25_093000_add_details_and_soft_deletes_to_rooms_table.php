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
            $table->string('floor')->nullable()->after('type');
            $table->decimal('deposit_amount', 10, 2)->nullable()->after('rent_price');
            $table->string('water_meter_no')->nullable()->after('status');
            $table->string('electric_meter_no')->nullable()->after('water_meter_no');
            $table->text('description')->nullable()->after('electric_meter_no');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn([
                'floor',
                'deposit_amount',
                'water_meter_no',
                'electric_meter_no',
                'description',
            ]);
            $table->dropSoftDeletes();
        });
    }
};
