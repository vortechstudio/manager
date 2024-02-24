<?php

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

Route::middleware(["auth", "admin"])->group(function () {
    Route::get('/', \App\Livewire\Dashboard::class)->name('home');

    Route::prefix('social')->as('social.')->group(function () {
        Route::get('/', \App\Livewire\Social\Dashboard::class)->name('index');
        Route::prefix('articles')->as('articles.')->group(function () {
            Route::get('/', \App\Livewire\Social\Articles::class)->name('index')->lazy();
            Route::get('create', \App\Livewire\Social\ArticleCreate::class)->name('create')->lazy();
            Route::get('{id}', \App\Livewire\Social\Articles::class)->name('show')->lazy();
            Route::get('{id}/edit', \App\Livewire\Social\Articles::class)->name('edit')->lazy();
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
        ->middleware(["auth", "throttle:6,1"]);
});

Route::get('password-confirm', [\App\Http\Controllers\Auth\AuthController::class, 'confirmPasswordForm'])
    ->name('password.confirm')
    ->middleware('auth');

Route::get('/test', function () {

});
