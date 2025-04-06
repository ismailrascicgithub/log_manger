<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    } else {
        return redirect()->route('login');
    }
})->name('main');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', ["isAdmin" => Auth::user()->isAdmin()]);
})->middleware(['auth'])->name('dashboard');


Route::middleware(['auth', 'can:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::resource('projects', ProjectController::class);
    Route::get('projects/export', [ProjectController::class, 'export'])
        ->name('projects.export');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');

    Route::get('/logs/export', [LogController::class, 'export'])
        ->name('logs.export');

    Route::get('/logs/stats', [LogController::class, 'stats'])->name('logs.stats');


});

require __DIR__ . '/auth.php';
