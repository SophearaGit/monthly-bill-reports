<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenant_transportations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenents')->onDelete('cascade');
            $table->enum('type', ['motorbike', 'car', 'bicycle', 'other'])->default('motorbike');
            $table->string('license_plate');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_transportations');
    }
};
