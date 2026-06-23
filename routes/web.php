<?php

use App\Http\Controllers\BesaranUpController;
use App\Http\Controllers\BlokirRekeningController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KebijakanSpdController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PerangkatDaerahController;
use App\Http\Controllers\RekeningBank\RkudController;
use App\Http\Controllers\RekeningBank\SkpdController;
use App\Http\Controllers\RekeningPenerimaanController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
Auth::routes();

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('roles/data', [RoleController::class, 'data'])->name('roles.data');
    Route::resource('roles', RoleController::class);

    Route::get('kebijakan-spd/data', [KebijakanSpdController::class, 'data'])->name('kebijakan-spd.data');
    Route::resource('kebijakan-spd', KebijakanSpdController::class);

    Route::prefix('rekening-bank')->group(function () {
        Route::get('rkud/data', [RkudController::class, 'data'])->name('rkud.data');
        Route::resource('rkud', RkudController::class);

        Route::get('skpd/data', [SkpdController::class, 'data'])->name('skpd.data');
        Route::patch('skpd/{id}/nonaktifkan', [SkpdController::class, 'nonaktifkan'])->name('skpd.nonaktifkan');
        Route::resource('skpd', SkpdController::class)->only(['index']);
    });

    Route::get('besaran-up/data', [BesaranUpController::class, 'data'])->name('besaran-up.data');
    Route::resource('besaran-up', BesaranUpController::class);

    Route::get('users/data', [UserController::class, 'data'])->name('users.data');
    Route::resource('users', UserController::class);
    Route::get('users/{user}/permissions', [UserController::class, 'editPermissions'])->name('users.permissions');
    Route::put('users/{user}/permissions', [UserController::class, 'updatePermissions'])->name('users.permissions.update');

    Route::get('pegawai/data', [PegawaiController::class, 'data'])->name('pegawai.data');
    Route::resource('pegawai', PegawaiController::class);

    Route::get('perangkat-daerah/data', [PerangkatDaerahController::class, 'data'])->name('perangkat-daerah.data');
    Route::resource('perangkat-daerah', PerangkatDaerahController::class);

    Route::get('rek-penerimaan/data', [RekeningPenerimaanController::class, 'data'])->name('rek-penerimaan.data');
    Route::patch('rek-penerimaan/batch-update', [RekeningPenerimaanController::class, 'updateBatch'])->name('rek-penerimaan.batch-update');
    Route::resource('rek-penerimaan', RekeningPenerimaanController::class)->only(['index', 'update']);

    Route::get('blokir-rekening/tree', [BlokirRekeningController::class, 'tree'])->name('blokir-rekening.tree');
    Route::post('blokir-rekening/update', [BlokirRekeningController::class, 'update'])->name('blokir-rekening.update');
    Route::get('blokir-rekening', [BlokirRekeningController::class, 'index'])->name('blokir-rekening.index');

    require __DIR__.'/pengeluaran.php';
});

require __DIR__.'/auth/auth.php';

function set_active($route)
{
    if (is_array($route)) {
        return in_array(Request::path(), $route) ? 'active' : '';
    }

    return Request::path() == $route ? 'active' : '';
}
