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
    // handle login
    Route::post('login', [AdminController::class, 'store'])->name('admin.login.request');
    Route::group(['middleware' => ['admin']], function () {
        //dashboard route
        Route::resource('dashboard', AdminController::class)->only(['index']);
        // logout
        Route::get('logout', [AdminController::class, 'destroy'])->name('admin.logout');

        //update password route for admin
        Route::get('update-password', [AdminController::class, 'edit'])->name('admin.update-password');
        // handle verify password
        Route::post('verify-password', [AdminController::class, 'verifyPassword'])->name('admin.verify-password');
    });
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__ . '/settings.php';
