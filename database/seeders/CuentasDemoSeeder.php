<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CuentasDemoSeeder extends Seeder
{
    /**
     * Cuentas de prueba — una por rol.
     * Todas usan password: "password"
     */
    public function run(): void
    {
        $cuentas = [
            ['nombre' => 'Administrador Demo', 'email' => 'admin@demo.test',     'rol' => 'admin'],
            ['nombre' => 'Gerente Demo',       'email' => 'gerente@demo.test',   'rol' => 'gerente'],
            ['nombre' => 'Vendedor Demo',      'email' => 'vendedor@demo.test',  'rol' => 'vendedor'],
            ['nombre' => 'Comprador Demo',     'email' => 'comprador@demo.test', 'rol' => 'comprador'],
        ];

        foreach ($cuentas as $c) {
            User::updateOrCreate(
                ['email' => $c['email']],
                [
                    'nombre'   => $c['nombre'],
                    'password' => Hash::make('password'),
                    'rol'      => $c['rol'],
                ]
            );
        }

        $this->command?->info('✓ Cuentas demo creadas / actualizadas:');
        foreach ($cuentas as $c) {
            $this->command?->line("  · {$c['rol']}: {$c['email']} / password");
        }
    }
}
