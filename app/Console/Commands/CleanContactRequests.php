<?php

namespace App\Console\Commands;

use App\Models\ContactRequest;
use Illuminate\Console\Command;

class CleanContactRequests extends Command
{
    protected $signature = 'clean:contact-requests';
    protected $description = 'Delete contact requests older than 3 months';

    public function handle()
    {
        $count = ContactRequest::where('created_at', '<', now()->subMonths(3))->delete();
        $this->info("Smazáno {$count} starých požadavků.");
        return 0;
    }
}
