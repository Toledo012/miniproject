<?php

namespace App\Http\Requests;

use App\Models\Producto;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Producto::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'min:2', 'max:255'],
            'descripcion' => ['required', 'string', 'min:5'],
            'precio' => ['required', 'numeric', 'min:0'],
            'existencia' => ['required', 'integer', 'min:0', 'max:99999'],
            'categoria_ids' => ['required', 'array', 'min:1'],
            'categoria_ids.*' => ['required', 'exists:categorias,id'],
            'imagen' => ['nullable', 'image', 'max:5120'],
        ];
    }
}
