<?php

use App\Http\Controllers\Admin\UsuariosController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\PermisosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DependenciasController;


// Todas las rutas aquí ya tienen el prefijo /admin y middleware auth
Route::middleware(['verified'])->group(function () {
    
    // Dashboard del admin
    Route::get('/dashboard', function () {
        return inertia('Dashboard');
    })->name('dashboard');

    // ==========================================
    // RUTAS DE USUARIOS
    // ==========================================
    Route::prefix('usuarios')->name('usuarios.')->group(function () {
        
        Route::middleware(['can:usuarios'])->group(function () {
            Route::get('/', [UsuariosController::class, 'index'])->name('index');
            Route::get('/{id}/ver', [UsuariosController::class, 'show'])->name('show');
        });

        Route::middleware(['can:usuarios.create'])->group(function () {
            Route::get('/crear', [UsuariosController::class, 'create'])->name('create');
            Route::post('/', [UsuariosController::class, 'store'])->name('store');
        });

        Route::middleware(['can:usuarios.edit'])->group(function () {
            Route::get('/{id}/editar', [UsuariosController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UsuariosController::class, 'update'])->name('update');
            Route::put('/{id}/password', [UsuariosController::class, 'password'])->name('password');
            Route::put('/{id}/estado', [UsuariosController::class, 'estado'])->name('estado');
        });
    });

    // ==========================================
    // RUTAS DE ROLES
    // ==========================================
    Route::prefix('roles')->name('roles.')->group(function () {
        
        Route::middleware(['can:roles'])->group(function () {
            Route::get('/', [RolesController::class, 'index'])->name('index');
            Route::get('/{id}/ver', [RolesController::class, 'show'])->name('show');
        });

        Route::middleware(['can:roles.create'])->group(function () {
            Route::get('/crear', [RolesController::class, 'create'])->name('create');
            Route::post('/', [RolesController::class, 'store'])->name('store');
        });

        Route::middleware(['can:roles.edit'])->group(function () {
            Route::get('/{id}/editar', [RolesController::class, 'edit'])->name('edit');
            Route::put('/{id}', [RolesController::class, 'update'])->name('update');
            Route::put('/{id}/estado', [RolesController::class, 'estado'])->name('estado');
        });
    });

    // ==========================================
    // RUTAS DE PERMISOS
    // ==========================================
    Route::prefix('permisos')->name('permisos.')->group(function () {
        
        Route::middleware(['can:permisos'])->group(function () {
            Route::get('/', [PermisosController::class, 'index'])->name('index');
            Route::get('/{id}/ver', [PermisosController::class, 'show'])->name('show');
        });

        Route::middleware(['can:permisos.create'])->group(function () {
            Route::get('/crear', [PermisosController::class, 'create'])->name('create');
            Route::post('/', [PermisosController::class, 'store'])->name('store');
        });

        Route::middleware(['can:permisos.edit'])->group(function () {
            Route::get('/{id}/editar', [PermisosController::class, 'edit'])->name('edit');
            Route::put('/{id}', [PermisosController::class, 'update'])->name('update');
            Route::put('/{id}/estado', [PermisosController::class, 'estado'])->name('estado');
        });
    });

    // ==========================================
    // RUTAS DE DEPENDENCIAS
    // ==========================================
    Route::prefix('dependencias')->name('dependencias.')->group(function () {
        
        Route::middleware(['can:dependencias'])->group(function () {
            Route::get('/', [DependenciasController::class, 'index'])->name('index');
            Route::get('/{id}/ver', [DependenciasController::class, 'show'])->name('show');
        });

        Route::middleware(['can:dependencias.create'])->group(function () {
            Route::get('/crear', [DependenciasController::class, 'create'])->name('create');
            Route::post('/', [DependenciasController::class, 'store'])->name('store');
        });

        Route::middleware(['can:dependencias.edit'])->group(function () {
            Route::get('/{id}/editar', [DependenciasController::class, 'edit'])->name('edit');
            Route::put('/{id}', [DependenciasController::class, 'update'])->name('update');
            Route::put('/{id}/estado', [DependenciasController::class, 'estado'])->name('estado');
        });
    });
});