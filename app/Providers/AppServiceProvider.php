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

            config([
                'session.driver'    => 'database',
                'session.secure'    => false,
                'session.same_site' => 'lax',
            ]);
        }
    }
}
