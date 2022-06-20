<?php

use Illuminate\Support\Facades\Route;
use Trov\Http\Controllers\SitemapController;

Route::get('/sitemap', [SitemapController::class, 'index']);
