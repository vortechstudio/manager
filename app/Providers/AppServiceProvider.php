<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Pharaonic\Laravel\Menus\Models\Menu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $menu_head = Menu::with('translations', 'children')
            ->section('manager_head')
            ->get();
        \View::share([
            "menu_head" => Menu::with('translations', 'children')
                ->section('manager_head')
                ->get(),
            "version" => \VersionBuildAction::getVersionInfo(),
        ]);

    }
}
