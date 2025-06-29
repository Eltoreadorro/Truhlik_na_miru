<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class QueueMonitor extends Command
{
    protected $signature = 'queue:monitor';
    protected $description = 'Monitor queue with auto-restart';

    public function handle()
    {
        while (true) {
            $this->call('queue:work', [
                '--tries' => 3,
                '--timeout' => 120,
                '--queue' => 'default'
            ]);
            sleep(1);
        }
    }
}
