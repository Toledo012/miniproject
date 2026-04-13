<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsuarioSeeder::class,
        ]);

        Usuario::query()->updateOrCreate(
            ['correo' => 'admin@raph.local'],
            [
                'nombre' => 'Admin',
                'apellidos' => 'RAPH',
                'clave' => Hash::make('123'),
                'rol' => Usuario::ROL_ADMINISTRADOR,
            ]
        );

        $gerenteDemo = Usuario::query()->updateOrCreate(
            ['correo' => 'gerente@raph.local'],
            [
                'nombre' => 'Mario',
                'apellidos' => 'Lopez',
                'clave' => Hash::make('123'),
                'rol' => Usuario::ROL_GERENTE,
            ]
        );

        $clienteDemo = Usuario::query()->updateOrCreate(
            ['correo' => 'cliente@raph.local'],
            [
                'nombre' => 'Maria',
                'apellidos' => 'Martinez',
                'clave' => Hash::make('123'),
                'rol' => Usuario::ROL_CLIENTE,
            ]
        );

        $this->call([
            CategoriaSeeder::class,
            ProductoSeeder::class,
        ]);

        $productoVenta = Producto::query()->first();

        if ($productoVenta && ! $clienteDemo->ventasComoCliente()->exists()) {
            $clienteDemo->ventasComoCliente()->create([
                'producto_id' => $productoVenta->id,
                'vendedor_id' => $productoVenta->usuario_id,
                'fecha' => now()->toDateString(),
                'total' => $productoVenta->precio,
            ]);

            if ($productoVenta->existencia > 0) {
                $productoVenta->decrement('existencia');
            }
        }
    }
}
