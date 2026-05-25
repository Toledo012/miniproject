<?php

namespace Tests\Feature;

use App\Mail\CodigoVerificacionMail;
use App\Models\CodigoVerificacion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AuthDosFactoresTest extends TestCase
{
    use RefreshDatabase;

    public function test_credenciales_validas_emiten_codigo_y_redirigen_a_verificacion(): void
    {
        Mail::fake();

        $usuario = User::factory()->cliente()->create([
            'email' => 'cliente@test.local',
            'password' => Hash::make('secreto123'),
        ]);

        $this
            ->post(route('login.attempt'), [
                'email' => 'cliente@test.local',
                'password' => 'secreto123',
            ])
            ->assertRedirect(route('verificar.form'))
            ->assertSessionHas('2fa_usuario_id', $usuario->id);

        $this->assertGuest();
        $this->assertSame(1, CodigoVerificacion::where('usuario_id', $usuario->id)->count());
        Mail::assertSent(CodigoVerificacionMail::class, fn ($m) => $m->hasTo($usuario->email));
    }

    public function test_credenciales_invalidas_no_emiten_codigo(): void
    {
        Mail::fake();

        User::factory()->cliente()->create([
            'email' => 'cliente@test.local',
            'password' => Hash::make('secreto123'),
        ]);

        $this
            ->post(route('login.attempt'), [
                'email' => 'cliente@test.local',
                'password' => 'mala',
            ])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
        $this->assertSame(0, CodigoVerificacion::count());
        Mail::assertNothingSent();
    }

    public function test_codigo_correcto_inicia_sesion_y_borra_registro(): void
    {
        Mail::fake();

        $usuario = User::factory()->cliente()->create();
        $codigo = '123456';
        CodigoVerificacion::create([
            'usuario_id' => $usuario->id,
            'codigo' => Hash::make($codigo),
            'expiracion' => now()->addMinutes(5),
        ]);

        $this->withSession(['2fa_usuario_id' => $usuario->id])
            ->post(route('verificar.attempt'), ['codigo' => $codigo])
            ->assertRedirect(route('productos.index'));

        $this->assertAuthenticatedAs($usuario);
        $this->assertSame(0, CodigoVerificacion::where('usuario_id', $usuario->id)->count());
    }

    public function test_codigo_admin_redirige_a_dashboard(): void
    {
        $admin = User::factory()->admin()->create();
        $codigo = '654321';
        CodigoVerificacion::create([
            'usuario_id' => $admin->id,
            'codigo' => Hash::make($codigo),
            'expiracion' => now()->addMinutes(5),
        ]);

        $this->withSession(['2fa_usuario_id' => $admin->id])
            ->post(route('verificar.attempt'), ['codigo' => $codigo])
            ->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($admin);
    }

    public function test_codigo_invalido_no_inicia_sesion(): void
    {
        $usuario = User::factory()->cliente()->create();
        CodigoVerificacion::create([
            'usuario_id' => $usuario->id,
            'codigo' => Hash::make('111111'),
            'expiracion' => now()->addMinutes(5),
        ]);

        $this->withSession(['2fa_usuario_id' => $usuario->id])
            ->post(route('verificar.attempt'), ['codigo' => '999999'])
            ->assertSessionHasErrors('codigo');

        $this->assertGuest();
    }

    public function test_codigo_expirado_devuelve_a_login(): void
    {
        $usuario = User::factory()->cliente()->create();
        CodigoVerificacion::create([
            'usuario_id' => $usuario->id,
            'codigo' => Hash::make('222222'),
            'expiracion' => now()->subMinute(),
        ]);

        $this->withSession(['2fa_usuario_id' => $usuario->id])
            ->post(route('verificar.attempt'), ['codigo' => '222222'])
            ->assertRedirect(route('login'));

        $this->assertGuest();
        $this->assertSame(0, CodigoVerificacion::where('usuario_id', $usuario->id)->count());
    }
}
