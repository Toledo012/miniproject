<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'slug',
    ];

    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(
            Producto::class,
            'categoria_producto',
            'categoria_id',
            'producto_id'
        );
    }

    public function ventas(): HasManyThrough
    {
        return $this->hasManyThrough(
            Venta::class,
            CategoriaProducto::class,
            'categoria_id',  // FK en categoria_producto → categorias.id
            'producto_id',   // FK en ventas → categoria_producto.producto_id
            'id',            // PK en categorias
            'producto_id'    // clave local en categoria_producto
        );
    }
}
