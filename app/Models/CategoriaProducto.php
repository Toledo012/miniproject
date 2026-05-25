<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaProducto extends Model
{
    protected $table = 'categoria_producto';

    public $timestamps = false;

    protected $fillable = [
        'categoria_id',
        'producto_id',
    ];
}
