<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $nombres = [
            'Laptops', 'Smartphones', 'Tablets', 'Monitores',
            'Periféricos', 'Audio', 'Cámaras', 'Accesorios',
        ];

        foreach ($nombres as $nombre) {
            Categoria::firstOrCreate(
                ['nombre' => $nombre],
                ['slug' => Str::slug($nombre)],
            );
        }
    }
}
