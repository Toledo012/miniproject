<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Prueba 2: con credenciales inválidas el login responde con error
     * sobre el campo 'email' y el visitante permanece como invitado.
     */
    public function test_login_incorrecto_muestra_error_y_no_autentica(): void
    {
        User::factory()->comprador()->create([
            'email' => 'real@demo.test',
            'password' => Hash::make('correcta123'),
        ]);

        $response = $this->post(route('login.attempt'), [
            'email' => 'real@demo.test',
            'password' => 'incorrecta-xxx',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Prueba 3: con credenciales válidas el usuario queda autenticado.
     * Para evitar el flujo 2FA en pruebas, se utiliza una cuenta @demo.test
     * (el LoginController tiene un bypass documentado para esos emails).
     */
    public function test_login_correcto_autentica_usuario(): void
    {
        $usuario = User::factory()->comprador()->create([
            'email' => 'comprador@demo.test',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post(route('login.attempt'), [
            'email' => 'comprador@demo.test',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($usuario);
        $response->assertRedirect(route('catalogo'));
    }

    /**
     * Prueba 4: el dashboard administrativo requiere autenticación.
     * Un invitado es redirigido a /login y un comprador autenticado
     * recibe 403 porque la ruta exige el permiso 'acceder-dashboard'.
     */
    public function test_dashboard_requiere_autenticacion(): void
    {
        $this->get(route('dashboard'))
            ->assertRedirect(route('login'));

        $comprador = User::factory()->comprador()->create();

        $this->actingAs($comprador)
            ->get(route('dashboard'))
            ->assertForbidden();
    }
}
