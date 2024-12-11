<?php

//use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Schedule the check daily report command at 8:00 PM
Schedule::command('check:daily-reports')->dailyAt('20:00');
Schedule::command('check:client-response')->hourly();
Schedule::command('tasks:check-missed-deadlines')->dailyAt('00:00');
Schedule::command('tasks:send-deadline-reminders')->dailyAt('08:00');
