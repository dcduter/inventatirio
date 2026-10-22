<?php

/**
 * Rutas del Panel Administrativo (/admin).
 * Este archivo agrupa las rutas protegidas para la gestión del sistema (categorías, productos, inventario, etc.).
 * Se carga en bootstrap/app.php con prefijo 'admin' y autenticación requerida.
 * 
 * // cambio por IA
 */

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Admin\PurchaseOrderController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

/**
 * // cambio por IA: Ruta de la vista principal del panel de administración (Dashboard).
 * @return \Illuminate\View\View
 */
Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');






/**
 * // cambio por IA: Ruta POST para subir imágenes mediante Dropzone JS.
 */
 /* RUTAS INVENTAIO */
/**
 * // cambio por IA: Rutas de recursos CRUD para los Productos.
 * Maneja toda la gestión del inventario básico. Se omite 'show'.
 */
Route::resource('products', ProductController::class)->except(['show']);
Route::post('/products/{product}/dropzone', [ProductController::class, 'dropzone'])->name('products.dropzone');
/**
 * // cambio por IA: Rutas de recursos CRUD para las Categorías.
 * Maneja index, create, store, edit, update, destroy. Se omite 'show'.
 */
Route::resource('categories', CategoryController::class)->except(['show']);
// ruta para almacenes
Route::resource('warehouses', WarehouseController::class)->except('show');

//ruta para VENTAS
Route::resource('customers', CustomerController::class)->except(['show']);

// ruta para COMPRAS
Route::resource('suppliers', SupplierController::class)->except(['show']);
// ordenes de compra
Route::resource('purchase-orders', PurchaseOrderController::class)->only(['index', 'create']);


// ruta para imagenes 
Route::delete('images/{image}', [ImageController::class, 'destroy'])->name('images.destroy');