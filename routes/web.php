<?php

use Illuminate\Support\Facades\Route;
use Trov\Http\Controllers\MediaController;

Route::domain(config("filament.domain"))
    ->middleware(config("filament.middleware.base"))
    ->group(function () {
        Route::get('/trov/media', [MediaController::class, 'index']);
        Route::get('/trov/media/search', [MediaController::class, 'search']);
    });
