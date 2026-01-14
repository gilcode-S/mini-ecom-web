<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');
Route::prefix('admin')->group(function () {
    // login routes
    Route::get('login', [AdminController::class, 'create'])->name('admin.login');

    Route::group(['middleware' => ['admin']], function () {
        //dashboard route
        Route::resource('dashboard', AdminController::class)->only(['index']);
    });
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__ . '/settings.php';
