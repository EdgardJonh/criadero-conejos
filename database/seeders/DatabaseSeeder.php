<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Conejo;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario de prueba
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        // Crear conejos de prueba
        $conejos = [
            [
                'nombre' => 'Luna',
                'foto_principal' => 'conejos/default-1.jpg',
                'fotos_adicionales' => ['conejos/default-1-1.jpg', 'conejos/default-1-2.jpg'],
                'numero' => 'C001',
                'raza' => 'Holandés Enano',
                'color' => 'Blanco y negro',
                'sexo' => 'Hembra',
                'fecha_nacimiento' => '2024-01-15',
                'descripcion' => 'Coneja muy cariñosa y juguetona. Perfecta para mascota familiar.',
                'precio' => 45.00,
                'disponible' => true,
            ],
            [
                'nombre' => 'Max',
                'foto_principal' => 'conejos/default-2.jpg',
                'fotos_adicionales' => ['conejos/default-2-1.jpg'],
                'numero' => 'C002',
                'raza' => 'Angora',
                'color' => 'Gris',
                'sexo' => 'Macho',
                'fecha_nacimiento' => '2023-11-20',
                'descripcion' => 'Conejo de pelo largo, muy suave y tranquilo.',
                'precio' => 60.00,
                'disponible' => true,
            ],
            [
                'nombre' => 'Bella',
                'foto_principal' => 'conejos/default-3.jpg',
                'fotos_adicionales' => [],
                'numero' => 'C003',
                'raza' => 'Rex',
                'color' => 'Marrón',
                'sexo' => 'Hembra',
                'fecha_nacimiento' => '2024-02-10',
                'descripcion' => 'Coneja Rex con pelaje aterciopelado y personalidad dulce.',
                'precio' => 55.00,
                'disponible' => false,
            ],
        ];

        foreach ($conejos as $conejoData) {
            Conejo::create($conejoData);
        }
    }
}
