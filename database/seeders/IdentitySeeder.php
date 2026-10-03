<?php

namespace Database\Seeders;

use App\Models\Identity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IdentitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $identities = [

            'Sin documento',
            'Cédula de identidad',
            'Pasaporte',
            'Permiso temporal de permanencia',
            'Permiso especial de permanencia',
            'RUC'
        ];

        foreach($identities as $identtity){
            Identity::create([
                'name' => $identtity,
            ]);
        }
    }
}
