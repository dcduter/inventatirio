<?php

/**
 * Rutas Web Principales de la Aplicación.
 * Este archivo contiene las rutas públicas y de acceso web general (como redirecciones y el dashboard de usuarios).
 * 
 * // cambio por IA
 */

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin'); // redirige a la ruta admin


/* Route::get('/', function () { // se usar para acceso publico
    return view('welcome');
}); */

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
