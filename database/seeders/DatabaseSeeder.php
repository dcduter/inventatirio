<?php

/**
 * Seeder Principal de la Base de Datos ('DatabaseSeeder').
 * Los Seeders se utilizan para poblar la base de datos con información inicial de prueba o datos maestros (ej: usuario admin por defecto, categorías iniciales).
 * Se ejecuta al usar el comando 'php artisan db:seed' o 'php artisan migrate --seed'.
 * 
 * // cambio por IA
 */

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use App\Models\Supplier;
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
            'name' => 'Juan',
            'email' => 'juan@correo.com',
            'password' => bcrypt('12345678')
        ]);

        $this->call([
            IdentitySeeder::class,
            categorySeeder::class
        ]);

        Customer::factory(50)->create();
        Supplier::factory(50)->create();
        

 
        // genera producto por factory 100
        Product::factory(100)->create();
    }
}
