<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class categorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories =[

            [
                'name' => 'Electronicos',
                'description' =>'Productos electronicos',
            ],

            [
                'name' => 'Ropa',
                'description' =>'Productos de vestir',
            ],

            [
                'name' => 'Alimentos',
                'description' =>'Productos alimenticios',
            ],
        ];

        // foreach recorre el array y crea un registro en la base de datos
        foreach ($categories as $category) {

            // se crea en categoria
            Category::create($category);
        }
    }
}
