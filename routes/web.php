<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

require __DIR__.'/auth/auth.php';

function set_active($route)
{
    if (is_array($route)) {
        return in_array(Request::path(), $route) ? 'active' : '';
    }

    return Request::path() == $route ? 'active' : '';
}
