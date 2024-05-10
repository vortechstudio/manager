<?php

namespace App\Providers;

use App\Models\User\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
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
        \View::composer('*', function ($view) {
            $view->with('menu_head', Menu::with('translations', 'children')->section('manager_head')->get());
            $view->with('version', \VersionBuildAction::getVersionInfo());
        });

        Gate::define('viewPulse', function (User $user) {
            return $user->admin;
        });

        Gate::define('viewLogViewer', function (User $user) {
            return $user->admin;
        });

        Collection::macro('paginate', function ($perPage = 10) {
            $page = LengthAwarePaginator::resolveCurrentPage('page');

            return new LengthAwarePaginator($this->forPage($page, $perPage), $this->count(), $perPage, $page, [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => request()->query(),
            ]);
        });
    }
}
