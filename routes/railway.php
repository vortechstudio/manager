<?php

use Illuminate\Support\Facades\Route;

Route::prefix('railway')->as('railway.')->group(function () {
    Route::prefix('materiels')->as('materiels.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Railway\MaterielController::class, 'index'])->name('index');
        Route::get('create', [\App\Http\Controllers\Railway\MaterielController::class, 'create'])->name('create');
        Route::post('create', [\App\Http\Controllers\Railway\MaterielController::class, 'store'])->name('store');
        Route::get('{engine}', [\App\Http\Controllers\Railway\MaterielController::class, 'show'])->name('show');
        Route::get('{engine}/edit', [\App\Http\Controllers\Railway\MaterielController::class, 'edit'])->name('edit');
        Route::put('{engine}/edit', [\App\Http\Controllers\Railway\MaterielController::class, 'update'])->name('update');
    });

    Route::prefix('hubs')->as('hubs.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Railway\HubController::class, 'index'])->name('index');
        Route::get('create', [\App\Http\Controllers\Railway\HubController::class, 'create'])->name('create');
        Route::post('create', [\App\Http\Controllers\Railway\HubController::class, 'store'])->name('store');
        Route::get('{gare}', [\App\Http\Controllers\Railway\HubController::class, 'show'])->name('show');
        Route::get('{gare}/edit', [\App\Http\Controllers\Railway\HubController::class, 'edit'])->name('edit');
        Route::put('{gare}/edit', [\App\Http\Controllers\Railway\HubController::class, 'update'])->name('update');
    });

    Route::prefix('lignes')->as('lignes.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Railway\LigneController::class, 'index'])->name('index');
        Route::get('create', [\App\Http\Controllers\Railway\LigneController::class, 'create'])->name('create');
        Route::post('create', [\App\Http\Controllers\Railway\LigneController::class, 'store'])->name('store');
        Route::get('{ligne}', [\App\Http\Controllers\Railway\LigneController::class, 'show'])->name('show');
        Route::get('{ligne}/edit', [\App\Http\Controllers\Railway\LigneController::class, 'edit'])->name('edit');
        Route::put('{ligne}/edit', [\App\Http\Controllers\Railway\LigneController::class, 'update'])->name('update');
    });

    Route::prefix('quests')->as('quests.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Railway\QuestController::class, 'index'])->name('index');
    });

    Route::prefix('location')->as('location.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Railway\LocationController::class, 'index'])->name('index');
        Route::get('create', [\App\Http\Controllers\Railway\LocationController::class, 'create'])->name('create');
        Route::post('create', [\App\Http\Controllers\Railway\LocationController::class, 'store'])->name('store');
        Route::get('{location}', [\App\Http\Controllers\Railway\LocationController::class, 'show'])->name('show');
        Route::get('{location}/edit', [\App\Http\Controllers\Railway\LocationController::class, 'edit'])->name('edit');
        Route::put('{location}/edit', [\App\Http\Controllers\Railway\LocationController::class, 'update'])->name('update');
    });

    Route::prefix('finance')->as('finance.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Railway\FinanceController::class, 'index'])->name('index');
        Route::get('{banque}', [\App\Http\Controllers\Railway\FinanceController::class, 'show'])->name('show');
    });

    Route::prefix('bonus')->as('bonus.')->group(function () {
        Route::get('/', \App\Http\Controllers\Railway\BonusController::class)->name('index');
    });

    Route::prefix('portecarte')->as('card.')->group(function () {
        Route::get('/', \App\Http\Controllers\Railway\CardController::class)->name('index');
    });

    Route::prefix('config')->as('config.')->group(function () {
        Route::get('/', \App\Http\Controllers\Railway\ConfigController::class)->name('index');
    });
});
