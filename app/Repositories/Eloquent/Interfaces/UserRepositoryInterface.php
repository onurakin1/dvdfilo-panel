<?php

namespace App\Repositories\Eloquent\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getAuthUser(): User;

    public function updateAuthUser(array $attributes): User;
}
