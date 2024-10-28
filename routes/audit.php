<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auditor\AuditorController;
use App\Http\Controllers\Auditor\AuditorSessionController;


Route::controller(AuditorSessionController::class)->group(function(){
    Route::get('/session/tahun-anggaran', 'tahun_anggaran')->middleware('auth');
    Route::post('/session/tahun-anggaran', 'tahun_anggaran')->middleware('auth');
});

Route::controller(AuditorController::class)->group(function(){
    Route::get('/', 'index');
    Route::get('/{tagihan}/coa', 'coa');
    Route::get('/{tagihan}/dokumen', 'dokumen');
    Route::get('/{kdSatker}', 'detail');
    Route::get('/{kdSatker}/{nomorSp2d}', 'rincian');
})->middleware('auth');