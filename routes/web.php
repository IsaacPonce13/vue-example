<?php

use App\Http\Controllers\ModuloController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\RolesController;
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

    // ==========================================
    // RUTAS DE ROLES
    // ==========================================
    // 1. Visualización (Páginas de Vue)
    Route::get('/roles', [RolesController::class, 'index'])->name('roles');
    Route::get('/roles/crear', [RolesController::class, 'create'])->name('roles.create');
    Route::get('/roles/{id}/ver', [RolesController::class, 'show'])->name('roles.show');
    Route::get('/roles/{id}/editar', [RolesController::class, 'edit'])->name('roles.edit');
    // 2. Acciones (Procesamiento de datos tras enviar formularios)
    Route::post('/roles', [RolesController::class, 'store'])->name('roles.store');
    Route::put('/roles/{id}', [RolesController::class, 'update'])->name('roles.update');
    Route::put('/roles/{id}/password', [RolesController::class, 'password'])->name('roles.password');
    Route::put('/roles/{id}/estado', [RolesController::class, 'estado'])->name('roles.estado');

    // ==========================================
    // RUTAS DE PERMISOS
    // ==========================================
    // 1. Visualización (Páginas de Vue)
    Route::get('/permisos', [PermisosController::class, 'index'])->name('permisos');
    Route::get('/permisos/crear', [PermisosController::class, 'create'])->name('permisos.create');
    Route::get('/permisos/{id}/ver', [PermisosController::class, 'show'])->name('permisos.show');
    Route::get('/permisos/{id}/editar', [PermisosController::class, 'edit'])->name('permisos.edit');
    // 2. Acciones (Procesamiento de datos tras enviar formularios)
    Route::post('/permisos', [PermisosController::class, 'store'])->name('permisos.store');
    Route::put('/permisos/{id}', [PermisosController::class, 'update'])->name('permisos.update');
    Route::put('/permisos/{id}/password', [PermisosController::class, 'password'])->name('permisos.password');
    Route::put('/permisos/{id}/estado', [PermisosController::class, 'estado'])->name('permisos.estado');

});

    Route::middleware('auth')->group(function () {
    Route::inertia('profile', 'Profile')->name('profile');
});

require __DIR__.'/settings.php';
