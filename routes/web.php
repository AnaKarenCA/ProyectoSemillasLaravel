<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;  
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecuperarController;
use App\Http\Controllers\ExistenciasController;
use App\Http\Controllers\VentaController;

use App\Http\Controllers\ReportesController;

use App\Http\Controllers\InventarioController;

use App\Http\Controllers\ConfiguracionController;

Route::resource('inventarios', InventarioController::class);
Route::resource('inventarios', App\Http\Controllers\InventarioController::class);



Route::get('/', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/recuperar', [AuthController::class, 'showRecoveryForm'])
    ->name('password.recovery.form');
Route::post('/recuperar', [AuthController::class, 'sendTemporaryPassword'])
    ->name('password.recovery.send');

Route::resource('clientes', App\Http\Controllers\ClienteController::class);

Route::resource('compras', App\Http\Controllers\CompraController::class);



use App\Http\Controllers\ProveedorController;

Route::middleware(['auth'])->group(function () {
    Route::resource('proveedores', ProveedorController::class);
});





Route::get('/home', [HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth');


Route::middleware(['auth'])->group(function () {
    Route::get('/venta', [VentaController::class, 'index'])->name('venta.index');
    Route::post('/venta', [VentaController::class, 'store'])->name('venta.store');


Route::get('/reportes', [ReportesController::class, 'index'])->name('reportes.index');
Route::post('/reportes/generar', [ReportesController::class, 'generar'])->name('reportes.generar');

Route::resource('existencias', ExistenciasController::class);

Route::middleware(['auth'])->group(function () {
    Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');
    Route::post('/configuracion/{id}', [ConfiguracionController::class, 'update'])->name('configuracion.update');
    Route::post('/configuracion/nuevo', [ConfiguracionController::class, 'store'])->name('configuracion.store');
    Route::delete('/configuracion/{id}', [ConfiguracionController::class, 'destroy'])->name('configuracion.destroy');
});

});

