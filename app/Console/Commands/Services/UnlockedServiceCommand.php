<?php

namespace App\Console\Commands\Services;

use App\Models\Config\Service;
use Illuminate\Console\Command;

class UnlockedServiceCommand extends Command
{
    protected $signature = 'service:unlocked';

    protected $description = 'Command description';

    public function handle(): void
    {
        foreach (Service::all() as $service) {
            $service->update([
                'locked' => 0,
            ]);
        }
    }
}
