<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Tecnologia', 'descripcion' => 'Dispositivos y accesorios de uso personal y profesional.'],
            ['nombre' => 'Hogar', 'descripcion' => 'Productos pensados para confort, orden y funcionalidad.'],
            ['nombre' => 'Oficina', 'descripcion' => 'Articulos para estaciones de trabajo eficientes.'],
            ['nombre' => 'Movilidad', 'descripcion' => 'Soluciones utiles para trayectos y rutina diaria.'],
            ['nombre' => 'Accesorios', 'descripcion' => 'Complementos versatiles para distintos escenarios de compra.'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::query()->firstOrCreate(
                ['nombre' => $categoria['nombre']],
                ['descripcion' => $categoria['descripcion']]
            );
        }
    }
}
