<?php
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ScientistController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::get('/', [ScientistController::class, 'index'])->name('home');

Route::resource('scientists', ScientistController::class);
