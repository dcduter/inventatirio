<?php

/**
 * Seeder Principal de la Base de Datos ('DatabaseSeeder').
 * Los Seeders se utilizan para poblar la base de datos con información inicial de prueba o datos maestros (ej: usuario admin por defecto, categorías iniciales).
 * Se ejecuta al usar el comando 'php artisan db:seed' o 'php artisan migrate --seed'.
 * 
 * // cambio por IA
 */

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
