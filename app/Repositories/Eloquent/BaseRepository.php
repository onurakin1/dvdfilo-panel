<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\Interfaces\EloquentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
    /**
     * @var Model
     */
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model::all();
    }

    public function get(?array $where = null,?string $orderBy = null): Collection
    {
        return $this->model::query()->where($where)->when($orderBy, function ($q, $v) {
            $q->orderBy($v);
        })->get();
    }

    public function paginate(?object $filters = null, ?string $sortField = null, bool $sortAsc = true, int $pageSize = 24): LengthAwarePaginator
    {
            return $this->model::query()->paginate($pageSize);
    }

    public function firstOrCreate( array $first_attributes,array $create_attributes): Model
    {
        return $this->model::query()->firstOrCreate($first_attributes, $create_attributes);
    }

    public function find(int $id, array $select = ['*']): Model
    {
        return $this->model::query()->select($select)->findOrFail($id);
    }

    public function create(array $attributes): Model
    {
        $model = $this->model;
        $model->fill($attributes)->save();

        return $model;
    }

    public function update(int $id, array $attributes): Model
    {
        $model = $this->find($id);
        $model->update($attributes);

        return $model;
    }

    public function save(?int $id, array $attributes): Model
    {
        if ((int)$id > 0) {
            return $this->update($id, $attributes);
        } else {
            return $this->create($attributes);
        }
    }

    public function saveMany(array $data)
    {
        foreach ($data as $item) $this->model::query()->create($item);
    }

    public function insert(array $data)
    {
      $this->model::query()->insert($data);
    }

    public function delete(int $id): int
    {
        return $this->find($id)->delete();
    }

    public function truncate()
    {
        $this->model::query()->truncate();
    }

    public function getModelClass(): string
    {
        return get_class($this->model);
    }

    public function query(): Builder
    {
        return $this->model::query();
    }

}
