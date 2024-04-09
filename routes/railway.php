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
});
