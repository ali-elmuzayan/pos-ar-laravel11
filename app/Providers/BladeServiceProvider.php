<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::directive('isAdmin', function () {
            return "<?php if(auth()->check()  && auth()->user()->role === 'admin') : ?>";
        });

        Blade::directive('endIsAdmin', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('isUser', function () {
            return "<?php if(auth()->check()  && auth()->user()->role === 'user') : ?>";
        });

        Blade::directive('endIsUser', function () {
            return "<?php endif; ?>";
        });
    }
}
