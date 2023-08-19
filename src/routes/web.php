<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * In traditional ways, here are details:
 * - We have controllers to serve routes
 * - We are serving the whole application and routes from app directory
 * - We can not separate concerns of domains, everything are in controllers, and they are responsible
 * - Controllers are responsible for handling requests
 * - Controllers are responsible for serving the response
 *
 * In this app, the authentication system is implemented in traditional way to show difference with ADR pattern
 */
############### TRADITIONAL IMPLEMENTATIONS ################
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
############################################################

/**
 * In ADR (Action-Domain-Responder) pattern, here are details:
 * - We have separated and isolated packages to serve requests from input to output
 * - We have actions to invoke input and pass to necessary domains for logic
 * - We have responders to customize output based on each action
 * - Packages are talking to each other only in domains layer
 * - None of actions and responders don't know anything regarding logic and Single responsibility will be served completely
 * - KISS pattern will be attached to the system because by ADR pattern, layers are isolated and can be served in different ways like as isolated network or etc.
 * - We will just have 3 basic abstractions for BaseAction, BaseService and BaseResponder. Everything else will be touched inside packages like using custom database connection patterns.
 * - Unnecessary dependencies will be removed during request. In traditional ways, we had controllers which served different methods and each method has its own dependencies.
 * - This pattern mostly using for APIs rather than frontend UI, but it can work properly in any routes.
 */
############### ADR IMPLEMENTATIONS ################

require __DIR__ . '/auth.php';
