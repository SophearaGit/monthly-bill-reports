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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->foreignId('tenant_id')->nullable()->constrained('tenents')->onDelete('set null');
            $table->string('month', 7); // e.g., "2025-08"
            $table->decimal('water_used', 8, 2)->default(0);
            $table->decimal('electric_used', 8, 2)->default(0);
            $table->decimal('water_cost', 10, 2)->default(0);
            $table->decimal('electric_cost', 10, 2)->default(0);
            $table->decimal('rent_cost', 10, 2)->default(0);
            $table->decimal('total_amount', 12, 2);
            $table->enum('status', ['paid', 'unpaid'])->default('unpaid');
            $table->timestamps();
            $table->unique(['room_id', 'month']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
