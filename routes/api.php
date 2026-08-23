<?php

/**
 * Rutas de la API de la Aplicación.
 * Este archivo define los endpoints para servicios web o APIs RESTful.
 * Todas las rutas aquí configuradas reciben automáticamente el prefijo '/api' y el middleware 'api' (stateless, autenticación vía Sanctum/tokens).
 * 
 * // cambio por IA
 */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
