<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/cadastro', [UserController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(ReservaController::class)->group(function() {
        Route::get('/reservas', 'index');
        Route::get('/reserva/{idReserva}', 'show');
        Route::put('/reserva/{idReserva}', 'update');
        Route::post('/reserva', 'store');
        Route::delete('/reserva/{idReserva}', 'destroy');
    });
    
    Route::controller(MesaController::class)->group(function() {
        Route::get('/mesas', 'index');
        Route::post('/mesa', 'store');
        Route::get('/mesa/{idMesa}', 'show');
    });
    
    Route::controller(ClienteController::class)->group(function() {
        Route::get('/clientes', 'index');
        Route::post('/cliente', 'store');
        Route::get('/cliente/{idCliente}', 'show');
    });
});
