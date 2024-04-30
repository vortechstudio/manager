<?php

namespace App\Console\Commands;

use App\Actions\UserAction;
use App\Enums\Railway\Config\BonusTypeEnum;
use App\Models\Railway\Config\RailwayBanque;
use App\Models\Railway\Config\RailwayBonus;
use App\Models\Railway\Config\RailwaySetting;
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
            'daily_config' => $this->dailyConfig(),
        };
    }

    /**
     * Generates daily flux for all RailwayBanque records and sends a notification to the admin.
     *
     * @return void
     */
    private function dailyFlux()
    {
        foreach (RailwayBanque::all() as $bank) {
            $bank->generate();
        }

        (new UserAction())->sendNotificationToAdmin('Flux Bancaire quotidien', 'Le flux bancaire quotidien est mis à jour.');
    }

    /**
     * Deletes all existing RailwayBonus records and creates 30 new ones with random data.
     *
     * @return void
     *
     * @throws \Exception description of exception
     */
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

        (new UserAction())->sendNotificationToAdmin('Bonus mensuel', 'Le bonus mensuel est mis à jour.');
    }

    /**
     * Update daily configuration settings for price_diesel, price_electricity, price_kilometer, price_parking, and price_tpoint.
     */
    private function dailyConfig()
    {
        RailwaySetting::where('name', 'price_diesel')->first()->update([
            'value' => random_float(1.1, 2.2),
        ]);
        RailwaySetting::where('name', 'price_electricity')->first()->update([
            'value' => random_float(0.10, 0.56),
        ]);
        RailwaySetting::where('name', 'price_kilometer')->first()->update([
            'value' => random_float(0.45, 1.96),
        ]);
        RailwaySetting::where('name', 'price_parking')->first()->update([
            'value' => random_float(1, 2),
        ]);
        RailwaySetting::where('name', 'price_tpoint')->first()->update([
            'value' => random_float(1, 1.2),
        ]);

        (new UserAction())->sendNotificationToAdmin('Configuration quotidienne', 'Les configurations sont mis à jour.');
    }
}
