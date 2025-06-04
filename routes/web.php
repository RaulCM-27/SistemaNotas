<?php

use App\Http\Controllers\EstudiantesController;
use App\Http\Controllers\ProfesoresController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::resource('estudiantes', EstudiantesController::class);
Route::resource('profesores', ProfesoresController::class);


