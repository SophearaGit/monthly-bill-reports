<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenant_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenents')->onDelete('cascade');
            // Free-text label rather than an enum: document types are more
            // varied ("ID card", "vehicle registration", "birth certificate",
            // passport, ...), so the UI offers common suggestions but doesn't
            // restrict at the database level.
            $table->string('label');
            $table->string('file_path');
            $table->string('original_name')->nullable();
            $table->string('mime_type')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_documents');
    }
};
