<?php

namespace App\Repositories\Eloquent\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface EloquentRepositoryInterface
 * @package App\Repositories
 */
interface EloquentRepositoryInterface
{
    public function all(): Collection;

    public function get(?array $where = null,?string $orderBy = null): Collection;

    public function paginate(?object $filters = null, ?string $sortField = null, bool $sortAsc = true, int $pageSize = 24): LengthAwarePaginator;

    public function find(int $id, array $select = ['*']): Model;

    public function create(array $attributes): Model;

    public function firstOrCreate(array $first_attributes,array $create_attributes): Model;

    public function update(int $id, array $attributes): Model;

    public function save(?int $id, array $attributes): Model;

    public function saveMany(array $data);

    public function insert(array $data);

    public function delete(int $id): int;

    public function truncate();

    public function getModelClass(): string;

    public function query(): Builder;
}
