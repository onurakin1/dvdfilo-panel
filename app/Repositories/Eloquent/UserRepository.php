<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Eloquent\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function find(int $id, array $select = ['*']): User
    {
        return $this->model::query()->select($select)->notSys()->findOrFail($id);
    }

    public function getAuthUser(): User
    {
        return $this->model::query()->findOrFail(Auth::user()->id);
    }

    public function updateAuthUser(array $attributes): User
    {
        $model = $this->getAuthUser();

        if (isset($attributes['password']) && !empty($attributes['password'])) {
            $attributes['password'] = bcrypt($attributes['password']);
        } else {
            unset($attributes['password']);
        }
        $model->update($attributes);

        return $model;
    }

    public function findByUsername(string $slug, array $select = ['*'])
    {
        return $this->model::query()->where('username', $slug)->select($select)->first();
    }

    public function create(array $attributes): User
    {
        $full_name = $attributes['first_name'] || $attributes['last_name'] ? $attributes['first_name'] . ' ' . $attributes['last_name'] : $attributes['username'];
        $attributes['password'] = bcrypt($attributes['password']);
        $attributes['display_name'] = $full_name;
        $attributes['email_verified_at'] = now();

        return $this->model::query()->create($attributes);
    }

    public function update(int $id, array $attributes): User
    {
        $model = $this->find($id);
        if (isset($attributes['password']) && !empty($attributes['password'])) {
            $attributes['password'] = bcrypt($attributes['password']);
        } else {
            unset($attributes['password']);
        }
        $model->update($attributes);

        return $model;
    }

    public function paginate(?object $filters = null, ?string $sortField = null, bool $sortAsc = true, int $pageSize = 20): LengthAwarePaginator
    {
        return $this->model::query()
            ->when(($filters->search), function ($q, $s) {
                $q
                    ->orWhere('first_name', 'like', '%' . $s . '%')
                    ->orWhere('last_name', 'like', '%' . $s . '%')
                    ->orWhere('nick_name', 'like', '%' . $s . '%')
                    ->orWhere('username', 'like', '%' . $s . '%')
                    ->orWhere('display_name', 'like', '%' . $s . '%')
                    ->orWhere('email', 'like', '%' . $s . '%');
            })
            ->when($filters->level, function ($q, $l) {
                $q->where('level', $l);
            })
            ->when($filters->role, function ($q, $r) {
                $q->where('level', $r);
            })
            ->notSys()
            ->orderBy('id', 'desc')
            ->paginate($filters->limit ?? $pageSize);
    }
}
