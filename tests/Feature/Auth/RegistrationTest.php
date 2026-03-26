<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('client.products.index', absolute: false));

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'role' => User::ROLE_CLIENTE,
        ]);
    }

    public function test_role_from_payload_is_ignored_on_public_registration(): void
    {
        $response = $this->post('/register', [
            'name' => 'Manager Attempt',
            'email' => 'manager-attempt@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => User::ROLE_GERENTE,
        ]);

        $response->assertRedirect(route('client.products.index', absolute: false));
        $this->assertDatabaseHas('users', [
            'email' => 'manager-attempt@example.com',
            'role' => User::ROLE_CLIENTE,
        ]);
    }
}
