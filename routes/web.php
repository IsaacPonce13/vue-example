<?php

use App\Http\Controllers\ModuloController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    // ==========================================
    // RUTAS DE MÓDULOS
    // ==========================================
    // 1. Visualización (Páginas de Vue)
    Route::get('/modulos', [ModuloController::class, 'index'])->name('modulos')->middleware('can:modulos');
    Route::get('/modulos/crear', [ModuloController::class, 'create'])->name('modulos.create')->middleware('can:modulos.create');
    Route::get('/modulos/{id}/ver', [ModuloController::class, 'show'])->name('modulos.show')->middleware('can:modulos.show');
    Route::get('/modulos/{id}/editar', [ModuloController::class, 'edit'])->name('modulos.edit')->middleware('can:modulos.edit');
    // 2. Acciones (Procesamiento de datos tras enviar formularios)
    Route::post('/modulos', [ModuloController::class, 'store'])->name('modulos.store')->middleware('can:modulos.create');
    Route::put('/modulos/{id}', [ModuloController::class, 'update'])->name('modulos.update')->middleware('can:modulos.edit');

});

    Route::middleware('auth')->group(function () {
    Route::inertia('profile', 'Profile')->name('profile');
});

require __DIR__.'/settings.php';
