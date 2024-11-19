<?php

use App\Http\Controllers\DecreeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/decrees/search', [DecreeController::class, 'search'])->name('decrees.search');

Route::get('/teste', function () {
    return view('teste');
});

Route::get('/dashboard-2', function () {
    return view('dashboard-2');
});

Route::get('/dashboard1', function () {
    return view('dashboard1');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Rotas para o gerenciamento de Decretos
    Route::resource('decrees', DecreeController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
