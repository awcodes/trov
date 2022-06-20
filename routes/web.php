<?php

use Illuminate\Support\Facades\Route;
use Trov\Http\Controllers\SitemapController;

Route::get('/sitemap.xml', [SitemapController::class, 'index']);
Route::get('/sitemap', [SitemapController::class, 'pretty']);
