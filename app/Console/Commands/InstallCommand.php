<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;

use function Laravel\Prompts\confirm;

class InstallCommand extends Command
{
    protected $signature = 'app:install
                        {--db-host=localhost : Database Host}
                        {--db-port=3306 : Port for the database}
                        {--db-database= : Name for the database}
                        {--db-username=root : Username for accessing the database}
                        {--db-password= : Password for accessing the database}
                        {--github-repository=: Repository du projet}
                        {--github-token=: Token accès au repository}
                        ';

    protected $description = 'Installation Initial du système';

    public function handle()
    {
        if ($this->missingRequiredOptions()) {
            $this->error('Missing required options');
            $this->line('please run');
            $this->line('php artisan app:install --help');
            $this->line('to see the command usage.');

            return 0;
        }
        $this->alert('Application is installing...');
        $this->copyEnvExampleToEnv();
        $this->generateAppKey();
        $this->updateEnvVariablesFromOptions();
        $this->info('Env file created successfully.');
        $this->installCoreSystem();
        $this->installOptionnalSystem();
        if ($this->confirm('Système visuel ?', true)) {
            $this->installFrontSystem();
        }

        $this->alert('Application is installed successfully.');

        return 1;
    }

    public function missingRequiredOptions(): bool
    {
        return ! $this->option('db-database');
    }

    private function updateEnv($data)
    {
        $env = file_get_contents(base_path('.env'));
        $env = explode("\n", $env);
        foreach ($data as $dataKey => $dataValue) {
            $alreadyExistInEnv = false;
            foreach ($env as $envKey => $envValue) {
                $entry = explode('=', $envValue, 2);
                // Check if exists or not in env file
                if ($entry[0] == $dataKey) {
                    $env[$envKey] = $dataKey.'='.$dataValue;
                    $alreadyExistInEnv = true;
                } else {
                    $env[$envKey] = $envValue;
                }
            }
            // add the variable if not exists in env
            if (! $alreadyExistInEnv) {
                $env[] = $dataKey.'='.$dataValue;
            }
        }
        $env = implode("\n", $env);
        file_put_contents(base_path('.env'), $env);

        return true;
    }

    public function copyEnvExampleToEnv(): void
    {
        if ($this->option('env') == 'local') {
            if (! is_file(base_path('.env')) && is_file(base_path('.env.example'))) {
                File::copy(base_path('.env.example'), base_path('.env'));
            }
        } elseif ($this->option('env') == 'staging' || $this->option('env') == 'testing') {
            if (! is_file(base_path('.env')) && is_file(base_path('.env.staging'))) {
                File::copy(base_path('.env.staging'), base_path('.env'));
            }
        } else {
            if (! is_file(base_path('.env')) && is_file(base_path('.env.production'))) {
                File::copy(base_path('.env.production'), base_path('.env'));
            }
        }
    }

    public static function generateAppKey(): void
    {
        Artisan::call('key:generate');
    }

    public static function runMigrationsWithSeeders()
    {
        $a = confirm('Voulez-vous executer les migration');
        if ($a) {
            try {
                Artisan::call('migrate:fresh', ['--force' => true]);
                Artisan::call('db:seed', ['--force' => true]);
            } catch (Exception $e) {
                return $e->getMessage();
            }

            return true;
        }

        return true;
    }

    public function updateEnvVariablesFromOptions(): void
    {
        $this->updateEnv([
            'DB_HOST' => $this->option('db-host'),
            'DB_PORT' => $this->option('db-port'),
            'DB_DATABASE' => $this->option('db-database'),
            'DB_USERNAME' => $this->option('db-username'),
            'DB_PASSWORD' => $this->option('db-password'),
            'GITHUB_REPOSITORY' => $this->option('github-repository'),
            'GITHUB_TOKEN' => $this->option('github-token'),
        ]);
        $conn = config('database.default', 'mysql');
        $dbConfig = Config::get("database.connections.$conn");

        $dbConfig['host'] = $this->option('db-host');
        $dbConfig['port'] = $this->option('db-port');
        $dbConfig['database'] = $this->option('db-database');
        $dbConfig['username'] = $this->option('db-username');
        $dbConfig['password'] = $this->option('db-password');
        Config::set("database.connections.$conn", $dbConfig);
        DB::purge($conn);
        DB::reconnect($conn);
    }

    private function installCoreSystem(): void
    {
        if ($this->confirm('Voulez-vous utiliser git flow ?')) {
            Process::run('git flow init -f -d --feature feature/  --bugfix bugfix/ --release release/ --hotfix hotfix/ --support support/', function (string $type, string $output) {
                if ($type == 'err') {
                    $this->error($output);
                } else {
                    $this->info('Git flow Initilialized !');
                }
            });
        }

        $this->info('Installation des dépendance principal obligatoire');

        $installLog = Process::run('composer require arcanedev/log-viewer');
        if ($installLog->successful()) {
            $this->updateEnv([
                'LOG_CHANNEL' => 'daily',
            ]);
        } else {
            $this->error("Erreur lors de l'installation du système LOG: ".$installLog->errorOutput());
        }
        Process::run('composer require barryvdh/laravel-dompdf');
    }

    private function installOptionnalSystem(): void
    {
        if ($this->confirm("Voulez-vous utiliser l'authentification ?")) {
            $installFor = Process::run('composer require laravel/fortify');
            if ($installFor->successful()) {
                Artisan::call('vendor:publish', ['--provider="Laravel\Fortify\FortifyServiceProvider"']);
            }

            $installAuthLog = Process::run('composer require rappasoft/laravel-authentication-log');
            $installIp = Process::run('composer require torann/geoip');

            if ($installAuthLog->successful() && $installIp->successful()) {
                Artisan::call('vendor:publish', ['--provider="Rappasoft\LaravelAuthenticationLog\LaravelAuthenticationLogServiceProvider"', '--tag="authentication-log-migrations"']);
                Artisan::call('vendor:publish', ['--provider="Torann\GeoIP\GeoIPServiceProvider"', '--tag=config']);
                $this->alert("Installation de Laravel Fortify Terminer, n'oublier pas d'ajouter l'interface 'AuthenticationLoggable' au model 'User'");
            } else {
                $this->error("Erreur lors de l'installation de laravel Fortify");
            }
        }

    }

    private function installFrontSystem(): void
    {
        $this->info('Installation de livewire');
        $installLive = Process::run('composer require livewire/livewire');

        if ($installLive->successful()) {
            Artisan::call('livewire:publish', ['--config']);
            Process::run('npm install');
            Process::run('npm run build');
            Process::run('composer require jantinnerezo/livewire-alert');
        } else {
            $this->error("Erreur lors de l'installation de livewire: ".$installLive->errorOutput());
        }

    }
}
