<?php

namespace App\Http\Requests;

use App\Models\Venta;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVentaRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Venta $venta */
        $venta = $this->route('venta');

        return $this->user()?->can('update', $venta) ?? false;
    }

    public function rules(): array
    {
        return [
            'producto_id' => ['required', 'exists:productos,id'],
            'cliente_id' => ['required', 'exists:usuarios,id'],
            'vendedor_id' => ['required', 'exists:usuarios,id'],
            'fecha' => ['required', 'date'],
            'total' => ['required', 'numeric', 'min:0'],
        ];
    }
}
