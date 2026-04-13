<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::query()->updateOrCreate(
            ['correo' => 'admin@raph.local'],
            [
                'nombre' => 'Admin',
                'apellidos' => 'RAPH',
                'clave' => Hash::make('123'),
                'rol' => Usuario::ROL_ADMINISTRADOR,
            ]
        );

        Usuario::factory(6)->create();
    }
}
