<?php

use Illuminate\Support\Facades\Route;
use Packages\URLShortener\Actions\GetURLShortenAction;

Route::get('{any?}', GetURLShortenAction::class)->where('any', '.*');
