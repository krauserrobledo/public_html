<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AutocaravanaController;
use App\Http\Controllers\API\ReservaController;
use App\Http\Controllers\API\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Autenticación pública
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    // Cierre de sesión
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Rutas de usuario autenticado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Consulta de vehículos disponibles
    Route::get('/autocaravanas/disponibles', [AutocaravanaController::class, 'disponibles']);
    
    // Gestión de reservas del usuario
    Route::apiResource('reservas', ReservaController::class)->except(['update']);
    Route::put('/reservas/{reserva}/modificar', [ReservaController::class, 'update']);
    
    // Rutas de administrador
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::apiResource('autocaravanas', AdminController::class);
        Route::get('/reservas', [AdminController::class, 'getAllReservas']);
        Route::get('/historial', [AdminController::class, 'getHistorial']);
    });
});