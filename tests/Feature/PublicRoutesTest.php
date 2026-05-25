<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicRoutesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * La página principal (catálogo público) debe responder con HTTP 200
     * para cualquier visitante, incluso sin autenticación.
     */
    public function test_pagina_principal_responde_correctamente(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * La página de login debe responder con HTTP 200 para invitados
     * y mostrar el formulario de inicio de sesión.
     */
    public function test_pagina_de_login_responde_correctamente(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertSee('Iniciar sesión', escape: false);
    }
}
