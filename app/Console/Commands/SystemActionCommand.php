<?php

namespace App\Console\Commands;

use App\Actions\UserAction;
use App\Enums\Railway\Config\BonusTypeEnum;
use App\Models\Railway\Config\RailwayBanque;
use App\Models\Railway\Config\RailwayBonus;
use App\Models\Railway\Config\RailwayFluxMarket;
use App\Models\Railway\Config\RailwayRental;
use App\Models\Railway\Config\RailwaySetting;
use App\Models\Railway\Engine\RailwayEngine;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\LaravelOptions\Options;
use Vortechstudio\Helpers\Facades\Helpers;

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
            'daily_market_flux' => $this->dailyMarketFlux(),
            'sync_rentals' => $this->syncRentals()
        };
    }

    /**
     * Generates daily flux for all RailwayBanque records and sends a notification to the admin.
     */
    private function dailyFlux(): void
    {
        foreach (RailwayBanque::all() as $bank) {
            $bank->generate();
        }

        (new UserAction())->sendNotificationToAdmin('Flux Bancaire quotidien', 'Le flux bancaire quotidien est mis à jour.');
    }

    /**
     * Deletes all existing RailwayBonus records and creates 30 new ones with random data.
     *
     *
     * @throws \Exception description of exception
     */
    private function monthlyBonus(): void
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
    private function dailyConfig(): void
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
        RailwaySetting::where('name', 'exchange_tpoint')->first()->update([
            'value' => random_float(0, 1),
        ]);

        (new UserAction())->sendNotificationToAdmin('Configuration quotidienne', 'Les configurations sont mis à jour.');
    }

    private function dailyMarketFlux(): void
    {
        RailwayFluxMarket::create([
            'amount_flux_engine' => 0,
            'amount_flux_ligne' => 0,
            'amount_flux_hub' => 0,
            'flux_hub' => Helpers::randomFloat(-5, 5),
            'flux_engine' => Helpers::randomFloat(-5, 5),
            'flux_ligne' => Helpers::randomFloat(-5, 5),
            'date' => Carbon::today(),
        ]);
    }

    private function syncRentals(): void
    {
        foreach (RailwayRental::all() as $rental) {
            foreach (RailwayEngine::all() as $engine) {
                if (in_array($engine->type_transport->value, json_decode($rental->type, true))) {
                    \DB::connection('railway')->table('railway_engine_rentals')->insert([
                        'railway_engine_id' => $engine->id,
                        'railway_rental_id' => $rental->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
        }
    }
}
