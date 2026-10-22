<?php

/**
 * Rutas de la API de la Aplicación.
 * Este archivo define los endpoints para servicios web o APIs RESTful.
 * Todas las rutas aquí configuradas reciben automáticamente el prefijo '/api' y el middleware 'api' (stateless, autenticación vía Sanctum/tokens).
 * 
 * // cambio por IA
 */

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;

// nueva api

/**
 * Endpoint para buscar o filtrar proveedores para componentes de selección/autocompletado.
 *
 * @param \Illuminate\Http\Request $request Objeto de solicitud HTTP entrante.
 * @return \Illuminate\Database\Eloquent\Collection Colección de proveedores con sus columnas id y name.
 * 
 * // cambio por IA
 */
Route::post('/suppliers', function (Request $request) { // Define una ruta HTTP POST accesible en '/api/suppliers' recibiendo la petición ($request)

    // Inicia la consulta al modelo Supplier seleccionando únicamente los campos 'id' y 'name' para mejorar el rendimiento
    return Supplier::select('id', 'name')
        // Si el usuario envió el campo 'search' en el cuerpo de la petición, aplica la función de búsqueda
        ->when($request->search, function ($query, $search) {
            // Busca coincidencias parciales tanto en el nombre como en el número de documento del proveedor
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('document_number', 'like', "%{$search}%");
        })
        // Evalúa si se recibió el campo 'selected' para traer elementos específicos o limitar la lista inicial
        ->when(
            $request->exists('selected'), // Condición: comprueba si la clave 'selected' viene presente en el request
            fn ($query) => $query->whereIn('id', $request->input('selected', [])), // Si 'selected' existe: filtra solo los IDs indicados
            fn ($query) => $query->limit(10) // Si 'selected' no existe: limita la respuesta a un máximo de 10 registros
        )->get(); // Ejecuta la consulta SQL construida y retorna la colección de resultados en formato JSON
})->name('api.suppliers.index');

    
Route::post('/products', function (Request $request) { // Define una ruta HTTP POST accesible en '/api/suppliers' recibiendo la petición ($request)

    // Inicia la consulta al modelo Supplier seleccionando únicamente los campos 'id' y 'name' para mejorar el rendimiento
    return Product::select('id', 'name')
        // Si el usuario envió el campo 'search' en el cuerpo de la petición, aplica la función de búsqueda
        ->when($request->search, function ($query, $search) {
            // Busca coincidencias parciales tanto en el nombre como en el número de documento del proveedor
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
        })
        // Evalúa si se recibió el campo 'selected' para traer elementos específicos o limitar la lista inicial
        ->when(
            $request->exists('selected'), // Condición: comprueba si la clave 'selected' viene presente en el request
            fn ($query) => $query->whereIn('id', $request->input('selected', [])), // Si 'selected' existe: filtra solo los IDs indicados
            fn ($query) => $query->limit(10) // Si 'selected' no existe: limita la respuesta a un máximo de 10 registros
        )->get(); // Ejecuta la consulta SQL construida y retorna la colección de resultados en formato JSON
})->name('api.products.index');