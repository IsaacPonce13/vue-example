<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Inertia\Inertia;
use App\Http\Controllers\ModuloController;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

// Route::get('/modulos', function () {
//     return Inertia::render('modulos/index');
// })->name('modulos');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::get('/modulos', [ModuloController::class, 'index'])->name('modulos');
});

Route::middleware('auth')->group(function () {
    Route::inertia('profile', 'Profile')->name('profile');
}); 

require __DIR__.'/settings.php';
