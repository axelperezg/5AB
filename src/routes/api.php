<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Agregar el controlador EventoController
use App\Http\Controllers\EventoController;
use App\Http\Controllers\PonenteController;
use App\Http\Controllers\AsistenteController;

/*
* Rutas para el recurso Evento.
*/

// Recuperar todos los eventos
Route::get('/eventos', [EventoController::class, 'index']);
// Almacenar un evento nuevo
Route::post('/eventos', [EventoController::class, 'store']);
// Recuperar un evento específico
Route::get('/eventos/{id}', [EventoController::class, 'show']);
// Actualizar un evento específico
Route::put('/eventos/{evento}', [EventoController::class, 'update']);
// Eliminar un evento específico
Route::delete('/eventos/{id}', [EventoController::class, 'destroy']);

/*
* Rutas para el recurso Ponente.
*/

// Recuperar todos los eventos
Route::get('/ponente', [PonenteController::class, 'index']);
// Almacenar un evento nuevo
Route::post('/ponente', [PonenteController::class, 'store']);
// Recuperar un evento específico
Route::get('/ponente/{id}', [PonenteController::class, 'show']);
// Actualizar un evento específico
Route::put('/ponente/{ponente}', [PonenteController::class, 'update']);
// Eliminar un evento específico
Route::delete('/ponente/{id}', [PonenteController::class, 'destroy']);

/*
* Rutas para el recurso Asistente.
*/

// Recuperar todos los eventos
Route::get('/asistente', [AsistenteController::class, 'index']);
// Almacenar un evento nuevo
Route::post('/asistente', [AsistenteController::class, 'store']);
// Recuperar un evento específico
Route::get('/asistente/{id}', [AsistenteController::class, 'show']);
// Actualizar un evento específico
Route::put('/asistente/{asistente}', [AsistenteController::class, 'update']);
// Eliminar un evento específico
Route::delete('/asistente/{id}', [AsistenteController::class, 'destroy']);