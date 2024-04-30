<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('social events')->daily()->description('Permet de vérifier les status des évènement et de notifier les administrateurs en conséquence');
        $schedule->command('social eventPublish')->daily()->description("Permet de notifier que l'evenement est publie");
        $schedule->command('social article_publish')->everyMinute()->description("Permet de notifier que l'article est publie");
        $schedule->command('action daily_flux')->daily()->description("Permet de déclencher la mise à jour journalière des flux d'intérêt bancaire");
        $schedule->command('action monthly_bonus')->monthlyOn(1)->description('Permet de déclencher la génération des bonus mensuels');
        $schedule->command('action daily_config')->daily()->description('Permet de déclencher la création des paramètres quotidiens');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
