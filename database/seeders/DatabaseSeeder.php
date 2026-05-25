<?php

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
            'name' => 'Administrador',
            'email' => 'admin@albergue.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Patitas Felices',
            'email' => 'contacto@patitasfelices.org',
            'password' => bcrypt('password'),
            'role' => 'refugio',
            'telefono' => '073-1234',
            'direccion' => 'Av. Seamos Felices 123',
            'descripcion' => 'Refugio dedicado al rescate de animales callejeros',
        ]);

        User::factory()->create([
            'name' => 'Carlos Gomez',
            'email' => 'Carlos@example.com',
            'password' => bcrypt('password'),
            'role' => 'usuario',
        ]);
    }
}
