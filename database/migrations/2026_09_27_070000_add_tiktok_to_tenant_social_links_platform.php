<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE tenant_social_links MODIFY platform ENUM('facebook', 'telegram', 'whatsapp', 'instagram', 'tiktok', 'other') NOT NULL DEFAULT 'other'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE tenant_social_links MODIFY platform ENUM('facebook', 'telegram', 'whatsapp', 'instagram', 'other') NOT NULL DEFAULT 'other'");
    }
};
