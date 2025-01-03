<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PphController;
use App\Http\Controllers\SsoController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\PaguController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SP2DController;
use App\Http\Controllers\SspbController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\BulanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NomorController;
use App\Http\Controllers\PpspmController;
use App\Http\Controllers\TahunController;
use App\Http\Controllers\BerkasController;
use App\Http\Controllers\RefPpkController;
use App\Http\Controllers\SatkerController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\RekananController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\FileViewController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RekapSPMController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\BendaharaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MapingppkController;
use App\Http\Controllers\RealisasiController;
use App\Http\Controllers\ObjekpajakController;
use App\Http\Controllers\RefStafPpkController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\DnpPerjadinController;
use App\Http\Controllers\RefRekeningController;
use App\Http\Controllers\TagihanBLBIController;
use App\Http\Controllers\CleansingKkpController;
use App\Http\Controllers\CleansingSpmController;
use App\Http\Controllers\CleansingSppController;
use App\Http\Controllers\LaporanPajakController;
use App\Http\Controllers\RekapPayrollController;
use App\Http\Controllers\ArsipRegisterController;
use App\Http\Controllers\CleansingSpbyController;
use App\Http\Controllers\DnpHonorariumController;
use App\Http\Controllers\MapingstafppkController;
use App\Http\Controllers\RealisasiBLBIController;
use App\Http\Controllers\VerifikasiKKPController;
use App\Http\Controllers\PegawainondjknController;
use Workbench\App\Models\Opengraph\OpengraphEmbed;
use App\Http\Controllers\RegisterTagihanController;
use App\Http\Controllers\CleansingDuplikatController;
use App\Http\Controllers\CleansingTagihanController;
use App\Http\Controllers\RealisasiBulananController;
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
Route::get('/api/sso', [SsoController::class, 'sign_in']);

Route::get('/', function () {
    return view('welcome');
})->name('sign-in')->middleware('guest');

Route::get('/login', function () {
    return redirect('/')->with('gagal','LoginFailed');
});

Route::get('/sso', [SsoController::class, 'sso']);

Route::get('/sign-in', function(){
    return view('sign-in');
})->middleware('guest');

Route::controller(LoginController::class)->group(function(){
    Route::post('/login', 'login')->middleware('guest');
    Route::post('/logout', 'logout')->middleware('auth');
});

Route::controller(DashboardController::class)->group(function(){
    Route::get('/dashboard', 'index')->middleware('auth');
    Route::get('/dashboard/unit', 'unit_index')->middleware('auth');
    Route::get('/dashboard/unit/{unit}', 'unit_detail')->middleware('auth');
    Route::get('/dashboard/unit/{unit}/{bulan}', 'unit_detail_bulan')->middleware('auth');
    Route::get('/dashboard/unit/{unit}/{bulan}/tagihan', 'unit_detail_tagihan')->middleware('auth');
    Route::get('/dashboard/ppk', 'ppk_index')->middleware('auth');
    Route::get('/dashboard/ppk/{ppk}', 'ppk_detail')->middleware('auth');
    Route::get('/dashboard/ppk/{ppk}/{bulan}', 'ppk_detail_bulan')->middleware('auth');
    Route::get('/dashboard/ppk/{ppk}/{bulan}/tagihan', 'ppk_detail_tagihan')->middleware('auth');
});

Route::get('/referensi', function(){
    if (! Gate::any(['sys_admin', 'admin_satker', 'KPA', 'Staf_KPA', 'PPK', 'Staf_PPK'], auth()->user()->id)) {
        abort(403);
    }
    return view('referensi.index');
})->middleware('auth');

Route::resource('/user', UserController::class)->middleware('auth');

Route::controller(PaguController::class)->group(function(){
    Route::get('/pagu/import', 'import')->middleware('auth');
    Route::get('/pagu/template', 'template')->middleware('auth');
    Route::post('/pagu/import', 'import')->middleware('auth');
    Route::get('/pagu/cetak', 'cetak')->middleware('auth');
    Route::get('/pagu/mass-update', 'massUpdate')->middleware('auth');
    Route::post('/pagu/mass-update', 'storeMassUpdate')->middleware('auth');
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

Route::controller(UnitController::class)->group(function(){
    Route::get('/unit/{unit}/verifikator', 'showverifikator')->middleware('auth');
    Route::get('/unit/{unit}/verifikator/create', 'editverifikator')->middleware('auth');
    Route::post('/unit/{unit}/{verifikator}', 'updateverifikator')->middleware('auth');
    Route::delete('/unit/{unit}/{verifikator}', 'destroyverifikator')->middleware('auth');

    Route::get('/unit/{unit}/pagu', 'showpagu')->middleware('auth');
    Route::get('/unit/{unit}/pagu/edit', 'editpagu')->middleware('auth');
    Route::post('/unit/{unit}/pagu/{pagu}', 'updatepagu')->middleware('auth');
    Route::delete('/unit/{unit}/pagu/{pagu}', 'destroypagu')->middleware('auth');
});

Route::resource('/unit', UnitController::class)->middleware('auth');

Route::resource('/nomor', NomorController::class)->middleware('auth');

Route::controller(TagihanController::class)->group(function(){
    Route::get('/tagihan/{tagihan}/upload', 'uploadindex')->middleware('auth');
    Route::get('/tagihan/{tagihan}/upload/create', 'upload')->middleware('auth');
    Route::patch('/tagihan/{tagihan}/upload', 'upload')->middleware('auth');
    Route::delete('/tagihan/{tagihan}/upload/{berkas}/delete', 'upload')->middleware('auth');
    Route::get('/tagihan/{tagihan}/rekanan', 'showrekanan')->middleware('auth');
    Route::get('/tagihan/{tagihan}/rekanan/create', 'createrekanan')->middleware('auth');
    Route::post('/tagihan/{tagihan}/rekanan/{rekanan}', 'storerekanan')->middleware('auth');
    Route::delete('/tagihan/{tagihan}/rekanan/{rekanan}', 'deleterekanan')->middleware('auth');
    Route::get('/tagihan/{tagihan}/rekanan/{rekanan}/ppn', 'showppnrekanan')->middleware('auth');
    Route::get('/tagihan/{tagihan}/rekanan/{rekanan}/ppn/create', 'createppnrekanan')->middleware('auth');
    Route::post('/tagihan/{tagihan}/rekanan/{rekanan}/ppn', 'storeppnrekanan')->middleware('auth');
    Route::get('/tagihan/{tagihan}/rekanan/{rekanan}/ppn/{ppn}/edit', 'editppnrekanan')->middleware('auth');
    Route::patch('/tagihan/{tagihan}/rekanan/{rekanan}/ppn/{ppn}', 'updateppnrekanan')->middleware('auth');
    Route::delete('/tagihan/{tagihan}/rekanan/{rekanan}/ppn/{ppn}', 'deleteppnrekanan')->middleware('auth');
    Route::get('/tagihan/{tagihan}/rekanan/{rekanan}/pph', 'showpphrekanan')->middleware('auth');
    Route::get('/tagihan/{tagihan}/rekanan/{rekanan}/pph/create', 'createpphrekanan')->middleware('auth');
    Route::post('/tagihan/{tagihan}/rekanan/{rekanan}/pph', 'storepphrekanan')->middleware('auth');
    Route::get('/tagihan/{tagihan}/rekanan/{rekanan}/pph/{pph}/edit', 'editpphrekanan')->middleware('auth');
    Route::patch('/tagihan/{tagihan}/rekanan/{rekanan}/pph/{pph}', 'updatepphrekanan')->middleware('auth');
    Route::delete('/tagihan/{tagihan}/rekanan/{rekanan}/pph/{pph}', 'deletepphrekanan')->middleware('auth');
    Route::get('/tagihan/{tagihan}/payroll', 'payroll')->middleware('auth');
    Route::get('/tagihan/{tagihan}/payroll/create', 'createPayroll')->middleware('auth');
    Route::post('/tagihan/{tagihan}/payroll/create', 'storePayroll')->middleware('auth');
    Route::get('/tagihan/{tagihan}/payroll/import-hris', 'importHrisPayroll')->middleware('auth');
    Route::get('/tagihan/{tagihan}/payroll/import-monev', 'importMonevPayroll')->middleware('auth');
    Route::get('/tagihan/{tagihan}/payroll/import-excel', 'importExcelPayroll')->middleware('auth');
    Route::post('/tagihan/{tagihan}/payroll/import-excel', 'storeExcelPayroll')->middleware('auth');
    Route::get('/tagihan/{tagihan}/payroll/{payroll}/edit', 'editPayroll')->middleware('auth');
    Route::patch('/tagihan/{tagihan}/payroll/{payroll}/edit', 'updatePayroll')->middleware('auth');
    Route::get('/tagihan/payroll/excel/template', 'templateExcelPayroll')->middleware('auth');
    Route::post('/tagihan/{tagihan}/payroll/import', 'storeImportPayroll')->middleware('auth');
    Route::delete('/tagihan/{tagihan}/payroll/{payroll}', 'deletePayroll')->middleware('auth');
    Route::get('/tagihan/{tagihan}/payroll/cetak', 'cetakPayroll')->middleware('auth');
    Route::patch('/tagihan/{tagihan}/kirim', 'kirim')->middleware('auth');
});

Route::resource('/tagihan', TagihanController::class)->middleware('auth');

Route::controller(RealisasiController::class)->group(function(){
    Route::get('/tagihan/{tagihan}/realisasi', 'index')->middleware('auth');
    Route::post('/tagihan/{tagihan}/realisasi/{pagu}', 'store')->middleware('auth');
});
Route::resource('/tagihan/realisasi', RealisasiController::class)->middleware('auth')->except('index|store');

// Route::controller(DnpController::class)->group(function(){
//     Route::get('/tagihan/{tagihan}/dnp/', 'index')->middleware('auth');
//     Route::delete('/tagihan/{tagihan}/dnp/{dnp}', 'destroy')->middleware('auth');
//     Route::get('/tagihan/{tagihan}/dnp/create', 'create')->middleware('auth');
//     Route::post('/tagihan/{tagihan}/dnp/{nip}', 'store')->middleware('auth');
//     Route::get('/tagihan/{tagihan}/dnp-non-djkn/create', 'create_non_djkn')->middleware('auth');
//     Route::post('/tagihan/{tagihan}/dnp-non-djkn/{pegawainondjkn}', 'store_non_djkn')->middleware('auth');
//     Route::get('/tagihan/{tagihan}/dnp/cetak', 'cetak')->middleware('auth');
// });

// Route::resource('/tagihan/dnp', DnpController::class)->except('index|store|create')->middleware('auth');

// Route::controller(NominaldnpController::class)->group(function(){
//     Route::get('/tagihan/{tagihan}/dnp/{dnp}/nominal/', 'create')->middleware('auth');
//     Route::get('/tagihan/{tagihan}/dnp/{dnp}/nominal/{nominaldnp}/update', 'edit')->middleware('auth');
//     Route::post('/tagihan/{tagihan}/dnp/{dnp}/nominal/', 'store')->middleware('auth');
//     Route::patch('/tagihan/{tagihan}/dnp/{dnp}/nominal/{nominaldnp}/update', 'update')->middleware('auth');
// });

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

Route::controller(MonitoringTagihanController::class)->group(function(){
    Route::get('/monitoring-tagihan/download', 'cetakRekapTagihan')->middleware('auth')->name('monitoring-tagihan.download');
    Route::get('/monitoring-tagihan/{tagihan}/coa', 'showcoa')->middleware('auth');
    Route::patch('/monitoring-tagihan/{tagihan}/download-all', 'downloadAll')->middleware('auth');
    // Route::get('/monitoring-tagihan/{tagihan}/dnp', 'showdnp')->middleware('auth');
    Route::get('/monitoring-tagihan/{tagihan}/tolak', 'tolak')->middleware('auth');
    Route::get('/monitoring-tagihan/{tagihan}/rekanan', 'showrekanan')->middleware('auth');
    Route::get('/monitoring-tagihan/{tagihan}/rekanan/{rekanan}/pph', 'showpphrekanan')->middleware('auth');
    Route::get('/monitoring-tagihan/{tagihan}/rekanan/{rekanan}/ppn', 'showppnrekanan')->middleware('auth');

    Route::get('/monitoring-tagihan/{tagihan}/payroll', 'payroll')->middleware('auth');
    Route::get('/monitoring-tagihan/{tagihan}/payroll/cetak', 'cetakPayroll')->middleware('auth');

    Route::get('/monitoring-tagihan/{tagihan}/dnp-honorarium', 'dnpHonorarium')->middleware('auth');
    Route::get('/monitoring-tagihan/{tagihan}/dnp-honorarium/cetak', 'cetakDnpHonorarium')->middleware('auth');

    Route::get('/monitoring-tagihan/{tagihan}/dnp-perjadin', 'dnpPerjadin')->middleware('auth');
    Route::get('/monitoring-tagihan/{tagihan}/dnp-perjadin/cetak', 'cetakDnpPerjadin')->middleware('auth');
    Route::get('/monitoring-tagihan/{tagihan}/dnp-perjadin/{dnp}', 'detailDnpPerjadin')->middleware('auth');
    Route::get('/monitoring-tagihan/{tagihan}/dnp-perjadin/{dnp}/cetak', 'cetakKuitansiPerjadin')->middleware('auth');


});

Route::resource('/monitoring-tagihan', MonitoringTagihanController::class)->middleware('auth');

// Route::resource('/pegawai-nondjkn', PegawainondjknController::class)->middleware('auth');

Route::controller(VerifikasiController::class)->group(function(){
    Route::get('/verifikasi/{tagihan}/upload', 'upload')->middleware('auth');
    Route::patch('/verifikasi/{tagihan}/upload', 'upload')->middleware('auth');
    Route::delete('/verifikasi/{tagihan}/upload/{berkas}/delete', 'upload')->middleware('auth');
    Route::patch('/verifikasi/{tagihan}/tolak', 'tolak')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/approve', 'approve')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/rekanan', 'showrekanan')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/rekanan/create', 'createrekanan')->middleware('auth');
    Route::post('/verifikasi/{tagihan}/rekanan/{rekanan}', 'storerekanan')->middleware('auth');
    Route::delete('/verifikasi/{tagihan}/rekanan/{rekanan}', 'deleterekanan')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/rekanan/{rekanan}/ppn', 'showppnrekanan')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/rekanan/{rekanan}/ppn/create', 'createppnrekanan')->middleware('auth');
    Route::post('/verifikasi/{tagihan}/rekanan/{rekanan}/ppn', 'storeppnrekanan')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/rekanan/{rekanan}/ppn/{ppn}/edit', 'editppnrekanan')->middleware('auth');
    Route::patch('/verifikasi/{tagihan}/rekanan/{rekanan}/ppn/{ppn}', 'updateppnrekanan')->middleware('auth');
    Route::delete('/verifikasi/{tagihan}/rekanan/{rekanan}/ppn/{ppn}', 'deleteppnrekanan')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/rekanan/{rekanan}/pph', 'showpphrekanan')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/rekanan/{rekanan}/pph/create', 'createpphrekanan')->middleware('auth');
    Route::post('/verifikasi/{tagihan}/rekanan/{rekanan}/pph', 'storepphrekanan')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/rekanan/{rekanan}/pph/{pph}/edit', 'editpphrekanan')->middleware('auth');
    Route::patch('/verifikasi/{tagihan}/rekanan/{rekanan}/pph/{pph}', 'updatepphrekanan')->middleware('auth');
    Route::delete('/verifikasi/{tagihan}/rekanan/{rekanan}/pph/{pph}', 'deletepphrekanan')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/coa', 'coa')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/coa/create', 'createCoa')->middleware('auth');
    Route::post('/verifikasi/{tagihan}/coa/{pagu}', 'storeCoa')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/coa/{coa}/edit', 'editCoa')->middleware('auth');
    Route::patch('/verifikasi/{tagihan}/coa/{coa}/edit', 'updateCoa')->middleware('auth');
    Route::delete('/verifikasi/{tagihan}/coa/{coa}', 'destroyCoa')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/payroll', 'payroll')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/payroll/create', 'createPayroll')->middleware('auth');
    Route::post('/verifikasi/{tagihan}/payroll/create', 'storePayroll')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/payroll/{payroll}/edit', 'editPayroll')->middleware('auth');
    Route::patch('/verifikasi/{tagihan}/payroll/{payroll}/edit', 'updatePayroll')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/payroll/import-hris', 'importHrisPayroll')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/payroll/import-monev', 'importMonevPayroll')->middleware('auth');
    Route::post('/verifikasi/{tagihan}/payroll/import', 'storeImportPayroll')->middleware('auth');
    Route::delete('/verifikasi/{tagihan}/payroll/{payroll}', 'deletePayroll')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/payroll/cetak', 'cetakPayroll')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/payroll/import-excel', 'importExcelPayroll')->middleware('auth');
    Route::post('/verifikasi/{tagihan}/payroll/import-excel', 'storeExcelPayroll')->middleware('auth');
    Route::get('/verifikasi/payroll/excel/template', 'templateExcelPayroll')->middleware('auth');
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
    Route::delete('/bendahara/{tagihan}/sp2d', 'deletesp2d')->middleware('auth');
    Route::get('/bendahara/{tagihan}/payroll', 'payroll')->middleware('auth');
    Route::get('/bendahara/{tagihan}/payroll/cetak', 'cetakpayroll')->middleware('auth');
    Route::get('/bendahara/{tagihan}/dokumen', 'dokumen')->middleware('auth');
    Route::get('/bendahara/{tagihan}/upload', 'upload')->middleware('auth');
    Route::patch('/bendahara/{tagihan}/upload', 'upload')->middleware('auth');
    Route::delete('/bendahara/{tagihan}/upload/{berkas}/delete', 'upload')->middleware('auth');
    Route::get('/bendahara/{tagihan}/realisasi/{realisasi}/sspb', 'sspb')->middleware('auth');
    Route::get('/bendahara/{tagihan}/realisasi/{realisasi}/sspb/create', 'createsspb')->middleware('auth');
    Route::post('/bendahara/{tagihan}/realisasi/{realisasi}/sspb/create', 'storesspb')->middleware('auth');
    Route::get('/bendahara/{tagihan}/realisasi/{realisasi}/sspb/{sspb}', 'editsspb')->middleware('auth');
    Route::patch('/bendahara/{tagihan}/realisasi/{realisasi}/sspb/{sspb}', 'updatesspb')->middleware('auth');
    Route::delete('/bendahara/{tagihan}/realisasi/{realisasi}/sspb/{sspb}', 'deletesspb')->middleware('auth');
    Route::get('/bendahara/{tagihan}/tolak', 'tolak')->middleware('auth');
    Route::get('/bendahara/{tagihan}/approve', 'approve')->middleware('auth');
    Route::get('/bendahara/{tagihan}/rekanan', 'showrekanan')->middleware('auth');
    Route::get('/bendahara/{tagihan}/rekanan/create', 'createrekanan')->middleware('auth');
    Route::post('/bendahara/{tagihan}/rekanan/{rekanan}', 'storerekanan')->middleware('auth');
    Route::delete('/bendahara/{tagihan}/rekanan/{rekanan}', 'deleterekanan')->middleware('auth');
    Route::get('/bendahara/{tagihan}/rekanan/{rekanan}/ppn', 'showppnrekanan')->middleware('auth');
    Route::get('/bendahara/{tagihan}/rekanan/{rekanan}/ppn/create', 'createppnrekanan')->middleware('auth');
    Route::post('/bendahara/{tagihan}/rekanan/{rekanan}/ppn', 'storeppnrekanan')->middleware('auth');
    Route::get('/bendahara/{tagihan}/rekanan/{rekanan}/ppn/{ppn}/edit', 'editppnrekanan')->middleware('auth');
    Route::patch('/bendahara/{tagihan}/rekanan/{rekanan}/ppn/{ppn}', 'updateppnrekanan')->middleware('auth');
    Route::delete('/bendahara/{tagihan}/rekanan/{rekanan}/ppn/{ppn}', 'deleteppnrekanan')->middleware('auth');
    Route::get('/bendahara/{tagihan}/rekanan/{rekanan}/pph', 'showpphrekanan')->middleware('auth');
    Route::get('/bendahara/{tagihan}/rekanan/{rekanan}/pph/create', 'createpphrekanan')->middleware('auth');
    Route::post('/bendahara/{tagihan}/rekanan/{rekanan}/pph', 'storepphrekanan')->middleware('auth');
    Route::get('/bendahara/{tagihan}/rekanan/{rekanan}/pph/{pph}/edit', 'editpphrekanan')->middleware('auth');
    Route::patch('/bendahara/{tagihan}/rekanan/{rekanan}/pph/{pph}', 'updatepphrekanan')->middleware('auth');
    Route::delete('/bendahara/{tagihan}/rekanan/{rekanan}/pph/{pph}', 'deletepphrekanan')->middleware('auth');
    Route::get('/bendahara/{tagihan}/payroll', 'payroll')->middleware('auth');
    Route::get('/bendahara/{tagihan}/payroll/create', 'createPayroll')->middleware('auth');
    Route::post('/bendahara/{tagihan}/payroll/create', 'storePayroll')->middleware('auth');
    Route::get('/bendahara/{tagihan}/payroll/import-hris', 'importHrisPayroll')->middleware('auth');
    Route::get('/bendahara/{tagihan}/payroll/import-monev', 'importMonevPayroll')->middleware('auth');
    Route::post('/bendahara/{tagihan}/payroll/import', 'storeImportPayroll')->middleware('auth');
    Route::delete('/bendahara/{tagihan}/payroll/{payroll}', 'deletePayroll')->middleware('auth');
    Route::get('/bendahara/{tagihan}/payroll/cetak', 'cetakPayroll')->middleware('auth');
    Route::get('/bendahara/{tagihan}/coa/create', 'createCoa')->middleware('auth');
    Route::post('/bendahara/{tagihan}/coa/{pagu}', 'storeCoa')->middleware('auth');
    Route::get('/bendahara/{tagihan}/coa/{coa}/edit', 'editCoa')->middleware('auth');
    Route::patch('/bendahara/{tagihan}/coa/{coa}/edit', 'updateCoa')->middleware('auth');
    Route::delete('/bendahara/{tagihan}/coa/{coa}', 'destroyCoa')->middleware('auth');
});

Route::resource('/bendahara', BendaharaController::class)->middleware('auth');

Route::controller(ArsipController::class)->group(function(){
    Route::get('/arsip/{tagihan}/dokumen', 'dokumen')->middleware('auth');
    Route::patch('/arsip/{tagihan}/download-all', 'downloadAll')->middleware('auth');
    Route::get('/arsip/download', 'cetakRekapTagihan')->middleware('auth')->name('arsip-tagihan.download');
    Route::get('/arsip/{tagihan}/coa', 'coa')->middleware('auth');
    // Route::get('/arsip/{tagihan}/dnp', 'dnp')->middleware('auth');
    Route::get('/arsip/{tagihan}/riwayat', 'showriwayat')->middleware('auth');
    Route::get('/arsip/{tagihan}/tolak', 'tolak')->middleware('auth');
    Route::get('/arsip/{tagihan}/rekanan', 'showrekanan')->middleware('auth');
    Route::get('/arsip/{tagihan}/rekanan/{rekanan}/ppn', 'showppnrekanan')->middleware('auth');
    Route::get('/arsip/{tagihan}/rekanan/{rekanan}/pph', 'showpphrekanan')->middleware('auth');

    Route::get('/arsip/{tagihan}/payroll', 'payroll')->middleware('auth');
    Route::get('/arsip/{tagihan}/payroll/cetak', 'cetakPayroll')->middleware('auth');

    Route::get('/arsip/{tagihan}/dnp-honorarium', 'dnpHonorarium')->middleware('auth');
    Route::get('/arsip/{tagihan}/dnp-honorarium/cetak', 'cetakDnpHonorarium')->middleware('auth');

    Route::get('/arsip/{tagihan}/dnp-perjadin', 'dnpPerjadin')->middleware('auth');
    Route::get('/arsip/{tagihan}/dnp-perjadin/cetak', 'cetakDnpPerjadin')->middleware('auth');
    Route::get('/arsip/{tagihan}/dnp-perjadin/{dnp}', 'detailDnpPerjadin')->middleware('auth');
    Route::get('/arsip/{tagihan}/dnp-perjadin/{dnp}/cetak', 'cetakKuitansiPerjadin')->middleware('auth');
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

Route::controller(MapingstafppkController::class)->group(function(){
    Route::get('maping-staf-ppk', 'index')->middleware('auth');
    Route::get('maping-staf-ppk/{stafppk}/unit', 'showunit')->middleware('auth');
    Route::get('maping-staf-ppk/{stafppk}/unit/edit', 'editunit')->middleware('auth');
    Route::get('maping-staf-ppk/{stafppk}/unit/{unit}', 'updateunit')->middleware('auth');
    Route::delete('maping-staf-ppk/{stafppk}/unit/{unit}', 'destroyunit')->middleware('auth');
    Route::get('maping-staf-ppk/{stafppk}/ppk', 'showppk')->middleware('auth');
    Route::get('maping-staf-ppk/{stafppk}/ppk/edit', 'editppk')->middleware('auth');
    Route::get('maping-staf-ppk/{stafppk}/ppk/{ppk}', 'updateppk')->middleware('auth');
    Route::delete('maping-staf-ppk/{stafppk}/ppk/{ppk}', 'destroyppk')->middleware('auth');
});

Route::controller(SessionController::class)->group(function(){
    Route::get('session/tahun-anggaran', 'tahun_anggaran')->middleware('auth');
    Route::post('session/tahun-anggaran', 'tahun_anggaran')->middleware('auth');
});

Route::resource('/rekanan',RekananController::class);

Route::resource('/referensi/objek-pajak', ObjekpajakController::class)->middleware('auth');

Route::controller(LaporanPajakController::class)->group(function(){
    Route::get('/laporan-pajak', 'index')->middleware('auth');
    Route::get('/laporan-pajak/pph', 'showpph')->middleware('auth');
    Route::get('/laporan-pajak/pph/cetak', 'cetakpph')->middleware('auth');
    Route::get('/laporan-pajak/ppn', 'showppn')->middleware('auth');
    Route::get('/laporan-pajak/ppn/cetak', 'cetakppn')->middleware('auth');
});

Route::get('/file-view/{path}/{file}', [FileViewController::class, 'view'])->middleware('auth');

Route::controller(ArsipRegisterController::class)->group(function(){
    Route::get('/arsip-register', 'index')->middleware('auth');
});

Route::controller(RefRekeningController::class)->group(function(){
    Route::get('referensi-rekening', 'index')->middleware('auth');
    Route::get('referensi-rekening/create', 'create')->middleware('auth');
    Route::post('referensi-rekening/create', 'store')->middleware('auth');
    Route::get('referensi-rekening/{rekening}/edit', 'edit')->middleware('auth');
    Route::patch('referensi-rekening/{rekening}/edit', 'update')->middleware('auth');
    Route::delete('referensi-rekening/{rekening}', 'destroy')->middleware('auth');
});

Route::controller(PayrollController::class)->group(function(){
    Route::get('/payroll', 'index')->middleware('auth');
    Route::get('/payroll/{tagihan}', 'show')->middleware('auth')->middleware('auth');
    Route::get('/payroll/{tagihan}/cetak', 'cetak')->middleware('auth')->middleware('auth');
    Route::get('/payroll/{tagihan}/dokumen', 'dokumen')->middleware('auth')->middleware('auth');
    Route::get('/payroll/{tagihan}/approve', 'approve')->middleware('auth')->middleware('auth');
    Route::get('/payroll/{tagihan}/upload', 'upload')->middleware('auth')->middleware('auth');
    Route::patch('/payroll/{tagihan}/upload', 'upload')->middleware('auth')->middleware('auth');
    Route::delete('/payroll/{tagihan}/upload/{berkas}/delete', 'upload')->middleware('auth')->middleware('auth');
});

// Route::controller(SP2DController::class)->group(function(){
//     Route::get('/cleansing/sp2d', 'index')->middleware('auth');
//     Route::delete('/cleansing/sp2d/{spm}', 'delete')->middleware('auth');
// });

Route::controller(CleansingSpbyController::class)->group(function(){
    Route::get('/cleansing/spby', 'index')->middleware('auth');
    Route::get('/cleansing/spby/download', 'download')->middleware('auth');
    Route::get('/cleansing/spby/import', 'import')->middleware('auth');
    Route::post('/cleansing/spby/import', 'store')->middleware('auth');

});

Route::controller(CleansingSppController::class)->group(function(){
    Route::get('/cleansing/spp', 'index')->middleware('auth');
    Route::get('/cleansing/spp/download', 'download')->middleware('auth');
    Route::get('/cleansing/spp/import', 'import')->middleware('auth');
    Route::post('/cleansing/spp/import', 'store')->middleware('auth');
});

Route::controller(CleansingKkpController::class)->group(function(){
    Route::get('/cleansing/kkp', 'index')->middleware('auth');
    Route::get('/cleansing/kkp/download', 'download')->middleware('auth');
    Route::get('/cleansing/kkp/import', 'import')->middleware('auth');
    Route::post('/cleansing/kkp/import', 'store')->middleware('auth');
});

Route::controller(CleansingDuplikatController::class)->group(function(){
    Route::get('/cleansing/duplikat', 'index')->middleware('auth');
    Route::get('/cleansing/duplikat/{jns}/{nomor}', 'detail')->middleware('auth');
});

Route::controller(CleansingSpmController::class)->group(function(){
    Route::get('/cleansing/spm', 'index')->middleware('auth');
    Route::patch('/cleansing/spm/load', 'load')->middleware('auth');
    Route::get('/cleansing/spm/import', 'import')->middleware('auth');
    Route::post('/cleansing/spm/import', 'importStore')->middleware('auth');
    Route::get('/cleansing/spm/{spm}/edit', 'edit')->middleware('auth');
    Route::patch('/cleansing/spm/{spm}', 'update')->middleware('auth');
    Route::get('/cleansing/spm/{spm}/detail', 'detail')->middleware('auth');
    Route::delete('/cleansing/spm/{spm}/tagihan/{tagihan}/delete', 'detachSPM')->middleware('auth');
});

Route::controller(RefPpkController::class)->group(function(){
    Route::get('ref-ppk', 'index')->middleware('auth');
    Route::get('ref-ppk/create', 'create')->middleware('auth');
    Route::post('ref-ppk/create', 'store')->middleware('auth');
    Route::get('ref-ppk/{ppk}/edit', 'edit')->middleware('auth');
    Route::patch('ref-ppk/{ppk}/edit', 'update')->middleware('auth');
    Route::delete('ref-ppk/{ppk}', 'destroy')->middleware('auth');
});

Route::controller(VerifikasiKKPController::class)->group(function(){
    Route::get('/verifikasi-kkp/{tagihan}/upload', 'upload')->middleware('auth');
    Route::patch('/verifikasi-kkp/{tagihan}/upload', 'upload')->middleware('auth');
    Route::delete('/verifikasi-kkp/{tagihan}/upload/{berkas}/delete', 'upload')->middleware('auth');
    Route::patch('/verifikasi-kkp/{tagihan}/tolak', 'tolak')->middleware('auth');
    Route::get('/verifikasi-kkp/{tagihan}/approve', 'approve')->middleware('auth');
    Route::get('/verifikasi-kkp/{tagihan}/coa', 'coa')->middleware('auth');
});

Route::resource('/verifikasi-kkp', VerifikasiKKPController::class)->middleware('auth')->except('create');

Route::controller(RefStafPpkController::class)->group(function(){
    Route::get('ref-staf-ppk', 'index')->middleware('auth');
    Route::get('ref-staf-ppk/create', 'create')->middleware('auth');
    Route::post('ref-staf-ppk/create', 'store')->middleware('auth');
    Route::get('ref-staf-ppk/{stafppk}/edit', 'edit')->middleware('auth');
    Route::patch('ref-staf-ppk/{stafppk}/edit', 'update')->middleware('auth');
    Route::delete('ref-staf-ppk/{stafppk}', 'destroy')->middleware('auth');
});

Route::controller(RealisasiBulananController::class)->group(function(){
   Route::get('cleansing/realisasi-bulanan', 'index')->middleware('auth');
   Route::get('cleansing/realisasi-bulanan/{bulan}', 'index')->middleware('auth');
   Route::get('cleansing/realisasi-bulanan/{bulan}/download', 'download')->middleware('auth');
   Route::get('cleansing/realisasi-bulanan/{bulan}/download-with-sum', 'downloadWithSum')->middleware('auth');
});

Route::controller(TagihanBLBIController::class)->group(function(){
    Route::get('/tagihan-blbi', 'index')->middleware('auth');
    Route::post('/tagihan-blbi', 'store')->middleware('auth');
    Route::get('/tagihan-blbi/create', 'create')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/edit', 'edit')->middleware('auth');
    Route::patch('/tagihan-blbi/{tagihan}/edit', 'update')->middleware('auth');
    Route::delete('/tagihan-blbi/{tagihan}', 'destroy')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/upload', 'uploadindex')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/upload/create', 'upload')->middleware('auth');
    Route::patch('/tagihan-blbi/{tagihan}/upload', 'upload')->middleware('auth');
    Route::delete('/tagihan-blbi/{tagihan}/upload/{berkas}/delete', 'upload')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/rekanan', 'showrekanan')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/rekanan/create', 'createrekanan')->middleware('auth');
    Route::post('/tagihan-blbi/{tagihan}/rekanan/{rekanan}', 'storerekanan')->middleware('auth');
    Route::delete('/tagihan-blbi/{tagihan}/rekanan/{rekanan}', 'deleterekanan')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/rekanan/{rekanan}/ppn', 'showppnrekanan')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/rekanan/{rekanan}/ppn/create', 'createppnrekanan')->middleware('auth');
    Route::post('/tagihan-blbi/{tagihan}/rekanan/{rekanan}/ppn', 'storeppnrekanan')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/rekanan/{rekanan}/ppn/{ppn}/edit', 'editppnrekanan')->middleware('auth');
    Route::patch('/tagihan-blbi/{tagihan}/rekanan/{rekanan}/ppn/{ppn}', 'updateppnrekanan')->middleware('auth');
    Route::delete('/tagihan-blbi/{tagihan}/rekanan/{rekanan}/ppn/{ppn}', 'deleteppnrekanan')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/rekanan/{rekanan}/pph', 'showpphrekanan')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/rekanan/{rekanan}/pph/create', 'createpphrekanan')->middleware('auth');
    Route::post('/tagihan-blbi/{tagihan}/rekanan/{rekanan}/pph', 'storepphrekanan')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/rekanan/{rekanan}/pph/{pph}/edit', 'editpphrekanan')->middleware('auth');
    Route::patch('/tagihan-blbi/{tagihan}/rekanan/{rekanan}/pph/{pph}', 'updatepphrekanan')->middleware('auth');
    Route::delete('/tagihan-blbi/{tagihan}/rekanan/{rekanan}/pph/{pph}', 'deletepphrekanan')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/payroll', 'payroll')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/payroll/create', 'createPayroll')->middleware('auth');
    Route::post('/tagihan-blbi/{tagihan}/payroll/create', 'storePayroll')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/payroll/import-hris', 'importHrisPayroll')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/payroll/import-monev', 'importMonevPayroll')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/payroll/import-excel', 'importExcelPayroll')->middleware('auth');
    Route::post('/tagihan-blbi/{tagihan}/payroll/import-excel', 'storeExcelPayroll')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/payroll/{payroll}/edit', 'editPayroll')->middleware('auth');
    Route::patch('/tagihan-blbi/{tagihan}/payroll/{payroll}/edit', 'updatePayroll')->middleware('auth');
    Route::get('/tagihan-blbi/payroll/excel/template', 'templateExcelPayroll')->middleware('auth');
    Route::post('/tagihan-blbi/{tagihan}/payroll/import', 'storeImportPayroll')->middleware('auth');
    Route::delete('/tagihan-blbi/{tagihan}/payroll/{payroll}', 'deletePayroll')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/payroll/cetak', 'cetakPayroll')->middleware('auth');
    Route::patch('/tagihan-blbi/{tagihan}/kirim', 'kirim')->middleware('auth');
});

Route::resource('/tagihan-blbi', TagihanBLBIController::class)->middleware('auth');

Route::controller(RealisasiBLBIController::class)->group(function(){
    Route::get('/tagihan-blbi/{tagihan}/realisasi', 'index')->middleware('auth');
    Route::post('/tagihan-blbi/{tagihan}/realisasi/{pagu}', 'store')->middleware('auth');
});

Route::resource('/tagihan-blbi/realisasi', RealisasiBLBIController::class)->middleware('auth')->except('index|store');

Route::controller(DnpPerjadinController::class)->group(function(){
    Route::get('/tagihan/{tagihan}/dnp-perjadin', 'dnpPerjadin')->middleware('auth');
    Route::get('/tagihan/{tagihan}/dnp-perjadin/create', 'dnpPerjadinCreate')->middleware('auth');
    Route::post('/tagihan/{tagihan}/dnp-perjadin/create', 'dnpPerjadinStore')->middleware('auth');
    Route::get('/tagihan/{tagihan}/dnp-perjadin/import', 'import')->middleware('auth');
    Route::post('/tagihan/{tagihan}/dnp-perjadin/import', 'importStore')->middleware('auth');
    Route::get('/tagihan/{tagihan}/dnp-perjadin/cetak', 'cetak')->middleware('auth');
    Route::get('/tagihan/{tagihan}/dnp-perjadin/create-payroll', 'createPayroll')->middleware('auth');
    Route::get('/tagihan/{tagihan}/dnp-perjadin/{dnp}', 'index')->middleware('auth');
    Route::patch('/tagihan/{tagihan}/dnp-perjadin/{dnp}', 'updateDetail')->middleware('auth');
    Route::delete('/tagihan/{tagihan}/dnp-perjadin/{dnp}', 'destroy')->middleware('auth');
    Route::get('/tagihan/{tagihan}/dnp-perjadin/{dnp}/create', 'create')->middleware('auth');
    Route::post('/tagihan/{tagihan}/dnp-perjadin/{dnp}/create', 'store')->middleware('auth');
    Route::get('/tagihan/{tagihan}/dnp-perjadin/{dnp}/cetak', 'cetakKuitansi')->middleware('auth');
    Route::get('/tagihan/{tagihan}/dnp-perjadin/{dnp}/edit', 'edit')->middleware('auth');
    Route::patch('/tagihan/{tagihan}/dnp-perjadin/{dnp}/edit', 'update')->middleware('auth');

    Route::get('/tagihan-blbi/{tagihan}/dnp-perjadin', 'dnpPerjadin')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/dnp-perjadin/create', 'dnpPerjadinCreate')->middleware('auth');
    Route::post('/tagihan-blbi/{tagihan}/dnp-perjadin/create', 'dnpPerjadinStore')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/dnp-perjadin/import', 'import')->middleware('auth');
    Route::post('/tagihan-blbi/{tagihan}/dnp-perjadin/import', 'importStore')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/dnp-perjadin/cetak', 'cetak')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/dnp-perjadin/create-payroll', 'createPayroll')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/dnp-perjadin/{dnp}', 'index')->middleware('auth');
    Route::patch('/tagihan-blbi/{tagihan}/dnp-perjadin/{dnp}', 'updateDetail')->middleware('auth');
    Route::delete('/tagihan-blbi/{tagihan}/dnp-perjadin/{dnp}', 'destroy')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/dnp-perjadin/{dnp}/create', 'create')->middleware('auth');
    Route::post('/tagihan-blbi/{tagihan}/dnp-perjadin/{dnp}/create', 'store')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/dnp-perjadin/{dnp}/cetak', 'cetakKuitansi')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/dnp-perjadin/{dnp}/edit', 'edit')->middleware('auth');
    Route::patch('/tagihan-blbi/{tagihan}/dnp-perjadin/{dnp}/edit', 'update')->middleware('auth');


    Route::get('/verifikasi/{tagihan}/dnp-perjadin', 'dnpPerjadin')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/dnp-perjadin/create', 'dnpPerjadinCreate')->middleware('auth');
    Route::post('/verifikasi/{tagihan}/dnp-perjadin/create', 'dnpPerjadinStore')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/dnp-perjadin/import', 'import')->middleware('auth');
    Route::post('/verifikasi/{tagihan}/dnp-perjadin/import', 'importStore')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/dnp-perjadin/cetak', 'cetak')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/dnp-perjadin/create-payroll', 'createPayroll')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/dnp-perjadin/{dnp}', 'index')->middleware('auth');
    Route::patch('/verifikasi/{tagihan}/dnp-perjadin/{dnp}', 'updateDetail')->middleware('auth');
    Route::delete('/verifikasi/{tagihan}/dnp-perjadin/{dnp}', 'destroy')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/dnp-perjadin/{dnp}/create', 'create')->middleware('auth');
    Route::post('/verifikasi/{tagihan}/dnp-perjadin/{dnp}/create', 'store')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/dnp-perjadin/{dnp}/cetak', 'cetakKuitansi')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/dnp-perjadin/{dnp}/edit', 'edit')->middleware('auth');
    Route::patch('/verifikasi/{tagihan}/dnp-perjadin/{dnp}/edit', 'update')->middleware('auth');

    Route::get('/bendahara/{tagihan}/dnp-perjadin', 'dnpPerjadin')->middleware('auth');
    Route::get('/bendahara/{tagihan}/dnp-perjadin/create', 'dnpPerjadinCreate')->middleware('auth');
    Route::post('/bendahara/{tagihan}/dnp-perjadin/create', 'dnpPerjadinStore')->middleware('auth');
    Route::get('/bendahara/{tagihan}/dnp-perjadin/import', 'import')->middleware('auth');
    Route::post('/bendahara/{tagihan}/dnp-perjadin/import', 'importStore')->middleware('auth');
    Route::get('/bendahara/{tagihan}/dnp-perjadin/cetak', 'cetak')->middleware('auth');
    Route::get('/bendahara/{tagihan}/dnp-perjadin/create-payroll', 'createPayroll')->middleware('auth');
    Route::get('/bendahara/{tagihan}/dnp-perjadin/{dnp}', 'index')->middleware('auth');
    Route::patch('/bendahara/{tagihan}/dnp-perjadin/{dnp}', 'updateDetail')->middleware('auth');
    Route::delete('/bendahara/{tagihan}/dnp-perjadin/{dnp}', 'destroy')->middleware('auth');
    Route::get('/bendahara/{tagihan}/dnp-perjadin/{dnp}/create', 'create')->middleware('auth');
    Route::post('/bendahara/{tagihan}/dnp-perjadin/{dnp}/create', 'store')->middleware('auth');
    Route::get('/bendahara/{tagihan}/dnp-perjadin/{dnp}/cetak', 'cetakKuitansi')->middleware('auth');
    Route::get('/bendahara/{tagihan}/dnp-perjadin/{dnp}/edit', 'edit')->middleware('auth');
    Route::patch('/bendahara/{tagihan}/dnp-perjadin/{dnp}/edit', 'update')->middleware('auth');


    Route::get('/dnp-perjadin/template', 'template')->middleware('auth');
});

Route::controller(DnpHonorariumController::class)->group(function(){
    Route::get('/tagihan/{tagihan}/dnp-honorarium', 'index')->middleware('auth');
    Route::get('/tagihan/{tagihan}/dnp-honorarium/import', 'import')->middleware('auth');
    Route::post('/tagihan/{tagihan}/dnp-honorarium/import', 'importStore')->middleware('auth');
    Route::get('/tagihan/{tagihan}/dnp-honorarium/cetak', 'cetak')->middleware('auth');
    Route::get('/tagihan/{tagihan}/dnp-honorarium/create', 'create')->middleware('auth');
    Route::post('/tagihan/{tagihan}/dnp-honorarium/create', 'store')->middleware('auth');
    Route::get('/tagihan/{tagihan}/dnp-honorarium/create-payroll', 'createPayroll')->middleware('auth');
    Route::get('/tagihan/{tagihan}/dnp-honorarium/{dnp}', 'edit')->middleware('auth');
    Route::patch('/tagihan/{tagihan}/dnp-honorarium/{dnp}', 'update')->middleware('auth');
    Route::delete('/tagihan/{tagihan}/dnp-honorarium/{dnp}', 'destroy')->middleware('auth');

    Route::get('/tagihan-blbi/{tagihan}/dnp-honorarium', 'index')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/dnp-honorarium/import', 'import')->middleware('auth');
    Route::post('/tagihan-blbi/{tagihan}/dnp-honorarium/import', 'importStore')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/dnp-honorarium/cetak', 'cetak')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/dnp-honorarium/create', 'create')->middleware('auth');
    Route::post('/tagihan-blbi/{tagihan}/dnp-honorarium/create', 'store')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/dnp-honorarium/create-payroll', 'createPayroll')->middleware('auth');
    Route::get('/tagihan-blbi/{tagihan}/dnp-honorarium/{dnp}', 'edit')->middleware('auth');
    Route::patch('/tagihan-blbi/{tagihan}/dnp-honorarium/{dnp}', 'update')->middleware('auth');
    Route::delete('/tagihan-blbi/{tagihan}/dnp-honorarium/{dnp}', 'destroy')->middleware('auth');

    Route::get('/verifikasi/{tagihan}/dnp-honorarium', 'index')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/dnp-honorarium/import', 'import')->middleware('auth');
    Route::post('/verifikasi/{tagihan}/dnp-honorarium/import', 'importStore')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/dnp-honorarium/cetak', 'cetak')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/dnp-honorarium/create', 'create')->middleware('auth');
    Route::post('/verifikasi/{tagihan}/dnp-honorarium/create', 'store')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/dnp-honorarium/create-payroll', 'createPayroll')->middleware('auth');
    Route::get('/verifikasi/{tagihan}/dnp-honorarium/{dnp}', 'edit')->middleware('auth');
    Route::patch('/verifikasi/{tagihan}/dnp-honorarium/{dnp}', 'update')->middleware('auth');
    Route::delete('/verifikasi/{tagihan}/dnp-honorarium/{dnp}', 'destroy')->middleware('auth');

    Route::get('/bendahara/{tagihan}/dnp-honorarium', 'index')->middleware('auth');
    Route::get('/bendahara/{tagihan}/dnp-honorarium/import', 'import')->middleware('auth');
    Route::post('/bendahara/{tagihan}/dnp-honorarium/import', 'importStore')->middleware('auth');
    Route::get('/bendahara/{tagihan}/dnp-honorarium/cetak', 'cetak')->middleware('auth');
    Route::get('/bendahara/{tagihan}/dnp-honorarium/create', 'create')->middleware('auth');
    Route::post('/bendahara/{tagihan}/dnp-honorarium/create', 'store')->middleware('auth');
    Route::get('/bendahara/{tagihan}/dnp-honorarium/create-payroll', 'createPayroll')->middleware('auth');
    Route::get('/bendahara/{tagihan}/dnp-honorarium/{dnp}', 'edit')->middleware('auth');
    Route::patch('/bendahara/{tagihan}/dnp-honorarium/{dnp}', 'update')->middleware('auth');
    Route::delete('/bendahara/{tagihan}/dnp-honorarium/{dnp}', 'destroy')->middleware('auth');

    Route::get('/dnp-honorarium/template', 'template')->middleware('auth');
});


Route::controller(SspbController::class)->group(function(){
    Route::get('/sspb', 'index')->middleware('auth');
    Route::get('/sspb/create', 'create')->middleware('auth');
});

Route::controller(RekapPayrollController::class)->group(function(){
    Route::get('/rekap-payroll', 'index')->middleware('auth');
    Route::get('/rekap-payroll/{norek}', 'show')->middleware('auth');
});

Route::controller(TrackingController::class)->group(function(){
    Route::get('/tracking', 'index')->middleware('auth');
    Route::post('/tracking', 'tracking')->middleware('auth');
});

Route::controller(RekapSPMController::class)->group(function(){
    Route::get('/cleansing/rekap-spm', 'index')->middleware('auth');
    Route::get('/cleansing/rekap-spm/{program}/{kegiatan}/{kro}', 'show')->middleware('auth');
    Route::get('/cleansing/rekap-spm/{program}/{kegiatan}/{kro}/{akun}', 'detail')->middleware('auth');
});

Route::post('note-attachments', function () {
    request()->validate([
        'attachment' => ['required', 'file'],
    ]);

    $path = request()->file('attachment')->store('trix-attachments', 'public');

    return [
        'image_url' => route('attachments.show', $path),
    ];
})->name('attachments.store');

Route::get('/note-attachments/{path}', function (string $path) {
    $disk = Storage::disk('public');

    abort_unless($disk->exists($path), 404);

    $stream = $disk->readStream($path);

    $headers = [
        'Content-Type' => $disk->mimeType($path),
        'Content-Length' => $disk->size($path),
    ];

    return response()->stream(fn () => fpassthru($stream), 200, $headers);
})->name('attachments.show')->where('path', '.*');

Route::controller(CleansingTagihanController::class)->group(function(){
    Route::get('/cleansing/tagihan', 'index')->middleware('auth');
    Route::get('/cleansing/tagihan/{tagihan}/edit', 'edit')->middleware('auth');
    Route::patch('/cleansing/tagihan/{tagihan}', 'update')->middleware('auth');
});