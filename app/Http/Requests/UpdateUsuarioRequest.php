<?php

namespace App\Http\Requests;

use App\Models\Usuario;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Usuario $objetivo */
        $objetivo = $this->route('usuario');

        return $this->user()?->can('update', $objetivo) ?? false;
    }

    public function rules(): array
    {
        /** @var Usuario $objetivo */
        $objetivo = $this->route('usuario');

        return [
            'nombre' => ['required', 'string', 'min:2', 'max:100'],
            'apellidos' => ['required', 'string', 'min:2', 'max:100'],
            'correo' => ['required', 'string', 'email', 'max:255', Rule::unique('usuarios', 'correo')->ignore($objetivo->id)],
            'clave' => ['nullable', 'string', 'min:3', 'max:255', 'confirmed'],
            'rol' => ['required', Rule::in([
                Usuario::ROL_ADMINISTRADOR,
                Usuario::ROL_GERENTE,
                Usuario::ROL_CLIENTE,
            ])],
        ];
    }
}
