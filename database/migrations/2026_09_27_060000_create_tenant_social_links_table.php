<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenant_social_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenents')->onDelete('cascade');
            $table->enum('platform', ['facebook', 'telegram', 'whatsapp', 'instagram', 'other'])->default('other');
            $table->string('url');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_social_links');
    }
};
