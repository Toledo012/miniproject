<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->esAdmin();
    }

    public function view(User $user, User $modelo): bool
    {
        return $user->esAdmin();
    }

    public function create(User $user): bool
    {
        return $user->esAdmin();
    }

    public function update(User $user, User $modelo): bool
    {
        return $user->esAdmin();
    }

    public function delete(User $user, User $modelo): bool
    {
        return $user->esAdmin() && $user->id !== $modelo->id;
    }
}
