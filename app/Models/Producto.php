<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'existencia',
        'usuario_id',
        'imagen',
    ];

    protected $appends = [
        'imagen_url',
    ];

    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
        ];
    }

    public function vendedor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function categorias(): BelongsToMany
    {
        return $this->belongsToMany(Categoria::class, 'categoria_producto');
    }

    public function ventas(): HasMany
    {
        return $this->hasMany(Venta::class);
    }

    public function getImagenUrlAttribute(): ?string
    {
        if (! $this->imagen) {
            return null;
        }

        return Storage::url($this->imagen);
    }
}
