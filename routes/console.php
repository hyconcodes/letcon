<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('schedule', function (Schedule $schedule) {
    $schedule->command('letcon:process-upgrades')->everyMinute();
});
// Schedule::command('letcon:process-upgrades')->everyMinute();