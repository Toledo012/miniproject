<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<Usuario>
 */
class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    protected static int $indice = 0;

    public function definition(): array
    {
        $nombres = ['Juan', 'Mario', 'Maria', 'Pedro'];
        $apellidos = ['Lopez', 'Sanchez', 'Hernandez', 'Martinez'];
        $combinaciones = [];

        foreach ($nombres as $nombreDisponible) {
            foreach ($apellidos as $apellidoDisponible) {
                $combinaciones[] = [$nombreDisponible, $apellidoDisponible];
            }
        }

        [$nombre, $apellido] = $combinaciones[self::$indice % count($combinaciones)];
        self::$indice++;

        return [
            'nombre' => $nombre,
            'apellidos' => $apellido,
            'correo' => strtolower(substr($nombre, 0, 1).$apellido).'@tuxtla.tecnm.mx',
            'clave' => Hash::make('123'),
            'rol' => fake()->randomElement([Usuario::ROL_CLIENTE, Usuario::ROL_GERENTE]),
            'remember_token' => Str::random(10),
        ];
    }
}
