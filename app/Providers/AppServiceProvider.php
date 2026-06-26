<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');

            // Railway terminates SSL at the proxy edge; the internal PHP connection
            // is plain HTTP. Setting session.secure=false ensures the session cookie
            // is always sent and CSRF tokens never mismatch (419).
            config([
                'session.secure'    => false,
                'session.same_site' => 'lax',
            ]);
        }
    }
}
