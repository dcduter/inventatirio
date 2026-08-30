<?php

/**
 * Rutas del Panel Administrativo (/admin).
 * Este archivo agrupa las rutas protegidas para la gestión del sistema (categorías, productos, inventario, etc.).
 * Se carga en bootstrap/app.php con prefijo 'admin' y autenticación requerida.
 * 
 * // cambio por IA
 */

use App\Http\Controllers\Admin\CategoryController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');

// Rutas
Route::resource('categories', CategoryController::class)->except(['show']);
