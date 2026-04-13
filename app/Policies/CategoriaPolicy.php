<?php

namespace App\Policies;

use App\Models\Categoria;
use App\Models\Usuario;

class CategoriaPolicy
{
    public function viewAny(Usuario $usuario): bool
    {
        return in_array($usuario->rol, [
            Usuario::ROL_ADMINISTRADOR,
            Usuario::ROL_GERENTE,
            Usuario::ROL_CLIENTE,
        ], true);
    }

    public function view(Usuario $usuario, Categoria $categoria): bool
    {
        return $this->viewAny($usuario);
    }

    public function create(Usuario $usuario): bool
    {
        return $usuario->esAdministrador() || $usuario->esGerente();
    }

    public function update(Usuario $usuario, Categoria $categoria): bool
    {
        return $this->create($usuario);
    }

    public function delete(Usuario $usuario, Categoria $categoria): bool
    {
        return $this->create($usuario);
    }
}
