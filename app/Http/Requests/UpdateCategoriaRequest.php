<?php

namespace App\Http\Requests;

use App\Models\Categoria;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Categoria $categoria */
        $categoria = $this->route('categoria');

        return $this->user()?->can('update', $categoria) ?? false;
    }

    public function rules(): array
    {
        /** @var Categoria $categoria */
        $categoria = $this->route('categoria');

        return [
            'nombre' => ['required', 'string', 'min:2', 'max:120', Rule::unique('categorias', 'nombre')->ignore($categoria->id)],
            'descripcion' => ['required', 'string', 'min:5', 'max:1000'],
        ];
    }
}
