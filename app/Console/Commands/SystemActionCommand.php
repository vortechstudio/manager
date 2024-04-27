<?php

namespace App\Console\Commands;

use App\Enums\Railway\Config\BonusTypeEnum;
use App\Models\Railway\Config\RailwayBanque;
use App\Models\Railway\Config\RailwayBonus;
use App\Models\User\User;
use App\Notifications\Users\SendMessageNotification;
use Illuminate\Console\Command;
use Spatie\LaravelOptions\Options;

class SystemActionCommand extends Command
{
    protected $signature = 'action {action}';

    protected $description = 'Effectue des actions propre aux services';

    public function handle(): void
    {
        match ($this->argument('action')) {
            'daily_flux' => $this->dailyFlux(),
            'monthly_bonus' => $this->monthlyBonus(),
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

    private function monthlyBonus()
    {
        foreach (RailwayBonus::all() as $bonus) {
            $bonus->delete();
        }

        for ($i = 1; $i <= 30; $i++) {
            $type = collect(Options::forEnum(BonusTypeEnum::class)->toArray())->random()['value'];
            $qte = RailwayBonus::generateValueFromType($type);
            RailwayBonus::create([
                'number_day' => $i,
                'designation' => RailwayBonus::generateDesignationFromType($type, $qte),
                'type' => $type,
                'qte' => $qte,
            ]);
        }

        foreach (User::where('admin', true)->get() as $user) {
            $user->notify(new SendMessageNotification(
                'Bonus mensuel',
                'alerts',
                'info',
                'Le bonus mensuel est mis à jour.'
            ));
        }
    }
}
