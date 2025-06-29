<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::command('clean:contact-requests')->monthly();

Artisan::command('queue:monitor', function() {
    while (true) {
        $this->call('queue:work', [
            '--tries' => 3,
            '--timeout' => 120
        ]);
        sleep(1);
    }
})->purpose('Monitor queue with auto-restart');
