<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

//    Route::middleware('can:viewAny,App\Models\User')->name('users.')->group(function () {
//        Route::get('/users', [UserController::class, 'index'])->name('index');
//        Route::get('/users/{user}', [UserController::class, 'show'])
//            ->middleware('can:view,user');
//        Route::put('/users/{user}', [UserController::class, 'update'])
//            ->middleware('can:update,user');
//        Route::delete('/users/{user}', [UserController::class, 'destroy'])
//            ->middleware('can:delete,user');
//    });
    Route::middleware('not.found:viewAny,App\Models\User')->name('users.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('index');
        Route::get('/users/{user}', [UserController::class, 'show'])
            ->middleware('not.found:view,user')
            ->name('show');
        Route::put('/users/{user}', [UserController::class, 'update'])
            ->middleware('not.found:update,user')
            ->name('update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])
            ->middleware('not.found:delete,user')
            ->name('delete');
    });
});

require __DIR__.'/auth.php';
