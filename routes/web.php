<?php

use App\Http\Controllers\BerkasController;
use App\Http\Controllers\BulanController;
use App\Http\Controllers\DnpController;
use App\Http\Controllers\DokumenController;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaguController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NominaldnpController;
use App\Http\Controllers\PphController;
use App\Http\Controllers\RealisasiController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\SatkerController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\TahunController;
use App\Http\Controllers\UnitController;

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

Route::get('/', function () {
    return view('welcome');
})->name('sign-in')->middleware('guest');

Route::resource('/user', UserController::class)->middleware('auth');

Route::controller(PaguController::class)->group(function(){
    Route::get('/pagu/import', 'import')->middleware('auth');
    Route::post('/pagu/import', 'import')->middleware('auth');
});

Route::resource('pagu', PaguController::class)->middleware('auth');

Route::resource('/satker', SatkerController::class)->middleware('auth');

Route::resource('/role', RoleController::class)->middleware('auth');

Route::resource('/role-user', RoleUserController::class)->middleware('auth')->except('create|destroy');

Route::controller(RoleUserController::class)->group(function(){
    Route::post('/role-user/{role}/{user}', 'create')->middleware('auth');
    Route::delete('/role-user/{role}/{user}', 'destroy')->middleware('auth');
});

Route::resource('/dokumen', DokumenController::class)->middleware('auth');

Route::resource('/tahun', TahunController::class)->middleware('auth');

Route::resource('/berkas', BerkasController::class)->middleware('auth');

Route::resource('/pph', PphController::class)->middleware('auth');

Route::resource('/bulan', BulanController::class)->middleware('auth');

Route::resource('/unit', UnitController::class)->middleware('auth');

Route::controller(TagihanController::class)->group(function(){
    Route::get('/tagihan/{tagihan}/upload', 'uploadindex')->middleware('auth');
    Route::get('/tagihan/{tagihan}/upload/create', 'upload')->middleware('auth');
    Route::patch('/tagihan/{tagihan}/upload', 'upload')->middleware('auth');
    Route::delete('/tagihan/{tagihan}/upload/{berkas}/delete', 'upload')->middleware('auth');
});

Route::resource('/tagihan', TagihanController::class)->middleware('auth');
Route::post('/tagihan/{tagihan}/kirim', [TagihanController::class,'kirim'])->middleware('auth');

Route::controller(RealisasiController::class)->group(function(){
    Route::get('/tagihan/{tagihan}/realisasi', 'index')->middleware('auth');
    Route::post('/tagihan/{tagihan}/realisasi/{pagu}', 'store')->middleware('auth');
});
Route::resource('/tagihan/realisasi', RealisasiController::class)->middleware('auth')->except('index|store');

Route::controller(DnpController::class)->group(function(){
    Route::get('/tagihan/{tagihan}/dnp/', 'index')->middleware('auth');
    Route::delete('/tagihan/{tagihan}/dnp/{dnp}', 'destroy')->middleware('auth');
    Route::get('/tagihan/{tagihan}/dnp/create', 'create')->middleware('auth');
    Route::post('/tagihan/{tagihan}/dnp/{nip}', 'store')->middleware('auth');
});

Route::resource('/tagihan/dnp', DnpController::class)->except('index|store|create')->middleware('auth');

Route::controller(NominaldnpController::class)->group(function(){
    Route::get('/tagihan/{tagihan}/dnp/{dnp}/nominal/', 'create')->middleware('auth');
    Route::get('/tagihan/{tagihan}/dnp/{dnp}/nominal/{nominaldnp}/update', 'edit')->middleware('auth');
    Route::post('/tagihan/{tagihan}/dnp/{dnp}/nominal/', 'store')->middleware('auth');
    Route::patch('/tagihan/{tagihan}/dnp/{dnp}/nominal/{nominaldnp}/update', 'update')->middleware('auth');
});

Route::get('/sign-in', function(){
    return view('sign-in');
})->middleware('guest');


Route::get('/dashboard', function(){
    return view('dashboard.index');
})->middleware('auth');

Route::get('/referensi', function(){
    if (! Gate::allows('sys_admin', auth()->user()->id) && ! Gate::allows('admin_satker', auth()->user()->id)) {
        abort(403);
    }
    return view('referensi.index');
})->middleware('auth');

Route::controller(LoginController::class)->group(function(){
    Route::post('/login', 'login')->middleware('guest');
    Route::post('/logout', 'logout')->middleware('auth');
});
