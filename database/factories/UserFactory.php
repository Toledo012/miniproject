<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    protected static ?string $defaultPassword = null;

    public function definition(): array
    {
        return [
            'nombre' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$defaultPassword ??= Hash::make('password'),
            'rol' => 'comprador',
        ];
    }

    public function admin(): static
    {
        return $this->state(fn () => ['rol' => 'admin']);
    }

    public function gerente(): static
    {
        return $this->state(fn () => ['rol' => 'gerente']);
    }

    public function vendedor(): static
    {
        return $this->state(fn () => ['rol' => 'vendedor']);
    }

    public function comprador(): static
    {
        return $this->state(fn () => ['rol' => 'comprador']);
    }
}
