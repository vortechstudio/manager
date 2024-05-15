<?php

namespace App\Console\Commands\Services;

use App\Models\Config\Service;
use Illuminate\Console\Command;

class LockedServiceCommand extends Command
{
    protected $signature = 'service:locked';

    protected $description = 'Command description';

    public function handle(): void
    {
        foreach (Service::all() as $service) {
            $service->update([
                'locked' => 1,
            ]);
        }
    }
}
