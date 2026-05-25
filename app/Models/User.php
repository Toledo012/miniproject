<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'rol',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function compras(): HasMany
    {
        return $this->hasMany(Venta::class, 'comprador_id');
    }

    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'vendedor_id');
    }

    public function ventasValidadas(): HasMany
    {
        return $this->hasMany(Venta::class, 'validado_por');
    }

    public function codigosVerificacion(): HasMany
    {
        return $this->hasMany(CodigoVerificacion::class, 'usuario_id');
    }

    public function esAdmin(): bool
    {
        return $this->rol === 'admin';
    }

    public function esGerente(): bool
    {
        return $this->rol === 'gerente';
    }

    public function esVendedor(): bool
    {
        return $this->rol === 'vendedor';
    }

    public function esComprador(): bool
    {
        return $this->rol === 'comprador';
    }
}
