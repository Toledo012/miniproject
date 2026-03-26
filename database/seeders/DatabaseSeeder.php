<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate([
            'email' => 'gerente@tienda.local',
        ], [
            'name' => 'Gerente Inicial',
            'password' => Hash::make('password'),
            'role' => User::ROLE_GERENTE,
        ]);

        User::factory()->cliente()->create([
            'name' => 'Cliente Demo',
            'email' => 'cliente@tienda.local',
        ]);

        User::factory()->empleado()->create([
            'name' => 'Empleado Demo',
            'email' => 'empleado@tienda.local',
        ]);

        Product::factory(8)->create([
            'is_active' => true,
        ]);
    }
}
