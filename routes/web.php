<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\CPCUController;
use App\Http\Controllers\EntidadController;
use App\Http\Controllers\IndicadorController;
use App\Http\Controllers\IndicadorProductoController;
use App\Http\Controllers\NAEController;
use App\Http\Controllers\OrganismoController;
use App\Http\Controllers\OSDEController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\SACLAPController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Mail;
use App\Http\Controllers\UserController;

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
Route::middleware(['auth','admin'])->group(function () {
    Route::resource('user', UserController::class);
    Route::get('user/delete/{id}', [UserController::class, 'delete'])->name('delete');

    Route::resource('organismo', OrganismoController::class);
    Route::get('organismo/delete/{id}', [OrganismoController::class, 'delete'])->name('delete');

    Route::resource('osde',OSDEController::class);
    Route::get('osde/delete/{id}', [OSDEController::class, 'delete'])->name('delete');

    Route::resource('entidad',EntidadController::class);
    Route::get('entidad/delete/{id}', [EntidadController::class, 'delete'])->name('delete');

    Route::resource('cpcu',CPCUController::class);
    Route::get('cpcu/delete/{id}', [CPCUController::class, 'delete'])->name('delete');
    Route::get('cpcu-file-import', [CPCUController::class, 'fileImportExport']);
    Route::post('cpcu-file-import', [CPCUController::class, 'fileImport']);
    Route::get('cpcu-file-export', [CPCUController::class, 'export']);

    Route::resource('saclap',SACLAPController::class);
    Route::get('saclap/delete/{id}', [SACLAPController::class, 'delete'])->name('delete');
    Route::get('saclap-file-import', [SACLAPController::class, 'fileImportExport']);
    Route::post('saclap-file-import', [SACLAPController::class, 'fileImport']);
    Route::get('saclap-file-export', [SACLAPController::class, 'export']);

    Route::resource('cnae',NAEController::class);
    Route::get('cnae/delete/{id}', [NAEController::class, 'delete'])->name('delete');
    Route::get('cnae-file-import', [NAEController::class, 'fileImportExport']);
    Route::post('cnae-file-import', [NAEController::class, 'fileImport']);
    Route::get('cnae-file-export', [NAEController::class, 'export']);

    Route::resource('producto',ProductoController::class);
    Route::get('producto/delete/{id}', [ProductoController::class, 'delete'])->name('delete');
    Route::get('filteringProd', [ProductoController::class, 'filter'])->name('producto-filtering');

    Route::resource('actividad',ActividadController::class);
    Route::get('actividad/delete/{id}', [ActividadController::class, 'delete'])->name('delete');

    Route::resource('indicador',IndicadorController::class);
    Route::get('indicador/delete/{id}', [IndicadorController::class, 'delete'])->name('delete');

    Route::get('indicador-producto/create/{id}', [IndicadorProductoController::class, 'create'])->name('create');
    Route::post('indicador-producto/create/{id}', [IndicadorProductoController::class, 'store'])->name('store');
    Route::get('indicador-producto/{indicador}/edit/{producto}', [IndicadorProductoController::class, 'edit'])->name('edit');
    Route::put('indicador-producto/{indicador}/update/{producto}', [IndicadorProductoController::class, 'update'])->name('update');
    Route::get('indicador-producto/delete/{id}', [IndicadorProductoController::class, 'delete'])->name('delete');
    Route::delete('indicador-producto/delete/{id}', [IndicadorProductoController::class, 'destroy'])->name('destroy');

    Route::resource('plan',PlanController::class);
    Route::get('plan/delete/{id}', [PlanController::class, 'delete'])->name('delete');
    Route::get('filteringPlan', [PlanController::class, 'filter'])->name('plan-filtering');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

