<?php

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DnpController;
use App\Http\Controllers\PphController;
use App\Http\Controllers\PaguController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\BulanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NomorController;
use App\Http\Controllers\PpspmController;
use App\Http\Controllers\TahunController;
use App\Http\Controllers\BerkasController;
use App\Http\Controllers\SatkerController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\BendaharaController;
use App\Http\Controllers\MapingppkController;
use App\Http\Controllers\RealisasiController;
use App\Http\Controllers\NominaldnpController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\PegawainondjknController;
use App\Http\Controllers\RegisterTagihanController;
use App\Http\Controllers\MonitoringTagihanController;

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

Route::get('/sign-in', function(){
    return view('sign-in');
})->middleware('guest');

Route::controller(LoginController::class)->group(function(){
    Route::post('/login', 'login')->middleware('guest');
    Route::post('/logout', 'logout')->middleware('auth');
});

Route::get('/dashboard', function(){
    return view('dashboard.index');
})->middleware('auth');

Route::get('/referensi', function(){
    if (! Gate::allows('sys_admin', auth()->user()->id) && ! Gate::allows('admin_satker', auth()->user()->id)) {
        abort(403);
    }
    return view('referensi.index');
})->middleware('auth');

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

Route::resource('/nomor', NomorController::class)->middleware('auth');

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
    Route::get('/tagihan/{tagihan}/dnp-non-djkn/create', 'create_non_djkn')->middleware('auth');
    Route::post('/tagihan/{tagihan}/dnp-non-djkn/{pegawainondjkn}', 'store_non_djkn')->middleware('auth');
    Route::get('/tagihan/{tagihan}/dnp/cetak', 'cetak')->middleware('auth');
});

Route::resource('/tagihan/dnp', DnpController::class)->except('index|store|create')->middleware('auth');

Route::controller(NominaldnpController::class)->group(function(){
    Route::get('/tagihan/{tagihan}/dnp/{dnp}/nominal/', 'create')->middleware('auth');
    Route::get('/tagihan/{tagihan}/dnp/{dnp}/nominal/{nominaldnp}/update', 'edit')->middleware('auth');
    Route::post('/tagihan/{tagihan}/dnp/{dnp}/nominal/', 'store')->middleware('auth');
    Route::patch('/tagihan/{tagihan}/dnp/{dnp}/nominal/{nominaldnp}/update', 'update')->middleware('auth');
});

Route::controller(RegisterController::class)->group(function(){
    Route::get('register/{register}/create', 'detailcreate')->middleware('auth');
    Route::get('register/{register}/preview', 'preview')->middleware('auth');
    Route::get('register/{register}/esign', 'esign')->middleware('auth');
    Route::post('register/{register}/esign', 'esign')->middleware('auth');
});

Route::resource('/register', RegisterController::class)->middleware('auth');

Route::controller(RegisterTagihanController::class)->group(function(){
    Route::post('/register/{register}/tagihan/{tagihan}','store')->middleware('auth');
    Route::delete('/register/{register}/tagihan/{tagihan}','destroy')->middleware('auth');
});

Route::resource('/monitoring-tagihan', MonitoringTagihanController::class)->middleware('auth');

Route::resource('/pegawai-nondjkn', PegawainondjknController::class)->middleware('auth');

Route::controller(VerifikasiController::class)->group(function(){
    Route::get('/verifikasi/{tagihan}/upload', 'upload')->middleware('auth');
    Route::patch('/verifikasi/{tagihan}/upload', 'upload')->middleware('auth');
    Route::delete('/verifikasi/{tagihan}/upload/{berkas}/delete', 'upload')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/tolak', 'tolak')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/approve', 'approve')->middleware('auth');
});

Route::resource('/verifikasi', VerifikasiController::class)->middleware('auth')->except('create');

Route::controller(PpspmController::class)->group(function(){
    Route::get('/ppspm/{tagihan}/upload', 'upload')->middleware('auth');
    Route::patch('/ppspm/{tagihan}/upload', 'upload')->middleware('auth');
    Route::delete('/ppspm/{tagihan}/upload/{berkas}/delete', 'upload')->middleware('auth');
    Route::get('/ppspm/{tagihan}/tolak', 'tolak')->middleware('auth');
    Route::get('/ppspm/{tagihan}/approve', 'approve')->middleware('auth');
});

Route::resource('/ppspm', PpspmController::class)->middleware('auth');

Route::controller(BendaharaController::class)->group(function(){
    Route::get('/bendahara/{tagihan}/sp2d', 'editsp2d')->middleware('auth');
    Route::patch('/bendahara/{tagihan}/sp2d', 'updatesp2d')->middleware('auth');
    Route::get('/bendahara/{tagihan}/payroll', 'payroll')->middleware('auth');
    Route::get('/bendahara/{tagihan}/payroll/cetak', 'cetakpayroll')->middleware('auth');
    Route::get('/bendahara/{tagihan}/dokumen', 'dokumen')->middleware('auth');
    Route::get('/bendahara/{tagihan}/upload', 'upload')->middleware('auth');
    Route::patch('/bendahara/{tagihan}/upload', 'upload')->middleware('auth');
    Route::delete('/bendahara/{tagihan}/upload/{berkas}/delete', 'upload')->middleware('auth');
    Route::get('/bendahara/{tagihan}/realisasi/{realisasi}/sspb', 'editsspb')->middleware('auth');
    Route::patch('/bendahara/{tagihan}/realisasi/{realisasi}/sspb', 'updatesspb')->middleware('auth');
    Route::get('/bendahara/{tagihan}/tolak', 'tolak')->middleware('auth');
    Route::get('/bendahara/{tagihan}/approve', 'approve')->middleware('auth');
});

Route::resource('/bendahara', BendaharaController::class)->middleware('auth');

Route::controller(ArsipController::class)->group(function(){
    Route::get('/arsip/{tagihan}/dokumen', 'dokumen')->middleware('auth');
    Route::get('/arsip/{tagihan}/coa', 'coa')->middleware('auth');
    Route::get('/arsip/{tagihan}/dnp', 'dnp')->middleware('auth');
    Route::get('/arsip/{tagihan}/tolak', 'tolak')->middleware('auth');
});

Route::resource('/arsip', ArsipController::class)->middleware('auth');

Route::controller(MapingppkController::class)->group(function(){
    Route::get('maping-ppk', 'index')->middleware('auth');
    Route::get('maping-ppk/{ppk}/pagu', 'showpagu')->middleware('auth');
    Route::get('maping-ppk/{ppk}/pagu/edit', 'editpagu')->middleware('auth');
    Route::post('maping-ppk/{ppk}/pagu/{pagu}', 'updatepagu')->middleware('auth');
    Route::delete('maping-ppk/{ppk}/pagu/{mapingppk}', 'destroypagu')->middleware('auth');
    Route::get('maping-ppk/{ppk}/staf', 'showstaf')->middleware('auth');
    Route::get('maping-ppk/{ppk}/staf/edit', 'editstaf')->middleware('auth');
    Route::post('maping-ppk/{ppk}/staf/{staf}', 'updatestaf')->middleware('auth');
    Route::delete('maping-ppk/{ppk}/staf/{mapingstafppk}', 'destroystaf')->middleware('auth');
});