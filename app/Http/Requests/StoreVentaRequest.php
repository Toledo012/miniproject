<?php

namespace App\Http\Requests;

use App\Models\Venta;
use Illuminate\Foundation\Http\FormRequest;

class StoreVentaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Venta::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'producto_id' => ['required', 'exists:productos,id'],
            'cliente_id' => ['nullable', 'exists:usuarios,id'],
            'fecha' => ['required', 'date'],
            'total' => ['required', 'numeric', 'min:0'],
        ];
    }
}
