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
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompraController;


Route::get('/', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/recuperar', [AuthController::class, 'showRecoveryForm'])->name('password.recovery.form');
Route::post('/recuperar', [AuthController::class, 'sendTemporaryPassword'])->name('password.recovery.send');


Route::middleware(['auth'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('clientes', ClienteController::class);
    Route::resource('proveedores', ProveedorController::class);
    Route::resource('compras', CompraController::class);
    Route::resource('inventarios', InventarioController::class);
    Route::resource('existencias', App\Http\Controllers\ExistenciasController::class);

    Route::get('/inventario/unidades/{id_producto}', [InventarioController::class, 'getUnidades']);

    /** ----- RUTAS DE CONFIGURACIÓN ----- */
    Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');
    Route::get('/configuracion/nuevo', [ConfiguracionController::class, 'create'])->name('configuracion.create');
    Route::post('/configuracion', [ConfiguracionController::class, 'store'])->name('configuracion.store');
    Route::post('/configuracion/{id}', [ConfiguracionController::class, 'update'])->name('configuracion.update');
    Route::delete('/configuracion/{id}', [ConfiguracionController::class, 'destroy'])->name('configuracion.destroy');


    /** ----- PUNTO DE VENTA ----- */
    Route::get('/venta', [VentaController::class, 'index'])->name('venta.index');
    Route::post('/venta', [VentaController::class, 'store'])->name('venta.store');


    /** ----- REPORTES ----- */
    Route::get('/reportes', [ReportesController::class, 'index'])->name('reportes.index');
    Route::post('/reportes/generar', [ReportesController::class, 'generar'])->name('reportes.generar');


    //existencias


Route::post('/existencias/activar/{id}', [ExistenciasController::class, 'activar'])
    ->name('existencias.activar');

Route::post('/existencias/desactivar/{id}', [ExistenciasController::class, 'desactivar'])
    ->name('existencias.desactivar');



});
