<?php

namespace App\Http\Requests;

use App\Models\Usuario;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Usuario::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'min:2', 'max:100'],
            'apellidos' => ['required', 'string', 'min:2', 'max:100'],
            'correo' => ['required', 'string', 'email', 'max:255', 'unique:usuarios,correo'],
            'clave' => ['required', 'string', 'min:3', 'max:255', 'confirmed'],
            'rol' => ['required', Rule::in([
                Usuario::ROL_ADMINISTRADOR,
                Usuario::ROL_GERENTE,
                Usuario::ROL_CLIENTE,
            ])],
        ];
    }
}
