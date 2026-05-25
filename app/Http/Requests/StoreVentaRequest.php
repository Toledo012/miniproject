<?php

namespace App\Http\Requests;

use App\Models\Producto;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreVentaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'producto_id' => ['required', 'integer', 'exists:productos,id'],
            'cantidad' => ['required', 'integer', 'min:1'],
            'ticket' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:4096'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $productoId = $this->input('producto_id');
            if (! $productoId) {
                return;
            }

            $producto = Producto::find($productoId);
            if ($producto && $producto->vendedor_id === $this->user()?->id) {
                $validator->errors()->add('producto_id', 'No puedes comprar un producto publicado por ti.');
            }
        });
    }
}
