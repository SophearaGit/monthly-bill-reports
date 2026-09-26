<?php

namespace App\Console\Commands;

use App\Models\Tenent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SeedTenantPortalCredentials extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:seed-portal-credentials
                            {--password=12345678 : Password to set for every tenant}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Give every tenant a portal login: an email derived from their name, and a shared password. Safe to re-run.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $password = Hash::make($this->option('password'));
        $usedEmails = [];

        Tenent::orderBy('id')->get()->each(function (Tenent $tenant) use ($password, &$usedEmails) {
            $base = Str::slug($tenant->name);

            if ($base === '') {
                // Str::slug() drops non-Latin scripts (e.g. Khmer names)
                // entirely, so fall back to something still unique.
                $base = 'tenant' . $tenant->id;
            }

            $email = $base . '@tenant.local';
            $suffix = 1;

            while (
                in_array($email, $usedEmails, true)
                || Tenent::where('email', $email)->where('id', '!=', $tenant->id)->exists()
            ) {
                $suffix++;
                $email = $base . $suffix . '@tenant.local';
            }

            $usedEmails[] = $email;

            $tenant->forceFill([
                'email' => $email,
                'password' => $password,
            ])->save();

            $this->line("  {$tenant->name} -> {$email}");
        });

        $this->info('Done. Every tenant can now log in at /tenant/login with the password: ' . $this->option('password'));

        return self::SUCCESS;
    }
}
