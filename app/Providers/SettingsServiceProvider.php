<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
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
        // Fetch the company name from the settings table
        try {
            $setting = Setting::first();

        } catch (\Exception $e) {
            echo "Failed to connect to the database: ";
            Log::error("Database connection error: " . $e->getMessage());
$setting = null;
        }


        // Share the data with all views
        view()->share('setting', $setting);
    }
}
