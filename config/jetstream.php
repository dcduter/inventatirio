<?php

/**
 * Archivo de Configuración de Jetstream.
 * Jetstream es un framework de inicio que proporciona una autenticación completa (Login, Registro, Perfil, 2FA, Sesiones) para aplicaciones Laravel.
 * 
 * Principales secciones:
 * - stack: Define la tecnología del frontend ('livewire' o 'inertia'). En este caso usa Livewire.
 * - middleware: Configura los middlewares globales para las rutas de Jetstream.
 * - auth_session: Clase que maneja la autenticación con sesión.
 * - guard: Configura el guard de autenticación por defecto (sanctum para API, web para sesiones).
 * - features: Panel de control para activar/desactivar características como fotos de perfil, API tokens, equipos o eliminación de cuentas.
 * - profile_photo_disk: El sistema de archivos donde se almacenarán las fotos de perfil (public/ para acceso web directo).
 * 
 * // cambio por IA
 */

use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Middleware\AuthenticateSession;

return [

    /*
    |--------------------------------------------------------------------------
    | Jetstream Stack
    |--------------------------------------------------------------------------
    |
    | This configuration value informs Jetstream which "stack" you will be
    | using for your application. In general, this value is set for you
    | during installation and will not need to be changed after that.
    |
    */

    'stack' => 'livewire',

    /*
    |--------------------------------------------------------------------------
    | Jetstream Route Middleware
    |--------------------------------------------------------------------------
    |
    | Here you may specify which middleware Jetstream will assign to the routes
    | that it registers with the application. When necessary, you may modify
    | these middleware; however, this default value is usually sufficient.
    |
    */

    'middleware' => ['web'],

    'auth_session' => AuthenticateSession::class,

    /*
    |--------------------------------------------------------------------------
    | Jetstream Guard
    |--------------------------------------------------------------------------
    |
    | Here you may specify the authentication guard Jetstream will use while
    | authenticating users. This value should correspond with one of your
    | guards that is already present in your "auth" configuration file.
    |
    */

    'guard' => 'sanctum',

    /*
    |--------------------------------------------------------------------------
    | Features
    |--------------------------------------------------------------------------
    |
    | Some of Jetstream's features are optional. You may disable the features
    | by removing them from this array. You're free to only remove some of
    | these features or you can even remove all of these if you need to.
    |
    */

    'features' => [
        // Features::termsAndPrivacyPolicy(),
         Features::profilePhotos(),
        // Features::api(),
        // Features::teams(['invitations' => true]),
        Features::accountDeletion(),
    ],

    /*
    |--------------------------------------------------------------------------
    | Profile Photo Disk
    |--------------------------------------------------------------------------
    |
    | This configuration value determines the default disk that will be used
    | when storing profile photos for your application's users. Typically
    | this will be the "public" disk but you may adjust this if needed.
    |
    */

    'profile_photo_disk' => 'public',

];
