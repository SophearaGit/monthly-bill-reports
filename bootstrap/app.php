<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Two protected areas share this app: the admin panel and the
        // tenant portal. Send a guest to whichever login matches the area
        // they were trying to reach, based on the URL prefix, rather than
        // always bouncing them to the admin login.
        $middleware->redirectGuestsTo(function (Request $request) {
            return $request->is('tenant*')
                ? route('tenant.login')
                : route('admin.login');
        });

        // Likewise, someone already signed in who lands on a guest-only
        // page (e.g. a tenant hitting /tenant/login) should go to their
        // own area's home, not the admin dashboard by default.
        $middleware->redirectUsersTo(function (Request $request) {
            return $request->is('tenant*')
                ? route('tenant.home')
                : route('dashboard');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
