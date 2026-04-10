<?php

use App\Http\Controllers\AllergieenController;
use App\Http\Controllers\PakkettenController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('pakketten', PakkettenController::class);

Route::get('/allergieen', [AllergieenController::class, 'index'])->name('allergieen.index')
->middleware('role:manager');

require __DIR__.'/auth.php';
