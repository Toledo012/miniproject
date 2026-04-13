<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $vendedores = Usuario::query()
            ->whereIn('rol', [Usuario::ROL_ADMINISTRADOR, Usuario::ROL_GERENTE])
            ->get();

        if ($vendedores->isEmpty()) {
            return;
        }

        $productos = [
            ['nombre' => 'Monitor Studio 27', 'descripcion' => 'Pantalla amplia con perfil limpio para trabajo visual y oficina.', 'precio' => 8999.00, 'existencia' => 9],
            ['nombre' => 'Teclado Inalambrico', 'descripcion' => 'Teclas de perfil bajo y conexion estable para escritorio moderno.', 'precio' => 1499.00, 'existencia' => 20],
            ['nombre' => 'Mouse Precision', 'descripcion' => 'Seguimiento suave y ergonomia para jornadas prolongadas.', 'precio' => 1199.00, 'existencia' => 24],
            ['nombre' => 'Lampara Desk Light', 'descripcion' => 'Iluminacion regulable para estudio y trabajo nocturno.', 'precio' => 899.00, 'existencia' => 16],
        ];

        $categorias = Categoria::query()->pluck('id');

        foreach ($productos as $index => $datos) {
            $producto = Producto::query()->firstOrCreate(
                ['nombre' => $datos['nombre']],
                array_merge($datos, [
                    'usuario_id' => $vendedores[$index % $vendedores->count()]->id,
                ])
            );

            if ($categorias->isNotEmpty()) {
                $producto->categorias()->syncWithoutDetaching($categorias->shuffle()->take(2)->all());
            }
        }
    }
}
