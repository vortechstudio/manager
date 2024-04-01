<?php

use App\Http\Controllers\Social\ServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Route::get('/', function () {
    dd(\Pharaonic\Laravel\Menus\Models\Menu::section('manager_head')->get());
})->name('home');*/

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/', \App\Http\Controllers\DashboardController::class)->name('home');

    Route::get('notifications', [\App\Http\Controllers\Auth\NotificationController::class, 'index'])->name('notification.index');
    Route::get('notifications/{id}', [\App\Http\Controllers\Auth\NotificationController::class, 'show'])->name('notification.show');

    Route::prefix('social')->as('social.')->group(function () {
        Route::get('/', \App\Livewire\Social\Dashboard::class)->name('index');
        Route::prefix('articles')->as('articles.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Social\ArticleController::class, 'index'])->name('index');
            Route::get('create', [\App\Http\Controllers\Social\ArticleController::class, 'create'])->name('create');
            Route::post('create', [\App\Http\Controllers\Social\ArticleController::class, 'store'])->name('store');
            Route::get('{id}', [\App\Http\Controllers\Social\ArticleController::class, 'show'])->name('show');
            Route::get('{id}/edit', [\App\Http\Controllers\Social\ArticleController::class, 'edit'])->name('edit');
            Route::put('{id}/edit', [\App\Http\Controllers\Social\ArticleController::class, 'update'])->name('update');
            Route::delete('{id}', [\App\Http\Controllers\Social\ArticleController::class, 'destroy'])->name('destroy');

            Route::get('{id}/publish', [\App\Http\Controllers\Social\ArticleController::class, 'publish'])->name('publish');
            Route::get('{id}/unpublish', [\App\Http\Controllers\Social\ArticleController::class, 'publish'])->name('unpublish');
        });

        Route::prefix('pages')->as('pages.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Social\PageController::class, 'index'])->name('index');
            Route::get('create', [\App\Http\Controllers\Social\PageController::class, 'create'])->name('create');
            Route::post('create', [\App\Http\Controllers\Social\PageController::class, 'store'])->name('store');
            Route::get('{id}', [\App\Http\Controllers\Social\PageController::class, 'show'])->name('show');
            Route::get('{id}/edit', [\App\Http\Controllers\Social\PageController::class, 'edit'])->name('edit');
            Route::put('{id}/edit', [\App\Http\Controllers\Social\PageController::class, 'update'])->name('update');
            Route::delete('{id}', [\App\Http\Controllers\Social\PageController::class, 'destroy'])->name('destroy');
        });

        Route::get('cercles', [\App\Http\Controllers\Social\CercleController::class, 'index'])->name('cercles.index');

        Route::prefix('services')->as('services.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Social\ServiceController::class, 'index'])->name('index');
            Route::get('{id}', [\App\Http\Controllers\Social\ServiceController::class, 'show'])->name('show');

            Route::prefix('{id}/version')->as('version.')->group(function () {
                Route::post('/', [ServiceController::class, 'postVersion'])->name('store');
            });
        });

        Route::prefix('events')->as('events.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Social\EventController::class, 'index'])->name('index');
            Route::post('create', [\App\Http\Controllers\Social\EventController::class, 'store'])->name('store');
            Route::get('{id}', [\App\Http\Controllers\Social\EventController::class, 'show'])->name('show');
            Route::get('{id}/edit', [\App\Http\Controllers\Social\EventController::class, 'edit'])->name('edit');
            Route::put('{id}/edit', [\App\Http\Controllers\Social\EventController::class, 'update'])->name('update');
            Route::delete('{id}', [\App\Http\Controllers\Social\EventController::class, 'destroy'])->name('destroy');

            Route::post('{id}/poll', [\App\Http\Controllers\Social\EventController::class, 'storePoll'])->name('store.poll');
        });

    });
});

Route::prefix('auth')->as('auth.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login');
    Route::get('{provider}/redirect', [\App\Http\Controllers\Auth\AuthController::class, 'redirect'])->name('redirect');
    Route::get('{provider}/callback', [\App\Http\Controllers\Auth\AuthController::class, 'callback'])->name('callback');
    Route::get('{provider}/setup/{email}', [\App\Http\Controllers\Auth\AuthController::class, 'setupView'])->name('setup-register-view');
    Route::post('{provider}/setup/{email}', [\App\Http\Controllers\Auth\AuthController::class, 'setupRegister'])->name('setup-register');
    Route::get('logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');
    Route::post('password-confirm', [\App\Http\Controllers\Auth\AuthController::class, 'confirmPassword'])
        ->name('confirm-password')
        ->middleware(['auth', 'throttle:6,1']);
});

Route::get('password-confirm', [\App\Http\Controllers\Auth\AuthController::class, 'confirmPasswordForm'])
    ->name('password.confirm')
    ->middleware('auth');

Route::get('/test', function () {

});
