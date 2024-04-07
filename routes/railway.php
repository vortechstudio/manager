<?php

use Illuminate\Support\Facades\Route;

Route::prefix('railway')->as('railway.')->group(function () {
    Route::prefix('materiels')->as('materiels.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Railway\MaterielController::class, 'index'])->name('index');
        Route::get('create', [\App\Http\Controllers\Railway\MaterielController::class, 'create'])->name('create');
        Route::post('create', [\App\Http\Controllers\Railway\MaterielController::class, 'store'])->name('store');
        Route::get('{engine}', [\App\Http\Controllers\Railway\MaterielController::class, 'show'])->name('show');
    });
});
