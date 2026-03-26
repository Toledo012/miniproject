<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_anonymous_user_can_view_home_but_not_protected_routes(): void
    {
        $this->get('/')->assertOk();
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_client_cannot_access_employee_or_manager_routes(): void
    {
        $client = User::factory()->cliente()->create();

        $this->actingAs($client)->get('/empleado/dashboard')->assertForbidden();
        $this->actingAs($client)->get('/gerente/usuarios')->assertForbidden();
    }

    public function test_employee_cannot_access_manager_user_administration(): void
    {
        $employee = User::factory()->empleado()->create();

        $this->actingAs($employee)->get('/gerente/usuarios')->assertForbidden();
    }

    public function test_manager_can_access_manager_routes(): void
    {
        $manager = User::factory()->gerente()->create();

        $this->actingAs($manager)->get('/gerente/dashboard')->assertOk();
        $this->actingAs($manager)->get('/gerente/usuarios')->assertOk();
        $this->actingAs($manager)->get('/empleado/dashboard')->assertOk();
    }
}
