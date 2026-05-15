<?php

namespace Database\Seeders;

use App\Models\Court;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Creamos un Administrador de prueba
        User::factory()->create([
            'name' => 'Admin Ayuntamiento',
            'email' => 'admin@cerromuriano.es',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);
        User::factory()->create([
            'name' => 'Prueba Fran',
            'email' => 'frangilarte07@gmail.com',
            'password' => Hash::make('fran5598'),
            'is_admin' => false,
        ]);


        // 2. Creamos 3 pistas de pádel
        Court::create(['name' => 'Pista 1 - Polideportivo', 'is_active' => true]);
        Court::create(['name' => 'Pista 2 - Piscina', 'is_active' => true]);
    }
}