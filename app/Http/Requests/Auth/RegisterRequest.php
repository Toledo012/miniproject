<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'min:2', 'max:100'],
            'apellidos' => ['required', 'string', 'min:2', 'max:100'],
            'correo' => ['required', 'string', 'email', 'max:255', Rule::unique('usuarios', 'correo')],
            'clave' => ['required', 'string', 'min:3', 'max:255', 'confirmed'],
        ];
    }
}
