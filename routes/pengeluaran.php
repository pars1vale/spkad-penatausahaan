<?php

use App\Http\Controllers\Pengeluaran\Dpa\Penerimaan\DpaPenerimaanPendapatanController;
use App\Http\Controllers\Pengeluaran\Dpa\Penerimaan\DpaPenerimaanPendapatanDetailController;
use Illuminate\Support\Facades\Route;

Route::prefix('pengeluaran')->group(function () {
    //
    Route::prefix('dpa')->group(function () {
        Route::prefix('penerimaan')->group(function () {
            Route::get('dpa-pendapatan/data', [DpaPenerimaanPendapatanController::class, 'data'])->name('dpa-pendapatan.data');
            Route::patch('dpa-pendapatan/{dpaPendapatan}/toggle-kunci', [DpaPenerimaanPendapatanController::class, 'toggleKunci'])
                ->name('dpa-pendapatan.toggle-kunci');
            Route::resource('dpa-pendapatan', DpaPenerimaanPendapatanController::class);

            Route::get('dpa-pendapatan/{idSkpd}/detail/data', [DpaPenerimaanPendapatanDetailController::class, 'data'])
                ->name('dpa-pendapatan.detail.data');

            Route::get('dpa-pendapatan/{idSkpd}/detail', [DpaPenerimaanPendapatanDetailController::class, 'show'])
                ->name('dpa-pendapatan.detail.show');

            Route::patch('dpa-pendapatan/{idSkpd}/detail/{id}', [DpaPenerimaanPendapatanDetailController::class, 'update'])
                ->name('dpa-pendapatan.detail.update');
        });
        Route::prefix('Penarikan')->group(function () {
            //
        });
        Route::prefix('Validasi')->group(function () {
            //
        });
        Route::prefix('Laporan')->group(function () {
            //
        });
    });
    Route::prefix('SPD')->group(function () {
        //
    });
    Route::prefix('Pengajuan')->group(function () {
        //
    });
    Route::prefix('Pertanggung-Jawaban-NPD')->group(function () {
        //
    });
    Route::prefix('Kontraktual')->group(function () {
        //
    });
    Route::prefix('SPP')->group(function () {
        //
    });
    Route::prefix('SPM')->group(function () {
        //
    });
    Route::prefix('SP2D')->group(function () {
        //
    });
    Route::prefix('TBP')->group(function () {
        //
    });
    Route::prefix('Pengembalian-Belanja')->group(function () {
        //
    });
    Route::prefix('STS')->group(function () {
        //
    });
    Route::prefix('BKU')->group(function () {
        //
    });
    Route::prefix('LPJ')->group(function () {
        //
    });
    Route::prefix('Daftar-Rekanan')->group(function () {
        //
    });
});
