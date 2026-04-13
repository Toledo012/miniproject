<?php

namespace App\Models;

use Database\Factories\UsuarioFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    /** @use HasFactory<UsuarioFactory> */
    use HasFactory, Notifiable;

    public const ROL_ADMINISTRADOR = 'administrador';
    public const ROL_GERENTE = 'gerente';
    public const ROL_CLIENTE = 'cliente';

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'apellidos',
        'correo',
        'clave',
        'rol',
    ];

    protected $hidden = [
        'clave',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'clave' => 'hashed',
        ];
    }

    public function getAuthPasswordName(): string
    {
        return 'clave';
    }

    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class);
    }

    public function ventasComoCliente(): HasMany
    {
        return $this->hasMany(Venta::class, 'cliente_id');
    }

    public function ventasComoVendedor(): HasMany
    {
        return $this->hasMany(Venta::class, 'vendedor_id');
    }

    public function categoriasPivot(): HasManyThrough
    {
        return $this->hasManyThrough(
            CategoriaProducto::class,
            Producto::class,
            'usuario_id',
            'producto_id',
            'id',
            'id'
        );
    }

    public function categorias(): BelongsToMany
    {
        return $this->belongsToMany(
            Categoria::class,
            'categoria_producto',
            'producto_id',
            'categoria_id'
        )->join('productos', 'productos.id', '=', 'categoria_producto.producto_id')
            ->where('productos.usuario_id', $this->id)
            ->select('categorias.*')
            ->distinct();
    }

    public function esAdministrador(): bool
    {
        return $this->rol === self::ROL_ADMINISTRADOR;
    }

    public function esGerente(): bool
    {
        return $this->rol === self::ROL_GERENTE;
    }

    public function esCliente(): bool
    {
        return $this->rol === self::ROL_CLIENTE;
    }

    protected static function newFactory(): UsuarioFactory
    {
        return UsuarioFactory::new();
    }
}
