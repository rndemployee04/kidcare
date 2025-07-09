<?php

use App\Jobs\CheckBookingCompletions;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


return function (Schedule $schedule) {
    // Run every 5 minutes
    $schedule->job(new CheckBookingCompletions())->everyFiveMinutes();
};