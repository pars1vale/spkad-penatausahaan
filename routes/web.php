<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::get('/users/{user}/permissions', [UserController::class, 'editPermissions'])
        ->name('users.permissions');
    Route::put('/users/{user}/permissions', [UserController::class, 'updatePermissions'])
        ->name('users.permissions.update');
});

require __DIR__.'/auth/auth.php';

function set_active($route)
{
    if (is_array($route)) {
        return in_array(Request::path(), $route) ? 'active' : '';
    }

    return Request::path() == $route ? 'active' : '';
}
