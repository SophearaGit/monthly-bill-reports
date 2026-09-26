<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Gives tenants an optional login: an admin sets a password for a
     * tenant (in the Add/Edit Tenant modal) and the tenant can then sign
     * in to a read-only portal (their room, meter readings, invoices)
     * under the `tenant` guard. A tenant with no password set simply has
     * no portal access yet.
     */
    public function up(): void
    {
        Schema::table('tenents', function (Blueprint $table) {
            $table->string('password')->nullable()->after('email');
            $table->rememberToken()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenents', function (Blueprint $table) {
            $table->dropColumn(['password', 'remember_token']);
        });
    }
};
