<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::post('/login', [AuthenticatedSessionController::class, 'login'])->name('login');
Route::post('/logout', [AuthenticatedSessionController::class, 'logout'])->name('logout');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function () {
    // CRUD de Contactos
    Route::post('/contactos', [ContactoController::class, 'store']);
    Route::get('/contactos', [ContactoController::class, 'index']);
    Route::get('/contactos/{id}', [ContactoController::class, 'show']);
    Route::put('/contactos/{id}', [ContactoController::class, 'update']);
    Route::delete('/contactos/{id}', [ContactoController::class, 'destroy']);
});


