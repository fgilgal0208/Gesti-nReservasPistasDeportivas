<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Middleware\AdminMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Redirección inicial (quitamos la pantalla negra de bienvenida)
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Panel principal del Usuario (Donde está el componente de reservas)
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 3. Perfil del Usuario
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// 4. Zona Exclusiva del Ayuntamiento (Protegida por AdminMiddleware)
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/pdf', [ReservationController::class, 'exportPdf'])->name('reservations.pdf');
    Route::get('/reservations/excel', [ReservationController::class, 'exportExcel'])->name('reservations.excel');
});

// 5. Rutas de Login, Registro, etc. (Gestionadas por Livewire/Volt)
require __DIR__.'/auth.php';