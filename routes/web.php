<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\ValidateReservation;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Admin\ReservaController as AdminReservaController;
use App\Http\Controllers\Web\ReservaClienteController as ClienteReservaController;
use App\Http\Controllers\Web\AutocaravanaController;

// Página principal pública
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Registro solo para clientes
Route::get('register', function () {
    return view('auth.register');
})->name('register');

Route::post('register', [AuthController::class, 'register']);

// Autenticación
Route::controller(AuthController::class)->group(function () {
    Route::get('login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('login', 'login');
    Route::post('logout', 'logout')->name('logout');
});

// Área autenticada
Route::middleware(['auth', 'verified'])->group(function () {

    // Redirección según rol
    Route::get('dashboard', function () {
        $user = Auth::user();

        if ($user->rol === 'admin') {
            return redirect()->route('admin.index');
        }

        if ($user->rol === 'cliente') {
            return redirect()->route('reservas.index');
        }

        abort(403, 'Acceso no autorizado');
    })->name('dashboard');

    // RUTAS PARA CLIENTES
    Route::middleware('role:cliente')->prefix('reservas')->name('reservas.')->group(function () {
        Route::get('/', [ClienteReservaController::class, 'index'])->name('index');
        Route::get('crear', [ClienteReservaController::class, 'create'])->name('create');
        Route::post('/', [ClienteReservaController::class, 'store'])->middleware(ValidateReservation::class)->name('store');
        Route::get('{reserva}/editar', [ClienteReservaController::class, 'edit'])->name('edit');
        Route::put('{reserva}', [ClienteReservaController::class, 'update'])->middleware(ValidateReservation::class)->name('update');
        Route::delete('{reserva}', [ClienteReservaController::class, 'destroy'])->name('destroy');
    });

    // RUTAS PARA ADMINISTRADORES
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {

        // Panel de bienvenida
        Route::get('/', function () {
            return view('admin.index');  // Vista de inicio admin
        })->name('index');

        // Gestión de autocaravanas
        Route::prefix('autocaravanas')->name('autocaravanas.')->group(function () {
            Route::get('/', [AutocaravanaController::class, 'index'])->name('index');
            Route::get('crear', [AutocaravanaController::class, 'create'])->name('create');
            Route::post('/', [AutocaravanaController::class, 'store'])->name('store');
            Route::get('{autocaravana}/editar', [AutocaravanaController::class, 'edit'])->name('edit');
            Route::put('{autocaravana}', [AutocaravanaController::class, 'update'])->name('update');
            Route::delete('{autocaravana}', [AutocaravanaController::class, 'destroy'])->name('destroy');
        });

        // Gestión de reservas para ADMIN
        Route::prefix('reservas')->name('reservas.')->group(function () {
            Route::get('/', [AdminReservaController::class, 'index'])->name('index');
            Route::get('crear', [AdminReservaController::class, 'create'])->name('create');
            Route::post('/', [AdminReservaController::class, 'store'])->middleware(ValidateReservation::class)->name('store');
            Route::get('{reserva}/editar', [AdminReservaController::class, 'edit'])->name('edit');
            Route::put('{reserva}', [AdminReservaController::class, 'update'])->middleware(ValidateReservation::class)->name('update');
            Route::delete('{reserva}', [AdminReservaController::class, 'destroy'])->name('destroy');
        });
        // Historial de reservas
        Route::get('historial-reservas', [App\Http\Controllers\Admin\HistorialReservaController::class, 'index'])->name('historial.index');


    });
});
