<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\CPCUController;
use App\Http\Controllers\EntidadController;
use App\Http\Controllers\NAEController;
use App\Http\Controllers\OrganismoController;
use App\Http\Controllers\OSDEController;
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

    Route::resource('saclap',SACLAPController::class);
    Route::get('saclap/delete/{id}', [SACLAPController::class, 'delete'])->name('delete');

    Route::resource('cnae',NAEController::class);
    Route::get('cnae/delete/{id}', [NAEController::class, 'delete'])->name('delete');

    Route::resource('producto',ProductoController::class);
    Route::get('producto/delete/{id}', [ProductoController::class, 'delete'])->name('delete');

    Route::resource('actividad',ActividadController::class);
    Route::get('actividad/delete/{id}', [ActividadController::class, 'delete'])->name('delete');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

