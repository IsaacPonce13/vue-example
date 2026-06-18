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
    Route::get('/modulos', [ModuloController::class, 'index'])->name('modulos')->middleware('can:modulos');
    Route::get('/modulos/crear', [ModuloController::class, 'create'])->name('modulos.create')->middleware('can:modulos.create');
    Route::get('/modulos/{id}/ver', [ModuloController::class, 'show'])->name('modulos.show')->middleware('can:modulos.show');
    Route::get('/modulos/{id}/editar', [ModuloController::class, 'edit'])->name('modulos.edit')->middleware('can:modulos.edit');
    // 2. Acciones (Procesamiento de datos tras enviar formularios)
    Route::post('/modulos', [ModuloController::class, 'store'])->name('modulos.store')->middleware('can:modulos.create');
    Route::put('/modulos/{id}', [ModuloController::class, 'update'])->name('modulos.update')->middleware('can:modulos.edit');
    Route::delete('/modulos/{id}', [ModuloController::class, 'destroy'])->name('modulos.destroy')->middleware('can:modulos.destroy');

    // ==========================================
    // RUTAS DE USUARIOS
    // ==========================================
    // 1. Visualización (Páginas de Vue)
    Route::get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios')->middleware('can:usuarios');
    Route::get('/usuarios/crear', [UsuariosController::class, 'create'])->name('usuarios.create')->middleware('can:usuarios.create');
    Route::get('/usuarios/{id}/ver', [UsuariosController::class, 'show'])->name('usuarios.show')->middleware('can:usuarios.show');
    Route::get('/usuarios/{id}/editar', [UsuariosController::class, 'edit'])->name('usuarios.edit')->middleware('can:usuarios.edit');
    // 2. Acciones (Procesamiento de datos tras enviar formularios)
    Route::post('/usuarios', [UsuariosController::class, 'store'])->name('usuarios.store')->middleware('can:usuarios.create');
    Route::put('/usuarios/{id}', [UsuariosController::class, 'update'])->name('usuarios.update')->middleware('can:usuarios.edit');
    Route::put('/usuarios/{id}/password', [UsuariosController::class, 'password'])->name('usuarios.password')->middleware('can:usuarios.edit');
    Route::put('/usuarios/{id}/estado', [UsuariosController::class, 'estado'])->name('usuarios.estado')->middleware('can:usuarios.edit');

    // ==========================================
    // RUTAS DE ROLES
    // ==========================================
    // 1. Visualización (Páginas de Vue)
    Route::get('/roles', [RolesController::class, 'index'])->name('roles')->middleware('can:roles');
    Route::get('/roles/crear', [RolesController::class, 'create'])->name('roles.create')->middleware('can:roles.create');
    Route::get('/roles/{id}/ver', [RolesController::class, 'show'])->name('roles.show')->middleware('can:roles.show');
    Route::get('/roles/{id}/editar', [RolesController::class, 'edit'])->name('roles.edit')->middleware('can:roles.edit');
    // 2. Acciones (Procesamiento de datos tras enviar formularios)
    Route::post('/roles', [RolesController::class, 'store'])->name('roles.store')->middleware('can:roles.create');
    Route::put('/roles/{id}', [RolesController::class, 'update'])->name('roles.update')->middleware('can:roles.edit');
    Route::put('/roles/{id}/password', [RolesController::class, 'password'])->name('roles.password')->middleware('can:roles.edit');
    Route::put('/roles/{id}/estado', [RolesController::class, 'estado'])->name('roles.estado')->middleware('can:roles.edit');

    // ==========================================
    // RUTAS DE PERMISOS
    // ==========================================
    // 1. Visualización (Páginas de Vue)
    Route::get('/permisos', [PermisosController::class, 'index'])->name('permisos')->middleware('can:permisos');
    Route::get('/permisos/crear', [PermisosController::class, 'create'])->name('permisos.create')->middleware('can:permisos.create');
    Route::get('/permisos/{id}/ver', [PermisosController::class, 'show'])->name('permisos.show')->middleware('can:permisos.show');
    Route::get('/permisos/{id}/editar', [PermisosController::class, 'edit'])->name('permisos.edit')->middleware('can:permisos.edit');
    // 2. Acciones (Procesamiento de datos tras enviar formularios)
    Route::post('/permisos', [PermisosController::class, 'store'])->name('permisos.store')->middleware('can:permisos.create');
    Route::put('/permisos/{id}', [PermisosController::class, 'update'])->name('permisos.update')->middleware('can:permisos.edit');
    Route::put('/permisos/{id}/password', [PermisosController::class, 'password'])->name('permisos.password')->middleware('can:permisos.edit');
    Route::put('/permisos/{id}/estado', [PermisosController::class, 'estado'])->name('permisos.estado')->middleware('can:permisos.edit');

});

    Route::middleware('auth')->group(function () {
    Route::inertia('profile', 'Profile')->name('profile');
});

require __DIR__.'/settings.php';
