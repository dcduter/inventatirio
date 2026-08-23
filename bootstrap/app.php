<?php

/**
 * Este archivo configura e inicializa la aplicación Laravel.
 * Define la carga de rutas (web, api, consola, admin), los middlewares globales y el manejo de excepciones.
 * 
 * // cambio por IA
 */

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function (){
            Route::middleware('web', 'auth')
            ->prefix('admin') // inicio con prefijo admin / para acceder a las rutas de admin
            ->name('admin.') // inicio con nombre admin. para acceder a las rutas de admin
            ->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
