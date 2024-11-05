<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return (in_array($user->level, [1, 2]));
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param User $model
     * @return Response|bool
     */
    public function view(User $user, User $model): Response|bool
    {
        return (in_array($model->level, [1, 2]));
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user): Response|bool
    {
        return (in_array($user->level, [1, 2]));
    }


    public function update(User $user, $model): bool
    {
        if ($user->id === $model->id) return true;

        return (in_array($user->level, [1, 2]));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param $model
     * @return bool
     */
    public function delete(User $user, $model): bool
    {
        if ($user->id == $model->id || $model->id === 1) return false;

        return (in_array($user->level, [1, 2]));
    }

}
