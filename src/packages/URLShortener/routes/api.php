<?php

use Illuminate\Support\Facades\Route;
use Packages\URLShortener\Actions\PostURLShortenAction;

Route::prefix('api')->middleware(['api', 'auth'])->group(function () {
    Route::prefix('url-shortener')->group(function () {
        Route::post('shorten', PostURLShortenAction::class)->name('url.post');
    });
});
