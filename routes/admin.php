<?php

/**
 * Rutas del Panel Administrativo (/admin).
 * Este archivo agrupa las rutas protegidas para la gestión del sistema (categorías, productos, inventario, etc.).
 * Se carga en bootstrap/app.php con prefijo 'admin' y autenticación requerida.
 * 
 * // cambio por IA
 */

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view ('admin.dashboard');
})->name('dashboard');
