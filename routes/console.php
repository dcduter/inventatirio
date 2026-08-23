<?php

/**
 * Comandos de Consola / Artisan.
 * En este archivo se registran comandos personalizados de consola basados en cierres (closures)
 * o tareas programadas (scheduled tasks) ejecutables mediante 'php artisan nombre:comando'.
 * 
 * // cambio por IA
 */

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
