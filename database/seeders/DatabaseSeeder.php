<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->admin()->create([
            'nombre' => 'Admin',
            'email' => 'admin@miniproyecto3.test',
            'password' => Hash::make('password'),
        ]);

        User::factory()->gerente()->create([
            'nombre' => 'Gerente',
            'email' => 'gerente@miniproyecto3.test',
            'password' => Hash::make('password'),
        ]);

        User::factory()->vendedor()->count(30)->create();
        User::factory()->comprador()->count(70)->create();

        $this->call([
            CategoriaSeeder::class,
            ProductoSeeder::class,
            VentaSeeder::class,
        ]);
    }
}
