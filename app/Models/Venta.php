<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';

    protected $fillable = [
        'comprador_id',
        'producto_id',
        'cantidad',
        'total',
        'ticket_ruta',
        'estado',
        'validado_por',
    ];

    protected function casts(): array
    {
        return [
            'cantidad' => 'integer',
            'total' => 'decimal:2',
        ];
    }

    public function comprador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'comprador_id');
    }

    public function gerente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validado_por');
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeValidadas($query)
    {
        return $query->where('estado', 'validada');
    }

    public function scopeRechazadas($query)
    {
        return $query->where('estado', 'rechazada');
    }
}
