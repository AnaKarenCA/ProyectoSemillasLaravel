<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;  
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecuperarController;
use App\Http\Controllers\ExistenciasController;
use App\Http\Controllers\VentaController;

use App\Http\Controllers\ReportesController;


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Mostrar formulario de recuperación
Route::get('/recuperar', [AuthController::class, 'showRecoveryForm'])
    ->name('password.recovery.form');



Route::get('/reportes', [ReportesController::class, 'index'])->name('reportes.index');
Route::post('/reportes/generar', [ReportesController::class, 'generar'])->name('reportes.generar');

// -------------------
// RUTAS DE EXISTENCIAS
// -------------------
Route::resource('existencias', ExistenciasController::class);

// -------------------
// LOGIN Y HOME
// -------------------
Route::get('/', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/home', [HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth');

Route::post('/recuperar', [AuthController::class, 'sendTemporaryPassword'])
    ->name('password.recovery.send');

Route::middleware(['auth'])->group(function () {
    Route::get('/venta', [VentaController::class, 'index'])->name('venta.index');
    Route::post('/venta', [VentaController::class, 'store'])->name('venta.store');
});

