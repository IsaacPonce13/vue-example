<?php

use App\Http\Controllers\ModuloController;
use App\Http\Controllers\UsuariosController;
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
    Route::get('/modulos', [ModuloController::class, 'index'])->name('modulos');
    Route::get('/modulos/crear', [ModuloController::class, 'create'])->name('modulos.create');
    Route::get('/modulos/{id}/ver', [ModuloController::class, 'show'])->name('modulos.show');
    Route::get('/modulos/{id}/editar', [ModuloController::class, 'edit'])->name('modulos.edit');
    // 2. Acciones (Procesamiento de datos tras enviar formularios)
    Route::post('/modulos', [ModuloController::class, 'store'])->name('modulos.store');
    Route::put('/modulos/{id}', [ModuloController::class, 'update'])->name('modulos.update');
    Route::delete('/modulos/{id}', [ModuloController::class, 'destroy'])->name('modulos.destroy');

    // ==========================================
    // RUTAS DE USUARIOS
    // ==========================================
    // 1. Visualización (Páginas de Vue)
    Route::get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios');
    Route::get('/usuarios/crear', [UsuariosController::class, 'create'])->name('usuarios.create');
    Route::get('/usuarios/{id}/ver', [UsuariosController::class, 'show'])->name('usuarios.show');
    Route::get('/usuarios/{id}/editar', [UsuariosController::class, 'edit'])->name('usuarios.edit');
    // 2. Acciones (Procesamiento de datos tras enviar formularios)
    Route::post('/usuarios', [UsuariosController::class, 'store'])->name('usuarios.store');
    Route::put('/usuarios/{id}', [UsuariosController::class, 'update'])->name('usuarios.update');
    Route::put('/usuarios/{id}/password', [UsuariosController::class, 'password'])->name('usuarios.password');
    Route::put('/usuarios/{id}/estado', [UsuariosController::class, 'estado'])->name('usuarios.estado');
});

Route::middleware('auth')->group(function () {
    Route::inertia('profile', 'Profile')->name('profile');
});

require __DIR__.'/settings.php';
