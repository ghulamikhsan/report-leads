<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
});

Auth::routes();

Route::group(['middleware' => ['auth', 'dontback']], function () {
    Route::get('/home', [App\Http\Controllers\Home\HomeController::class, 'index'])->name('home');
    Route::resource('dashboard/roles', App\Http\Controllers\Role\RoleController::class);
    Route::resource('dashboard/permissions', App\Http\Controllers\Role\PermissionsController::class);
    Route::resource('dashboard/users', App\Http\Controllers\User\UserController::class);
    Route::resource('customer', App\Http\Controllers\CustomerController::class);
    Route::resource('laporan', App\Http\Controllers\LaporanController::class);
    Route::resource('laporancustlama', App\Http\Controllers\LaporanLamaController::class);
    route::resource('master', App\Http\Controllers\MasterController::class);
    route::resource('detail', App\Http\Controllers\DetailController::class);
    route::resource('dashboard', App\Http\Controllers\DashboardController::class);
    route::resource('ratio', App\Http\Controllers\RatioController::class);
    route::get('detailtgl', [App\Http\Controllers\DetailController::class, 'indextgl'])->name('detailtgl');
    route::get('detailtgl/{detail}', [App\Http\Controllers\DetailController::class, 'showtgl'])->name('detailtgl.show');
    route::get('detailbln', [App\Http\Controllers\DetailController::class, 'indexbln'])->name('detailbln');
    route::get('detailbln/{detail}', [App\Http\Controllers\DetailController::class, 'showbln'])->name('detailbln.show');
    route::get('detailthn', [App\Http\Controllers\DetailController::class, 'indexthn'])->name('detailthn');
    route::get('detailthn/{detail}', [App\Http\Controllers\DetailController::class, 'showthn'])->name('detailthn.show');
    route::get('detailcust', [App\Http\Controllers\DetailController::class, 'indexcust'])->name('detailcust');
    route::get('export', [App\Http\Controllers\LaporanController::class, 'export_excel'])->name('export');
    route::get('export_bulanan/{detail}', [App\Http\Controllers\DetailController::class, 'export_excel_bulanan'])->name('export_bulanan');
    route::get('export_tahunan/{detail}', [App\Http\Controllers\DetailController::class, 'export_excel_tahunan'])->name('export_tahunan');
    route::get('laporan/cari', [App\Http\Controllers\LaporanController::class, 'cari']);
});
