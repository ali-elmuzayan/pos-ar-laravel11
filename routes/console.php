<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


//Artisan::command('schedule:backup', function (Schedule $schedule) {
//    $schedule->command('backup:run')->everySixHours();
//})->purpose('Schedule daily database backup');

// Schedule the backup command to run daily at 2:00 AM
Artisan::command('schedule:backup', function (Schedule $schedule) {
    $schedule->command('backup:run')->dailyAt('02:00');
})->purpose('Schedule daily backups');
