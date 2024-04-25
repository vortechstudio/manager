<?php

namespace App\Console\Commands;

use App\Models\Railway\Config\RailwayBanque;
use App\Models\User\User;
use App\Notifications\Users\SendMessageNotification;
use Illuminate\Console\Command;

class SystemActionCommand extends Command
{
    protected $signature = 'action {action}';

    protected $description = 'Effectue des actions propre aux services';

    public function handle(): void
    {
        match ($this->argument('action')) {
            'daily_flux' => $this->dailyFlux(),
        };
    }

    private function dailyFlux()
    {
        foreach (RailwayBanque::all() as $bank) {
            $bank->generate();
        }

        foreach (User::where('admin', true)->get() as $user) {
            $user->notify(new SendMessageNotification(
                'Flux Bancaire quotidien',
                'alerts',
                'info',
                'Le flux bancaire quotidien est mis à jour.'
            ));
        }
    }
}
