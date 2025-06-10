<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
// Registro de tareas programadas
return function (Schedule $schedule) {
    $schedule->command('reservas:mover-historial')->everyMinute();
};
