<?php
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;


// Rutas de autenticación
Auth::routes();

// Ruta de inicio
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


